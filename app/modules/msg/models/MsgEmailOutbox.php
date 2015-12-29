<?php

/**
 * This is the model class for table "{{msg_email_outbox}}".
 *
 * The followings are the available columns in table '{{msg_email_outbox}}':
 * @property integer $id
 *  @property integer $sent_by
 * @property string $from_name
 * @property string $from_email
 * @property string $to_email
 * @property string $to_name
 * @property string $subject
 * @property string $message
 * @property string $date_created
 * @property string $date_queued
 */
class MsgEmailOutbox extends ActiveRecord {

        const SENDTYPE_ALL_STAFF = 'all_staff';
        //scenarios
        const SCENARIO_MASS_EMAIL = 'mass_email';

        /**
         * Paths to uploaded images
         * @var type
         */
        public $attachments = array();

        /**
         *
         * @var type
         */
        public $send_type;

        /**
         * Returns the static model of the specified AR class.
         * @param string $className active record class name.
         * @return MsgEmailOutbox the static model class
         */
        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return '{{msg_email_outbox}}';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('from_email, subject, message', 'required'),
                    array('to_email', 'required', 'on' => self::SCENARIO_CREATE),
                    array('sent_by', 'numerical', 'integerOnly' => true),
                    array('from_name,to_name', 'length', 'max' => 60),
                    array('from_email, to_email', 'length', 'max' => 128),
                    array('subject', 'length', 'max' => 255),
                    array('date_created,send_type', 'safe'),
                    array('message', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')), //html purification
                    array('id,' . self::SEARCH_FIELD, 'safe', 'on' => self::SCENARIO_SEARCH),
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
                return array(
                    'id' => 'ID',
                    'from_name' => 'From Name',
                    'from_email' => 'From Email',
                    'to_email' => 'To Email',
                    'to_name' => 'To Name',
                    'subject' => 'Subject',
                    'message' => 'Message',
                    'date_created' => 'Date Created',
                    'date_queued' => 'Date Queued',
                    'send_type' => 'Type',
                    'sent_by' => 'Sent By',
                );
        }

        public function afterSave()
        {
                return parent::afterSave();
        }

        public function afterValidate()
        {
                if (!$this->hasErrors()) {
                        $this->pushEmails();
                }
                return parent::afterValidate();
        }

        /**
         * Process the email queue
         * This functions should be run by console command
         */
        public function processQueue()
        {
                $queueList = ConsoleTaskQueue::model()->getQueue(ConsoleTasks::TASK_SEND_EMAIL);
                foreach ($queueList as $queue) {
                        $this->sendEMail($queue);
                }
        }

        /**
         * @param array $queue
         * Send email using {@link SwiftMailer} extension
         */
        public function sendEMail($queue)
        {
                $mailer = Yii::app()->mailer;
                //set properties
                $settings = Yii::app()->settings->get(Constants::CATEGORY_EMAIL, array(
                    Constants::KEY_EMAIL_MAILER,
                    Constants::KEY_EMAIL_HOST,
                    Constants::KEY_EMAIL_PORT,
                    Constants::KEY_EMAIL_USERNAME,
                    Constants::KEY_EMAIL_PASSWORD,
                    Constants::KEY_EMAIL_SECURITY,
                    Constants::KEY_EMAIL_SENDMAIL_COMMAND,
                ));
                $mailer->mailer = $settings[Constants::KEY_EMAIL_MAILER];
                // For SMTP
                if ($mailer->mailer === 'smtp') {
                        $mailer->host = $settings[Constants::KEY_EMAIL_HOST];
                        $mailer->port = (int) $settings[Constants::KEY_EMAIL_PORT];
                        $mailer->username = $settings[Constants::KEY_EMAIL_USERNAME];
                        $mailer->password = $settings[Constants::KEY_EMAIL_PASSWORD];
                        $mailer->security = $settings[Constants::KEY_EMAIL_SECURITY];
                } else if ($mailer->mailer === 'sendmail') {
                        $mailer->sendmailCommand = $settings[Constants::KEY_EMAIL_SENDMAIL_COMMAND];
                }
                $email = unserialize($queue['params']);

                $mailer->Subject = $email['subject'];
                $mailer->From = array($email['from_email'] => $email['from_name']);
                $result = $mailer
                        ->AddAddresses(explode(',', $email['to_email']))
                        ->MsgHTML($email['message'])
                        //->AddFiles($email['attachments'])
                        ->Send();

                if ($result) {
                        $this->addRecord(array(
                            'sent_by' => !empty($email['sent_by']) ? $email['sent_by'] : NULL,
                            'from_name' => $email['from_name'],
                            'from_email' => $email['from_email'],
                            'subject' => $email['subject'],
                            'message' => $email['message'],
                            'date_queued' => $queue['date_created'],
                                ), FALSE);
                        ConsoleTaskQueue::model()->pop($queue['id']);
                } else if ($queue['attempts'] < $queue['max_attempts']) {
                        ConsoleTaskQueue::model()->incrementAttempts($queue['id'], $queue['attempts']);
                } else {
                        ConsoleTaskQueue::model()->pop($queue['id']);
                }
        }

        /**
         * Push emails to be sent to the task queue
         */
        protected function pushEmails()
        {
                $emails = $this->getUsersEmailContacts($this->send_type);
                foreach ($emails as $email) {
                        $this->push(array(
                            'sent_by' => $this->sent_by,
                            'from_name' => $this->from_name,
                            'from_email' => $this->from_email,
                            'to_email' => $email,
                            'subject' => $this->subject,
                            'message' => $this->message,
                            'attachments' => $this->attachments,
                        ));
                }
        }

        public function push($params)
        {
                ConsoleTaskQueue::model()->push(ConsoleTasks::TASK_SEND_EMAIL, $params);
        }

        public function getUsersEmailContacts($type)
        {
                //get user email,
                $condition = '';
                $params = array();
                if ($type === self::SENDTYPE_ALL_STAFF) {
                        $condition = '`user_level`<> :user_level';
                        $params[':user_level'] = UserLevels::LEVEL_MEMBER;
                }

                return Users::model()->getColumnData('email', $condition, $params);
        }

        public function sendTypeOptions()
        {
                return array(
                    self::SENDTYPE_ALL_STAFF => Common::expandString(self::SENDTYPE_ALL_STAFF),
                );
        }

}
