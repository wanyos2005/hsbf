<?php

/**
 * Handles the sending of sms
 * @author mconyango
 */
class SmsHandler {

//constant for routes supported

        const ROUTE_INFOBIP = 'Infobip';
        const ROUTE_AFRICASTALKING = 'Africastalking';
        const MAX_SMS_LENGTH = 160;

        /**
         * Sms queue id
         * @var int
         */
        public static $queue_id;

        /**
         * MsgSmsOutbox model object
         * @var MsgSmsOutbox $model
         */
        public static $model;

        /**
         * Process sms queue
         */
        public static function processSmsQueues()
        {
                $queueList = ConsoleTaskQueue::model()->getQueue(ConsoleTasks::TASK_SEND_SMS);
                if (empty($queueList))
                        return FALSE;
                foreach ($queueList as $queue) {
                        self::processQueue($queue);
                }
        }

        /**
         * Process 1 queue of sms
         * @param type $queue
         * @param type $update_status
         */
        public static function processQueue($queue, $update_status = FALSE)
        {
                $params = unserialize($queue['params']);
                $model = self::getModel($params);

                if ($update_status === FALSE) {
                        self::sendSMS($model); //send sms
                        ConsoleTaskQueue::model()->pop($queue['id']);
                } else {
                        self::sendSMS($model, $queue['id']);
                }
        }

        public static function processNonQueue($params)
        {
                $model = self::getModel($params);
                return self::sendSMS($model);
        }

        /**
         * Get MsgSmsOutbox model
         * @param type $params
         * @return \MsgSmsOutbox
         */
        private static function getModel($params)
        {
                if (!empty($params['id']))
                        $model = MsgSmsOutbox::model()->loadModel($params['id']);
                else
                        $model = new MsgSmsOutbox();

                foreach ($params as $k => $v) {
                        $model->{$k} = $v;
                }
                return $model;
        }

        private static function setRecipients()
        {
                if (self::$model->recipients_source === MsgSmsOutbox::RECIPIENTS_SOURCE_GROUPS) {
                        if (empty(self::$model->group_id))
                                throw new CException("group_id cannot be empty");
                        self::$model->recipients = ContactsInGroupView::model()->getPhoneNumbers(self::$model->group_id);
                } else if (self::$model->recipients_source === MsgSmsOutbox::RECIPIENTS_SOURCE_PHONEBOOK) {
                        self::$model->recipients = Contacts::model()->getAllPhoneNumbers(self::$model->org_id);
                }
        }

        /**
         *
         * @param type $model
         * @param type $queue_id
         */
        private static function sendSMS($model, $queue_id = NULL)
        {
                //self::$que
                //new line
                self::$queue_id = $queue_id;
                self::$model = $model;
                self::$model->message = str_replace('\n', "\n", self::$model->message);
                self::setRecipients();
                //check if recipients is empty
                if (empty(self::$model->recipients)) {
                        Yii::log(Lang::t('No recipient mobile phone number found!'), CLogger::LEVEL_ERROR);
                        return FALSE;
                }

                //convert to array if a string is given
                if (!is_array(self::$model->recipients))
                        self::$model->recipients = explode(',', self::$model->recipients);

                //remove any duplicates
                self::$model->recipients = array_unique(self::$model->recipients);

                //set default route
                if (empty(self::$model->sms_route))
                        self::$model->sms_route = Yii::app()->settings->get(Constants::CATEGORY_SMS, Constants::KEY_SMS_ROUTE, self::ROUTE_AFRICASTALKING);

                switch (self::$model->sms_route) {
                        case self::ROUTE_INFOBIP:
                                MyInfobip::send();
                                break;
                        case self::ROUTE_AFRICASTALKING:
                                MyAfricaStalking::send();
                                break;
                        default :
                                Yii::log('The Gateway:' . self::$model->sms_route . ' is not supported', CLogger::LEVEL_ERROR);
                }
        }

