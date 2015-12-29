<?php

/**
 * This class is used for handling all console commands
 * @author mconyango
 */
class MyCommandHandler {

        /**
         * Only one param for now
         * @param type $cmd
         * @param type $param
         */
        public static function runShellCommand($cmd, $param = array())
        {
                $webroot = Yii::getPathOfAlias('webroot');
                $app_root = Yii::getPathOfAlias('application');
                $base_command = $webroot . DS . 'console.php';
                $log_file = $app_root . DS . 'runtime' . DS . 'jobs.log';
                $command = !empty(Yii::app()->params['PHP_COMMAND']) ? Yii::app()->params['PHP_COMMAND'] : 'php';
                $command.=' ' . $base_command;
                $command.=' ' . escapeshellcmd($cmd);
                foreach ($param as $p) {
                        $command.=' ' . escapeshellarg($p);
                }
                $command.=' >> ' . $log_file . ' 2>&1';
                exec($command);
        }

        /**
         * Runs a yii console command
         * @param type $command
         * @param array $params
         */
        public static function runYiiCommand($command, array $params = array())
        {
                if (Common::isFunctionEnabled('exec')) {
                        self::runShellCommand($command, $params);
                } else {
                        $commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
                        $runner = new CConsoleCommandRunner();
                        $runner->addCommands($commandPath);
                        $args = array_merge(array('yiic', $command), $params);
                        $runner->run($args);
                }
        }

}
