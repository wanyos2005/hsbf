<?php

/**
 * Audit Trail  behavior
 * Add audit trail when a model is modified
 * @author Fred <mconyango@gmail.com>
 */
class AuditTrailBehavior extends CActiveRecordBehavior {

        /**
         * Create template
         * @var type
         */
        public $createTemplate = 'Added a record to {table} on {date}: {row_details}';

        /**
         * Update template
         * @var type
         */
        public $updateTemplate = 'Updated a record from {table} on {date}: {row_details}';

        /**
         * Delete template
         * @var type
         */
        public $deleteTemplate = 'Deleted a record from {table} on {date}: {row_details}';

        public function afterDelete($event)
        {
                if (Yii::app() instanceof CWebApplication) {
                        if (Yii::app()->user->getState(UserIdentity::STATE_AUDIT_TRAIL, true)) {
                                UserActivityLog::model()->addRecord(array(
                                    'user_id' => Yii::app()->user->id,
                                    'ip' => Common::getIp(),
                                    'action' => 'delete',
                                    'activity' => $this->prepareString($this->deleteTemplate),
                                ));
                        }
                }
                return (parent::afterDelete($event));
        }

        public function afterSave($event)
        {
                if (Yii::app() instanceof CWebApplication) {
                        if (Yii::app()->user->getState(UserIdentity::STATE_AUDIT_TRAIL, true)) {
                                $isNewRecord = $this->getOwner()->getIsNewRecord();

                                UserActivityLog::model()->addRecord(array(
                                    'user_id' => Yii::app()->user->id,
                                    'ip' => Common::getIp(),
                                    'action' => $isNewRecord ? 'create' : 'update',
                                    'activity' => $this->prepareString($isNewRecord ? $this->createTemplate : $this->updateTemplate),
                                ));
                        }
                }
                return (parent::afterSave($event));
        }

        /**
         * Prepare string from a template
         * @param type $template
         * @return type
         */
        protected function prepareString($template)
        {
                //supported placeholder : {table} {date} {row_detais}
                $details = '';
                foreach ($this->getOwner()->metadata->tableSchema->columns as $columnName => $column) {
                        $details.=$columnName . '=' . $this->getOwner()->{$columnName} . ', ';
                }

                return Common::myStringReplace($template, array(
                            '{date}' => Yii::app()->localtime->fromLocalDateTime(time()),
                            '{table}' => $this->getOwner()->tableName(),
                            '{row_details}' => $details,
                ));
        }

}