        /**
         * Appends the country code to a phone if the phone number does not begins with a country code
         * @param array $gsm_numbers
         * @param boolean $returnArray
         * @return array
         */
        public static function preparePhoneNumbers(array $gsm_numbers, $returnArray = true)
        {
                $prepared = NULL;
                $country_code = Yii::app()->settings->get(Constants::CATEGORY_SMS, Constants::KEY_SMS_COUNTRY_CODE, $default = "254");

                foreach ($gsm_numbers as $p) {
                        $prepared[] = self::preparePhoneNumber($p, $country_code);
                }
                if (!$returnArray)
                        return implode(",", $prepared);
                return $prepared;
        }

        /**
         * Format a phone number by appending the country code
         * @param type $phone
         * @param type $country_code
         * @return type
         */
        public static function preparePhoneNumber($phone, $country_code = NULL)
        {
                if (empty($country_code))
                        $country_code = Yii::app()->settings->get(Constants::CATEGORY_SMS, Constants::KEY_SMS_COUNTRY_CODE, $default = "254");
                if (substr($phone, 0, 1) == "+")
                        $phone = substr($phone, 1);
                if (strlen($phone) >= 12)
                        return $phone;
                else {
                        $new_phone = substr($phone, 1);
                        if (strlen($new_phone) == 9)
                                return $country_code . $new_phone;
                        return $phone;
                }
        }

        /**
         * Get supported routes
         * @return type
         */
        public static function getRoutes()
        {
                return array(
                    self::ROUTE_AFRICASTALKING => self::ROUTE_AFRICASTALKING,
                    self::ROUTE_INFOBIP => self::ROUTE_INFOBIP,
                );
        }

        /**
         * Add billing
         * @param type $org_model
         * @param type $sms_model
         * @param type $recipients_count
         * @return boolean
         */
        public static function addBilling($org_model, $sms_model, $recipients_count)
        {
                if (!ModulesEnabled::model()->isModuleEnabled(ModulesEnabled::MOD_BILLING))
                        return FALSE;

                $message_length = strlen($sms_model->message);
                $no_of_sms = ceil($message_length / self::MAX_SMS_LENGTH);
                $price_per_sms = !empty($org_model->price_per_sms) ? $org_model->price_per_sms : OrgSmsBilling::getDefaultPricePerSms();
                $total_cost = $price_per_sms * $no_of_sms * $recipients_count;

                $model = new OrgSmsBilling();
                $model->org_id = $sms_model->org_id;
                $model->msg_batch_id = $sms_model->batch_id;
                $model->no_of_recipients = $recipients_count;
                $model->no_of_sms = $no_of_sms;
                $model->message_length = $message_length;
                $model->total_amount = $total_cost;
                $model->paid_amount = $org_model->acc_balance >= $total_cost ? $total_cost : $org_model->acc_balance;
                if ($model->paid_amount < 0)
                        $model->paid_amount = 0;
                else
                        $model->payment_date = new CDbExpression('NOW()');
                $model->payment_status = $model->paid_amount < $model->total_amount ? OrgSmsBilling::PAYMENT_STATUS_PENDING : OrgSmsBilling::PAYMENT_STATUS_PAID;
                $model->pending_amount = $model->total_amount - $model->paid_amount;
                $model->save();
                $org_model->acc_balance-=$total_cost;
                $org_model->save(FALSE);
        }

        /**
         * Save sent message
         * @param MsgSmsOutbox $model
         * @return MsgSmsOutbox $model
         */
        public static function saveMessage($model)
        {
                $model->date_created = new CDbExpression('NOW()');
                if ($model->getIsNewRecord() || $model->recipients_source !== MsgSmsOutbox::RECIPIENTS_SOURCE_DEFAULT) {
                        $model->recipients = NULL;
                } else {
                        if (is_array($model->recipients)) {
                                $model->recipients = implode(',', $model->recipients);
                        }
                }
                $model->save(FALSE);
                return $model;
        }

