<?php

class RouteSMS {

        public $server;
        public $port;
        public $username;
        public $password;
        public $sender;
        public $message;
        public $phone_number;
        /*
         * What type of the message that is to be sent
         * <ul>
         * <li>0:means plain text</li>
         * <li>1:means flash</li>
         * <li>2:means Unicode (Message content should be in Hex)</li>
         * <li>6:means Unicode Flash (Message content should be in Hex)</li>
         * </ul>
         */
        public $messageType = 0;
        /*
         * Require DLR or not
         * <ul>
         * <li>0:means DLR is not Required</li>
         * <li>1:means DLR is Required</li>
         * </ul>
         */
        var $strDlr = 0;

        private function sms__unicode($message)
        {
                $hex1 = '';
                if (function_exists('iconv')) {
                        $latin = @iconv('UTF-8', 'ISO-8859-1', $message);
                        if (strcmp($latin, $message)) {
                                $arr = unpack('H*hex', @iconv('UTF-8', 'UCS-
    2BE', $message));
                                $hex1 = strtoupper($arr['hex']);
                        }
                        if ($hex1 == '') {
                                $hex2 = '';
                                $hex = '';
                                for ($i = 0; $i < strlen($message); $i++) {
                                        $hex = dechex(ord($message[$i]));
                                        $len = strlen($hex);
                                        $add = 4 - $len;
                                        if ($len < 4) {
                                                for ($j = 0; $j < $add; $j++) {
                                                        $hex = "0" . $hex;
                                                }
                                        }
                                        $hex2.=$hex;
                                }
                                return $hex2;
                        } else {
                                return $hex1;
                        }
                } else {
                        print 'iconv Function Not Exists !';
                }
        }

        public function Send($message, $mobile, $sender = null, $msgtype = 0, $dlr = 0)
        {
                $this->server = Yii::app()->settings->get('sms', 'route_sms_server');
                $this->port = Yii::app()->settings->get('sms', 'route_sms_port');
                $this->username = Yii::app()->settings->get('sms', 'route_sms_api_username');
                $this->password = Yii::app()->settings->get('sms', 'route_sms_api_password');
                $this->sender = $sender;
                $this->message = $message;
                $mobile = SmsHandler::preparePhoneNumbers($mobile);
                $mobile = implode(',', $mobile);
                $this->phone_number = $mobile;
                $this->messageType = $msgtype;
                $this->strDlr = $dlr;
                return $this->Submit();
        }

        public function Submit()
        {
                if ($this->messageType == '2' || $this->messageType == '6')
                //Call The Function Of String To HEX.
                        $this->message = $this->sms__unicode($this->message);
                else
                        $this->message = urlencode($this->message);
                $this->username = urlencode($this->username);
                $this->phone_number = urlencode($this->phone_number);
                $this->password = urlencode($this->password);
                $this->sender = urlencode($this->sender);
                try {
                        $live_url = 'http://' . $this->server . ':' . $this->port . '/bulksms/bulksms?username=' . $this->username . '&password=' . $this->password . "&type=" . $this->messageType . "&dlr=" . $this->strDlr . "&destination=" . $this->phone_number . "&source=" . $this->sender . '&message=' . $this->message;
                        //$parse_url=file($live_url);
                        $parse_url = $this->curlPost($live_url);
                        return $parse_url;
                } catch (Exception $e) {
                        return $e->getMessage();
                }
        }

        public function curlPost($url)
        {
                $ch = curl_init();
                // Now set some options (most are optional)
                // Set URL to download
                curl_setopt($ch, CURLOPT_URL, $url);
                // Set a referer
                //curl_setopt($ch, CURLOPT_REFERER, "http://www.example.org/yay.htm");
                // User agent
                //curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
                // Include header in result? (0 = yes, 1 = no)
                curl_setopt($ch, CURLOPT_HEADER, 0);
                // Should cURL return or print out the data? (true = return, false = print)
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // Timeout in seconds
                //curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                // Download the given URL, and return output
                $output = curl_exec($ch);
                // Close the cURL resource, and free system resources
                curl_close($ch);

                return $output;
        }

}
