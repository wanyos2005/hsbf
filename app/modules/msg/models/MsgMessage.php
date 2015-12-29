<?php

/**
 * This is the model class for table "msg_message".
 *
 * The followings are the available columns in table 'msg_message':
 * @property integer $id
 * @property integer $from_user_id
 * @property string $to_ids
 * @property string $topic
 * @property string $message
 * @property integer $conversation_id
 * @property string $message_type
 * @property string $message_status
 * @property string $date_created
 */
class MsgMessage extends ActiveRecord {

        const STATUS_ACTIVE = 'Active';
        const TYPE_PRIVATE = 'Private';
        const TYPE_PUBLIC = 'Public';
        const SCENARIO_PRIVATE_MESSAGE = 'private_message';
        const SCENARIO_REPLY = 'Reply';

        /**
         * IDs of message recipients separated by a comma
         * @var type
         */
        public $to_ids;

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'msg_message';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('to_ids', 'required', 'on' => self::SCENARIO_PRIVATE_MESSAGE . ',' . self::SCENARIO_REPLY),
                    array('message', 'required'),
                    array('topic', 'required', 'on' => self::SCENARIO_PRIVATE_MESSAGE),
                    array('from_user_id, conversation_id', 'numerical', 'integerOnly' => true),
                    array('topic', 'length', 'max' => 255),
                    array('to_ids', 'safe'),
                    array('message_type,message_status', 'length', 'max' => 20),
                );
        }

        /**
         * @return array relational rules.
         */
        public function relations()
        {
                return array(
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
                return array(
                    'id' => Lang::t('ID'),
                    'from_user_id' => Lang::t('From'),
                    'topic' => Lang::t('Topic'),
                    'message' => Lang::t('Message'),
                    'date_created' => Lang::t('Date Created'),
                    'to_ids' => Lang::t('To'),
                );
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return MsgMessage the static model class
         */
        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }

        public function beforeSave()
        {
                if ($this->getIsNewRecord()) {
                        if (empty($this->from_user_id))
                                $this->from_user_id = Yii::app()->user->id;
                }
                return parent::beforeSave();
        }

        public function afterSave()
        {
                if ($this->getIsNewRecord()) {
                        $this->addMessageCopies();
                        if (empty($this->conversation_id)) {
                                $this->conversation_id = $this->id;
                                $this->setIsNewRecord(FALSE);
                                $this->save(FALSE);
                        }
                }
                return parent::afterSave();
        }

        protected function addMessageCopies()
        {
                if ($this->message_type === self::TYPE_PRIVATE) {
                        $to_user_ids = explode(',', $this->to_ids);
                        foreach ($to_user_ids as $to_user_id) {
                                MsgMessageCopies::model()->addRecord(array(
                                    'message_id' => $this->id,
                                    'user_id' => $to_user_id,
                                    'owner' => MsgMessageCopies::OWNER_RECIPIENT,
                                ));
                        }
                        //add sender's copy
                        MsgMessageCopies::model()->addRecord(array(
                            'message_id' => $this->id,
                            'user_id' => $this->from_user_id,
                            'owner' => MsgMessageCopies::OWNER_SENDER,
                            'notified' => 1,
                            'read' => 1,
                        ));
                }
        }

}