        /**
         * Get chunks
         * @param type $recipients
         * @param type $max_chunk_length
         * @param type $recipients_count
         * @return type
         */
        public static function getChunks($recipients, $max_chunk_length, $recipients_count = NULL)
        {
                if (NULL === $recipients_count)
                        $recipients_count = count($recipients);
                if ($recipients_count <= $max_chunk_length)
                        $chunks = array($recipients);
                else
                        $chunks = array_chunk($recipients, $max_chunk_length);
                return $chunks;
        }

}

interface ISmsHandler {

        public static function send();
}

/**
 * Handles all sms via infobip gateway
 * @author mconyango
 */
class MyInfobip implements ISmsHandler {

        //the max recipients per request

        const MAX_CHUNK_LENGTH = 2000;

        /**
         * Use infobip to send SMS
         * @param type $params
         * @return type
         */
        public static function send()
        {
                $recipients = SmsHandler::$model->recipients;
                $settings = Yii::app()->settings->get(Constants::CATEGORY_SMS, array(
                    Constants::KEY_SMS_INFOBIP_USERNAME,
                    Constants::KEY_SMS_INFOBIP_PASSWORD,
                    Constants::KEY_SMS_SENDER_ID,
                ));
                if (!is_array($recipients))
                        $recipients = explode(',', $recipients);
                if (empty(SmsHandler::$model->from))
                        SmsHandler::$model->from = $settings[Constants::KEY_SMS_SENDER_ID];
                $gateway = new Infobip();

                $recipients_count = count($recipients);
                $sent_count = 0;
                SmsHandler::$model->batch_id = MsgSmsOutbox::model()->getNextIntegerID('batch_id');
                $success_count = 0;
                $chunks = SmsHandler::getChunks($recipients, self::MAX_CHUNK_LENGTH, $recipients_count);
                $message = self::prepareMessage(SmsHandler::$model->message);
                $currency = Yii::app()->settings->get(Constants::CATEGORY_GENERAL, Constants::KEY_CURRENCY, SettingsCurrency::CURRENCY_KES);
                $org_model = !empty(SmsHandler::$model->org_id) ? Org::model()->loadModel(SmsHandler::$model->org_id) : NULL;
                $price_per_sms = NULL !== $org_model ? $org_model->price_per_sms : NULL;

                foreach ($chunks as $contacts) {
                        $error = FALSE;
                        $status_message = NULL;
                        if (SmsHandler::$model->recipients_source === MsgSmsOutbox::RECIPIENTS_SOURCE_DEFAULT)
                                $contacts = SmsHandler::preparePhoneNumbers($contacts, TRUE);

                        $results = self::sendViaInfobip($gateway, $settings, $message, $contacts);
                        $results = CJSON::decode($results);
                        if (empty($results['result'])) {
                                $status_message = "Oops, No messages were sent. ErrorMessage: ";
                                $error = TRUE;
                        } else
                                $results = $results['result'];

                        if (!empty(SmsHandler::$queue_id)) {
                                if ($error === FALSE) {
                                        $sent_count = $sent_count + count($contacts);
                                        $status_message = Lang::t("Processed {$sent_count} of {$recipients_count} messages");
                                }
                                ConsoleTaskQueue::model()->updateProgress(SmsHandler::$queue_id, $status_message);
                                //update status
                        } else if ($error === TRUE && NULL !== $status_message)
                                Yii::log($status_message, CLogger::LEVEL_ERROR);

                        if ($error === FALSE)
                                $success_count+=self::saveRecipients(SmsHandler::$model, $results, $currency, $price_per_sms);

                        sleep(1);
                }

                if (NULL !== $org_model)
                        SmsHandler::addBilling($org_model, SmsHandler::$model, $success_count);

                if (!empty(SmsHandler::$queue_id)) {
                        ConsoleTaskQueue::model()->updateProgress(SmsHandler::$queue_id, Lang::t('Completed.'), ConsoleTaskQueue::STATUS_COMPLETED);
                }
        }

