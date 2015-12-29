<?php

/**
 * This is the model class for table "console_tasks".
 *
 * The followings are the available columns in table 'console_tasks':
 * @property string $id
 * @property string $last_run
 * @property string $status
 * @property integer $threads
 * @property integer $max_threads
 * @property integer $sleep
 */
class ConsoleTasks extends ActiveRecord {

        const STATUS_ACTIVE = 'Active';
        const STATUS_INACTIVE = 'Inactive';
        //A task times out if last run in seconds or more
        const TIMEOUT_SECS = 300;
        //task constants
        const TASK_SEND_EMAIL = 'sendEmail';
        const TASK_SEND_SMS = 'sendSms';
        const TASK_PROCESS_CSV = 'processCsv';
        const TASK_SEND_SCHEDULED_SMS = 'sendScheduledSms';
        const TASK_CLEAN_UP = 'cleanUp';
        //execution types
        const EXEC_TYPE_DEFAULT = 'default';
        const EXEC_TYPE_CONTINUOUS = 'continuous';

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'console_tasks';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {

                return array(
                    array('id', 'required'),
                    array('threads, max_threads,sleep', 'numerical', 'integerOnly' => true),
                    array('id', 'length', 'max' => 30),
                    array('status', 'length', 'max' => 10),
                    array('last_run,execution_type', 'safe'),
                );
        }

        /**
         * @return array relational rules.
         */
        public function relations()
        {
                return array(
                    'queue' => array(self::HAS_MANY, 'CronTaskQueue', 'task'),
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
                return array(
                    'id' => 'Task',
                    'last_run' => 'Last Run',
                    'status' => 'Status',
                    'threads' => 'Active Processes',
                    'max_threads' => 'Max Processes',
                    'sleep' => 'Sleep (in Sec.)',
                    'execution_type' => 'Execution Type',
                );
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return ConsoleTasks the static model class
         */
        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }

        public function getStatuses()
        {
                return array(
                    self::STATUS_ACTIVE => Lang::t(self::STATUS_ACTIVE),
                    self::STATUS_INACTIVE => Lang::t(self::STATUS_INACTIVE),
                );
        }

        /**
         * Sets that status of the task as active so that it executes when the cron job runs
         * @param type $task_id
         */
        public function startTask($task_id)
        {
                Yii::app()->db->createCommand()
                        ->update($this->tableName(), array('status' => self::STATUS_ACTIVE), '`id`=:id', array(':id' => $task_id));
        }

        /**
         * Stop a task from executing
         * @param type $task_id
         */
        public function stopTask($task_id)
        {
                Yii::app()->db->createCommand()
                        ->update($this->tableName(), array('status' => self::STATUS_INACTIVE, 'threads' => 0, 'last_run' => NULL), '`id`=:id', array(':id' => $task_id));
        }

        /**
         * prepare Yii command param string e.g "--id=3 --name=Fred --interactive=1"
         * @param array $params key=>vaue pair of the params
         * @return string
         */
        protected function prepareYiiCommandParams(array $params)
        {
                $params_string = '';
                $params['interactive'] = 1;

                foreach ($params as $k => $v) {
                        $param = '--' . $k . '=' . $v;
                        if (!empty($params_string))
                                $params_string.=' ';
                        $params_string.=$param;
                }

                return $params_string;
        }

        /**
         * Check whether a task has timed out
         * @param type $task_id
         * @return boolean
         */
        public function hasTimedOut($task_id)
        {
                $sql = "SELECT (UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(`last_run`)) as `last_run`,`sleep` FROM `{$this->tableName()}` WHERE `id`=:id";
                $row = Yii::app()->db->createCommand($sql)
                        ->bindValue(':id', $task_id)
                        ->queryRow();
                if (empty($row))
                        return TRUE;
                if ((int) $row['last_run'] >= (self::TIMEOUT_SECS + (int) $row['sleep'])) {
                        return TRUE;
                }
                return FALSE;
        }

        public function updateLastRun($task_id)
        {
                Yii::app()->db->createCommand()
                        ->update($this->tableName(), array('last_run' => new CDbExpression('NOW()')), '`id`=:id', array(':id' => $task_id));
        }

        public function dateTimeFields()
        {
                return array_merge(parent::dateTimeFields(), array(
                    'last_run',
                ));
        }

        /**
         *
         * @return type
         */
        public function getExecutionTypes()
        {
                return array(
                    self::EXEC_TYPE_CONTINUOUS => self::EXEC_TYPE_CONTINUOUS,
                    self::EXEC_TYPE_DEFAULT => self::EXEC_TYPE_DEFAULT,
                );
        }

}
