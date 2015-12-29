<?php

/**
 * This is the model class for table "console_task_queue".
 *
 * The followings are the available columns in table 'console_task_queue':
 * @property string $id
 * @property string $params
 * @property string $task
 * @property string $progress_message
 * @property string $progress_status
 * @property string $date_created
 * @property integer $max_attempts
 * @property integer $attempts
 * @property integer $is_popped
 * @property string $pop_key
 */
class ConsoleTaskQueue extends ActiveRecord {

        //progress status

        const STATUS_PROGRESS = 'Progress';
        const STATUS_EXCEPTION = 'Exception';
        const STATUS_COMPLETED = 'Completed';

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'console_task_queue';
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return ConsoleTaskQueue the static model class
         */
        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }

        /**
         * Get queued tasks
         * @param type $task
         * @return type
         */
        public function getQueue($task)
        {
                $pop_key = $this->getPopKey($task);
                $limit = 10;

                //update the queue
                $sql = "UPDATE `{$this->tableName()}` SET `pop_key`=:pop_key WHERE `task`=:task AND (`attempts` < `max_attempts`) AND `pop_key` IS NULL LIMIT {$limit}";
                Yii::app()->db->createCommand($sql)
                        ->bindValues(array(':task' => $task, ':pop_key' => $pop_key))
                        ->execute();

                //fetch the update values
                $condition = '(`task`=:task) AND (`pop_key`=:pop_key)';
                $params = array(':task' => $task, ':pop_key' => $pop_key);
                $queue = $this->getData('*', $condition, $params, 'date_created');

                return $queue;
        }

        /**
         * Push a task to a queue
         * @param type $params
         * @return type
         */
        public function push($task, $params, $pop_key = NULL)
        {
                $values = array(
                    'id' => Common::generateHash($task . microtime() . getmypid()),
                    'params' => serialize($params),
                    'task' => $task,
                    'pop_key' => $pop_key,
                    'owner' => Yii::app() instanceof CWebApplication ? Yii::app()->user->id : NULL,
                );
                Yii::app()->db->createCommand()
                        ->insert($this->tableName(), $values);
                return $values;
        }

        /**
         * Remove a queue once processed
         * @param type $id
         */
        public function pop($id)
        {
                //delete the queue
                $sql = "DELETE FROM `{$this->tableName()}` WHERE `id`=:id";
                Yii::app()->db->createCommand($sql)
                        ->bindValues(array(':id' => $id))
                        ->execute();
        }

        /**
         * Get unique pop_key
         * @return type
         */
        protected function getPopKey($task)
        {
                return Common::generateHash($task . microtime() . getmypid());
        }

        /**
         * Increment attempts incase of a failure
         * @param type $id
         * @param type $current_attempts
         */
        public function incrementAttempts($id, $current_attempts)
        {
                $sql = "UPDATE `{$this->tableName()}` SET `attempts`=:attempts,`pop_key`=NULL WHERE `id`=:id";
                Yii::app()->db->createCommand($sql)
                        ->bindValues(array(':attempts' => (int) $current_attempts + 1, ':id' => $id))
                        ->execute();
        }

        /**
         * Update progress of a queue
         * @param type $id
         * @param type $message
         * @param type $status
         */
        public function updateProgress($id, $message, $status = self::STATUS_PROGRESS)
        {
                $sql = "UPDATE `{$this->tableName()}` SET `progress_message`=:t1,`progress_status`=:t2 WHERE `id`=:t3";
                Yii::app()->db->createCommand($sql)
                        ->bindValues(array(':t1' => $message, ':t2' => $status, ':t3' => $id))
                        ->execute();
        }

}