        /**
         * Send via infobip
         * @param Infobip $gateway
         * @param array $settings
         * @param string $message
         * @param array $contacts
         */
        private static function sendViaInfobip($gateway, $settings, $message, $contacts)
        {
                $response = $gateway->SendSMS($settings[Constants::KEY_SMS_INFOBIP_USERNAME], $settings[Constants::KEY_SMS_INFOBIP_PASSWORD], SmsHandler::$model->from, $message, $contacts);
                return Common::convertXmlToJson($response);
        }

        /**
         * Use this function to replace the encode the '+' letters in the message when using InfoBip
         * @param type $message
         * @return type
         */
        private static function prepareMessage($message)
        {
                return str_replace("+", "%2b", $message);
        }

        private static function saveRecipients($model, $result, $currency = NULL, $price_per_sms = NULL)
        {
                /* array(
                 *      array("status" => "0", "messageid" => "264012800292551302", "destination" => "254724962380"),
                 *      array("status" => "0", "messageid" => "264012800292551303", "destination" => "254738679835"),
                 * )
                 */
                $success = 0;
                $model = SmsHandler::saveMessage($model);
                $values = array();

                foreach ($result as $row) {
                        $remarks = self::getRemarks($row['status']);
                        $status_code = $row['status'];
                        if ($row['status'] >= 0) {
                                $status = MsgSmsRecipient::SEND_STATUS_SUCCESS;
                                $success++;
                        } else
                                $status = MsgSmsRecipient::SEND_STATUS_ERROR;

                        $data = array(
                            'msg_id' => $model->id,
                            'to' => $row['destination'],
                            'send_status' => $status,
                            'status_code' => $status_code,
                            'remarks' => $remarks,
                            'cost' => $price_per_sms,
                            'cost_currency' => $currency,
                            'api_msg_ref_id' => isset($row['messageid']) ? $row['messageid'] : NULL,
                            'date_created' => new CDbExpression('NOW()'),
                        );
                        $values[] = $data;
                }
                MsgSmsRecipient::model()->insertMultiple($values);

                return $success;
        }

        private static function getRemarks($code)
        {
                $remarks = "";
                $code = (int) $code;
                switch ($code) {
                        case -1:
                                $remarks = 'SEND_ERROR';
                                break;
                        case -2:
                                $remarks = 'Not enough credits';
                                break;
                        case -3:
                                $remarks = 'Network not covered';
                                break;
                        case -4:
                                $remarks = 'Socket exception';
                                break;
                        case -5:
                                $remarks = 'Invalid user or password';
                                break;
                        case -6:
                                $remarks = 'Missing destination address';
                                break;
                        case -7:
                                $remarks = 'Missing SMS text';
                                break;
                        case -8:
                                $remarks = 'Missing sender name';
                                break;
                        case -9:
                                $remarks = 'Destination address (phone number) invalid format';
                                break;
                        case -10:
                                $remarks = 'Missing username';
                                break;
                        case -11:
                                $remarks = 'Missing password';
                                break;
                        case -13:
                                $remarks = 'Invalid destination address';
                                break;
                        default :
                                $remarks = 'Sent successfully';
                }
                return $remarks;
        }

}

/**
 * Handles all sms sent via AfricasTalking API
 * @author mconyango <mconyango@gmail.com>
 */
class MyAfricaStalking implements ISmsHandler {

        const MAX_CHUNK_LENGTH = 1000;
        const STATUS_SUCCESS = 'Success';
        const STATUS_ERROR = 'Error';

