<?php

/**
 * All cron jobs actions are defined here.
 * @author Fred  <mconyango@gmail.com>
 */
class TaskManagerCommand extends CConsoleCommand {

        public function actionSendEmail(array $args)
        {
                $this->startTask(ConsoleTasks::TASK_SEND_EMAIL);
        }

        protected function sendEmail()
        {
                MsgEmailOutbox::model()->processQueue();
        }

        public function actionSendSms(array $args)
        {
                $this->startTask(ConsoleTasks::TASK_SEND_SMS);
        }

        protected function sendSms()
        {
                SmsHandler::processSmsQueues();
        }

        public function actionCleanUp()
        {
                $this->startTask(ConsoleTasks::TASK_CLEAN_UP);
        }

        protected function cleanUp()
        {
                MyYiiUtils::clearTempFiles();
        }

        /**
         * Start a Task
         * @param type $task_id
         * @return type
         */
        protected function startTask($task_id)
        {
                try {
                        $task = ConsoleTasks::model()->findByPk($task_id);
                        if (NULL === $task)
                                throw new Exception("{$task_id} does not exist.");
                        if ($task->status !== ConsoleTasks::STATUS_ACTIVE)
                                return FALSE;
                        //non continuous execution type
                        if ($task->execution_type === ConsoleTasks::EXEC_TYPE_DEFAULT) {
                                $this->{$task_id}();
                                return ConsoleTasks::model()->updateLastRun($task->id);
                        }

                        $error = FALSE;
                        if ($task->threads >= $task->max_threads)
                                $error = TRUE;
                        if ($error === TRUE) {
                                $has_timed_out = ConsoleTasks::model()->hasTimedOut($task->id);
                                if ($has_timed_out) {
                                        $error = FALSE;
                                        $task->threads = 1;
                                }
                        } else
                                $task->threads++;

                        if ($error === FALSE) {
                                $task->save(false);
                                while ($task->status === ConsoleTasks::STATUS_ACTIVE) {
                                        if (Yii::app()->db->getActive() === FALSE)
                                                Yii::app()->db->setActive(TRUE); //open new connection
                                        $this->{$task_id}();
                                        $sleep_seconds = $task->sleep;
                                        if ($sleep_seconds < 1)
                                                $sleep_seconds = 1;
                                        ConsoleTasks::model()->updateLastRun($task->id);
                                        $task->refresh();
                                        Yii::app()->db->setActive(FALSE); //close db connection on sleep mode.
                                        sleep((int) $sleep_seconds);
                                }
                        }
                } catch (Exception $exc) {
                        Yii::log($exc->getMessage(), CLogger::LEVEL_ERROR);
                }
        }

}