        /**
         * Send  SMS
         */
        public static function send()
        {
                $recipients = SmsHandler::$model->recipients;
                $settings = Yii::app()->settings->get(Constants::CATEGORY_SMS, array(
                    Constants::KEY_SMS_AFRICASTALKING_USERNAME,
                    Constants::KEY_SMS_AFRICASTALKING_API_KEY,
                    Constants::KEY_SMS_AFRICASTALKING_SHORTCORD,
                ));
                if (!is_array($recipients))
                        $recipients = explode(',', $recipients);
                if (empty(SmsHandler::$model->from))
                        SmsHandler::$model->from = $settings[Constants::KEY_SMS_AFRICASTALKING_SHORTCORD];
                $gateway = new AfricaStalkingGateway($settings[Constants::KEY_SMS_AFRICASTALKING_USERNAME], $settings[Constants::KEY_SMS_AFRICASTALKING_API_KEY]);

                $recipients_count = count($recipients);
                $sent_count = 0;
                SmsHandler::$model->batch_id = MsgSmsOutbox::model()->getNextIntegerID('batch_id');
                $success_count = 0;
                $chunks = SmsHandler::getChunks($recipients, self::MAX_CHUNK_LENGTH, $recipients_count);
                $currency = Yii::app()->settings->get(Constants::CATEGORY_GENERAL, Constants::KEY_CURRENCY, SettingsCurrency::CURRENCY_KES);
                $org_model = !empty(SmsHandler::$model->org_id) ? Org::model()->loadModel(SmsHandler::$model->org_id) : NULL;
                $price_per_sms = NULL !== $org_model ? $org_model->price_per_sms : NULL;

                foreach ($chunks as $contacts) {
                        $error = FALSE;
                        $status_message = NULL;
                        if (SmsHandler::$model->recipients_source === MsgSmsOutbox::RECIPIENTS_SOURCE_DEFAULT)
                                $gsm_numbers = SmsHandler::preparePhoneNumbers($contacts, FALSE);
                        else
                                $gsm_numbers = implode(",", $contacts);
                        $results = $gateway->sendMessage($gsm_numbers, SmsHandler::$model->message, SmsHandler::$model->from);
                        if (empty($results)) {
                                $status_message = "Oops, No messages were sent. ErrorMessage: " . $gateway->getErrorMessage();
                                $error = TRUE;
                        }
                        if (!empty(SmsHandler::$queue_id)) {
                                if ($error === FALSE) {
                                        $sent_count = $sent_count + count($contacts);
                                        $status_message = Lang::t("Processed {$sent_count} of {$recipients_count} messages");
                                }
                                ConsoleTaskQueue::model()->updateProgress(SmsHandler::$queue_id, $status_message);
                                //update status
                        } else if ($error === TRUE && NULL !== $status_message)
                                Yii::log($status_message, CLogger::LEVEL_ERROR);

                        if ($error === FALSE)
                                $success_count+=self::saveRecipients(SmsHandler::$model, $results, $currency, $price_per_sms);

                        sleep(1);
                }
                if (NULL !== $org_model)
                        SmsHandler::addBilling($org_model, SmsHandler::$model, $success_count);

                if (!empty(SmsHandler::$queue_id)) {
                        ConsoleTaskQueue::model()->updateProgress(SmsHandler::$queue_id, Lang::t('Completed.'), ConsoleTaskQueue::STATUS_COMPLETED);
                }
        }

        /**
         * Save Recipients
         * @param type $model
         * @param type $result
         * @param type $currency
         * @param type $price_per_sms
         * @return int
         */
        private static function saveRecipients($model, $result, $currency = NULL, $price_per_sms = NULL)
        {
                $success = 0;
                $model = SmsHandler::saveMessage($model);
                $values = array();

                foreach ($result as $row) {
                        if ($row->status === self::STATUS_SUCCESS) {
                                $remarks = Lang::t('Sent successfully');
                                $status = MsgSmsRecipient::SEND_STATUS_SUCCESS;
                                $success++;
                        } else {
                                $status = MsgSmsRecipient::SEND_STATUS_ERROR;
                                $remarks = $row->status;
                        }

                        $data = array(
                            'msg_id' => $model->id,
                            'to' => $row->number,
                            'send_status' => $status,
                            'remarks' => $remarks,
                            'cost' => $price_per_sms,
                            'cost_currency' => $currency,
                            'api_msg_ref_id' => $row->messageId,
                        );
                        $values[] = $data;
                }
                MsgSmsRecipient::model()->insertMultiple($values);

                return $success;
        }

}
