<?php

/**
 * This class stores common functions that can be used globally
 * @author Fredrick <fred@btimillman.com>
 *
 */
class Common {

        /**
         * This function gets the Ip of visitors
         */
        public static function getIp()
        {
                //Check if the register_globals is set to off
                if (ini_get('register_globals'))
                        return @$REMOTE_ADDR; //register_globals=ON
                else
                        return $_SERVER['REMOTE_ADDR']; //register_globals=OFF
        }

        /**
         * This function generates a random string that can be used as salt
         * @return type
         */
        public static function generateSalt()
        {
                return md5(microtime());
        }

        /**
         * This function send an email
         * @param string $to : The recipient email address
         * @param string $from : The sender email address
         * @param string $title  : The title of the email
         * @param string $body : The body of the email
         */
        public static function sendEmail($to, $from, $title, $body)
        {
                $headers = '';
                $title = '=?UTF-8?B?' . base64_encode($title) . '?=';
                if (is_array($from)) {
                        if (isset($from['name'])) {
                                $name = '=?UTF-8?B?' . base64_encode($from['name']) . '?=';
                                $headers.="From: $name <{$from['email']}>\r\nReply-To: {$from['email']}\r\n";
                        }
                } else
                        $headers.="From: {$from}\r\nReply-To: {$from}\r\n";
                $headers.="MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html\r\n";
                if (mail($to, $title, $body, $headers))
                        return true;
                return false;
        }

        /**
         * This function will format the date given into a user friendly format,taking into consideration the timezone of the user
         * @param string $date the date to be formated
         * @param string $format date format default= 31/05/2012 03:51 PM
         * @return string the formated date
         */
        public static function formatDate($date, $format = 'Y-m-d g:i a')
        {
                if (empty($date))
                        return NULL;

                if (!self::checkDateTime($date))
                        return $date;

                $date = date_create($date);
                return date_format($date, $format);
        }

        /**
         * Adds either http:// when the URL do not have the protocol prefix
         * @param type $url
         * @return type
         */
        public static function prepareUrl($url)
        {
                if (empty($url))
                        return '#';
                if (strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0)
                        $url = 'http://' . $url;
                return $url;
        }

        /**
         * Compare two dates.Returns true if $date1 is earlier than $date2, else false
         * @param string $data1
         * @param string $date2
         * @return boolean True if date2 is greater than $date1 else false
         */
        public static function isEarlierThan($date1, $date2)
        {
                if (strtotime($date1) < strtotime($date2))
                        return true;
                return false;
        }

        /**
         * This function extends a date by adding either days,weeks,moths or years to a date
         * @param type $date
         * @param type $length
         * @param type $type either day,week,month,year
         * @param boolean $format A valid date format
         */
        public static function addDate($date, $length, $type = 'month', $format = 'Y-m-d')
        {
                $validTypes = array('day', 'week', 'month', 'year');
                if (!in_array($type, $validTypes))
                        throw new Exception('Wrong type');

                return date($format, strtotime("$length $type", strtotime($date)));
        }

        /**
         * Generate a random password
         * @param type $length
         * @param type $strength
         * @return string
         */
        public static function generateRandomString($length = 8)
        {
                $vowels = 'aeuyAEUY123456789';
                $consonants = 'bdghjmnpqrstvzBDGHJLMNPQRSTVWXZ';

                $string = '';
                $alt = time() % 2;
                for ($i = 0; $i < $length; $i++) {
                        if ($alt == 1) {
                                $string .= $consonants[(rand() % strlen($consonants))];
                                $alt = 0;
                        } else {
                                $string .= $vowels[(rand() % strlen($vowels))];
                                $alt = 1;
                        }
                }
                return $string;
        }

        /**
         * Creates a new dirctory
         * @param string $dir_name
         * @param integer $permission
         * @return string $dir_name
         */
        public static function createDir($dir_name, $permission = 0755)
        {
                //check if the directory already exists
                if (!is_dir($dir_name)) {
                        //create the user's root dir
                        mkdir($dir_name, $permission);
                }
                return $dir_name;
        }

        /**
         * Get an alpha e.g A given a string say 1
         * @param type $number
         * @param type $capital
         * @return string
         */
        public static function getAlphaFromNumber($number, $capital = true)
        {
                $capitalApha = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
                $lowerAlpha = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
                if ($capital)
                        return $capitalApha[$number - 1];
                return $lowerAlpha[$number - 1];
        }

        /**
         * Check whether a given email is a valid email address
         * @param type $email
         * @return boolean
         */
        public static function isEmail($email)
        {
                if (preg_match("/^(\w+((-\w+)|(\w.\w+))*)\@(\w+((\.|-)\w+)*\.\w+$)/", $email))
                        return true;
                return false;
        }

        /**
         * Get the client browser type
         * @return type
         */
        public static function getBrowser()
        {
                return $_SERVER['HTTP_USER_AGENT'];
        }

        /**
         * Get all the days of a given week
         * @param string $week_number e.g "01","02","22"
         * @param string $year e.g "2012" or 2012
         * @param string $format .The date format
         * @return array
         */
        public static function getDaysofWeek($week_number = NULL, $year = NULL, $format = 'Y-m-d')
        {
                if (empty($week_number))
                        $week_number = date('W');
                if (empty($year))
                        $year = date('Y');
                $days_of_week = array();
                if (is_integer($week_number))
                        $week_number = str_pad($week_number, 2, '0', STR_PAD_LEFT);
                for ($day = 1; $day <= 7; $day++) {
                        array_push($days_of_week, date($format, strtotime($year . "W" . $week_number . $day)));
                }
                return $days_of_week;
        }

        /**
         * Get all the days of a given month
         * @param string $month e.g 1,2,22
         * @param string $year e.g 2012
         * @param string $format. Date format
         * @return array all the dates of a month (yy-mm-dd)
         */
        public static function getDaysofMonth($month = NULL, $year = NULL, $format = 'Y-m-d')
        {
                if (empty($month))
                        $month = date('m');
                if (empty($year))
                        $year = date('Y');
                $start_date = $year . '-' . $month . '-01';
                $end_date = $year . '-' . $month . '-' . self::getTotalMonthDays($month, $year);
                return self::generateDateSpan($start_date, $end_date, 1, 'day', $format);
        }

        /**
         * Get the total number of days in a given month of a given year
         * @param integer $month
         * @param integer $year
         */
        public static function getTotalMonthDays($month = null, $year = null)
        {
                if (empty($month))
                        $month = date('m');
                if (empty($year))
                        $year = date('Y');
                $month = (int) $month;
                $year = (int) $year;
                if ($month != 2) {
                        if ($month == 4 || $month == 6 || $month == 9 || $month == 11)
                                return 30;
                        else
                                return 31;
                } else
                        return $year % 4 == "" && $year % 100 != "" ? 29 : 28;
        }

        /**
         * Get all months of a year e.g 2012-01,2012-02 etc
         * @param string $year
         * @param string $delimiter separates the year and month e.g '-','/'
         * @return array containing all the months of a given year e.g 2012/01 or 2012-01
         */
        public static function getYearMonths($year = null, $delimiter = '/', $defaultDay = '01')
        {
                if (empty($year))
                        $year = date('Y');
                if (empty($delimiter))
                        $delimiter = '/';
                return array(
                    $year . $delimiter . '01' . $delimiter . $defaultDay,
                    $year . $delimiter . '02' . $delimiter . $defaultDay,
                    $year . $delimiter . '03' . $delimiter . $defaultDay,
                    $year . $delimiter . '04' . $delimiter . $defaultDay,
                    $year . $delimiter . '05' . $delimiter . $defaultDay,
                    $year . $delimiter . '06' . $delimiter . $defaultDay,
                    $year . $delimiter . '07' . $delimiter . $defaultDay,
                    $year . $delimiter . '08' . $delimiter . $defaultDay,
                    $year . $delimiter . '09' . $delimiter . $defaultDay,
                    $year . $delimiter . '10' . $delimiter . $defaultDay,
                    $year . $delimiter . '11' . $delimiter . $defaultDay,
                    $year . $delimiter . '12' . $delimiter . $defaultDay,
                );
        }

        /**
         * Generate all dates between the given $start_date and $end_date
         * @param string $start_date
         * @param string $end_date
         * @param integer $interval The Interval e.g 1,2,3 etc
         * @param  string $interval_type e.g minute,hour,day,month etc
         * @param string $format The date format
         * @return array All the dates from the $start_date to $end_date
         */
        public static function generateDateSpan($start_date = null, $end_date = null, $interval = 1, $interval_type = 'day', $format = 'Y-m-d')
        {
                if (empty($interval))
                        $interval = 1;
                // normalize input
                $start_date = is_numeric($start_date) ? $start_date : ( is_null($start_date) ? time() : @strtotime($start_date) );
                $end_date = is_numeric($end_date) ? $end_date : ( is_null($end_date) ? strtotime('today') : @strtotime($end_date) );
                // generate the intervals
                $interval = $interval . ' ' . $interval_type;
                $intervals = array();
                $intervals[] = $next = $start_date;
                do {
                        $intervals[] = $next = ( is_numeric($interval) ? ($next + $interval) : @strtotime($interval, $next) );
                } while ($next < $end_date);
                $intervals[] = $end_date;
                // clean and format
                return array_unique(array_map(create_function('$t', 'return @date("' . $format . '", $t);'), $intervals));
        }

        /**
         * Get last month given a month and year
         * @param integer $month e.g 1,2,..12,etc
         * @param integer $year e.g 2012
         * @param integer $offset . e.g 1,2,3 month ago
         * @return array e.g  array('month'=>2, 'year'=>2012)
         */
        public static function getPreviousMonth($month = NULL, $year = NULL)
        {
                if (empty($month))
                        $month = date('m');
                if (empty($year))
                        $year = date('Y');
                if ($month == 1) {
                        $lastMonth = 12;
                        $year = $year - 1;
                } else {
                        $lastMonth = $month - 1;
                }
                return array('month' => $lastMonth, 'year' => $year);
        }

        /**
         * Get next month given a month and year
         * @param integer $month e.g 1,2,..12,etc
         * @param integer $year e.g 2012
         * @return array e.g  array('month'=>2, 'year'=>2012)
         */
        public static function getNextMonth($month = NULL, $year = NULL)
        {
                if (empty($month))
                        $month = date('m');
                if (empty($year))
                        $year = date('Y');
                if ($month == 12) {
                        $nextMonth = 1;
                        $year = $year + 1;
                } else {
                        $nextMonth = $month + 1;
                }
                return array('month' => $nextMonth, 'year' => $year);
        }

        /**
         * Get last week given a week and year
         * @param integer $week e.g from1,2,..52,etc
         * @param integer $year e.g 2012
         * @return array e.g  array('week'=>2, 'year'=>2012)
         */
        public static function getLastWeek($week = NULL, $year = NULL)
        {
                if (empty($week))
                        $week = date('W');
                if (empty($year))
                        $year = date('Y');
                if ($week == 1) {
                        $lastWeek = 52;
                        $year = $year - 1;
                } else {
                        $lastWeek = $week - 1;
                }
                return array('week' => $lastWeek, 'year' => $year);
        }

        /**
         * Get next week given a week and year
         * @param integer $week e.g from1,2,..52,etc
         * @param integer $year e.g 2012
         * @return array e.g  array('week'=>2, 'year'=>2012)
         */
        public static function getNextWeek($week = NULL, $year = NULL)
        {
                if (empty($week))
                        $week = date('W');
                if (empty($year))
                        $year = date('Y');
                if ($week == 52) {
                        $nextWeek = 1;
                        $year = $year + 1;
                } else {
                        $nextWeek = $week + 1;
                }
                return array('week' => $nextWeek, 'year' => $year);
        }

        /**
         * Deletes a directory and its contents
         * @param type $path path to the file/folder
         * @return type
         */
        public static function deleteDir($path)
        {
                if (!file_exists($path))
                        return FALSE;

                $this_func = array(__CLASS__, __FUNCTION__);
                return is_file($path) ? @unlink($path) : array_map($this_func, glob($path . '/*')) == @rmdir($path);
        }

        /**
         * Date formats
         * @return type
         */
        public static function getDateFormats()
        {
                return array(
                    'd/m/Y g:i a' => '14/10/1987 12:00 am',
                    'Y/m/d g:i a' => '1987/10/14 12:00 am',
                    'M j, Y g:i a' => 'Oct 14,1987 12:00 am',
                    'D M j, Y g:i a' => 'Wed Oct 14,1987 12:00 am'
                );
        }

        /**
         * Format the date format into user friendly format e,g '14/10/1987 12:00 am' instead of  'd/m/Y g:i a'
         * @param type $format
         */
        public static function formatDateFormat($format)
        {
                $date_formats = self::getDateFormats();
                if (array_key_exists($format, $date_formats))
                        return $date_formats[$format];
                return false;
        }

        /**
         * Custome string replace function
         * @param string $string The original string
         * @param array $params $key=>$value pair where $key is the placeholder and $value is the value to replace the placeholder
         */
        public static function myStringReplace($string, $params = array())
        {
                foreach ($params as $key => $val) {
                        $string = str_replace($key, $val, $string);
                }
                return $string;
        }

        /**
         * Check whether a given string is a valid date
         * @param type $dateString
         * @return boolean
         */
        public static function checkDateTime($dateString)
        {
                $stamp = strtotime($dateString);
                if (!is_numeric($stamp)) {
                        return FALSE;
                }
                $month = date('m', $stamp);
                $day = date('d', $stamp);
                $year = date('Y', $stamp);
                if (checkdate($month, $day, $year)) {
                        return TRUE;
                }
                return FALSE;
        }

        /**
         * Remove all white spaces
         * @param type $string
         * @return type
         */
        public static function stripAllWhiteSpace($string, $replace_with = '_')
        {
                if ($replace_with)
                        return str_replace(' ', $replace_with, $string);
                return preg_replace('/\s+/', '', $string);
        }

        /**
         * get date diff
         * @param type $date1
         * @param type $date2
         * @return DateInterval $interval->y,$interval->m,$interval->d
         */
        public static function getDateDiff($date1, $date2)
        {
                $datetime1 = new DateTime($date1);
                $datetime2 = new DateTime($date2);
                $interval = $datetime1->diff($datetime2);
                return $interval;
        }

        /**
         * Expand a string e.g Not_active to Not active/Not Active
         * @param type $string
         * @param type $capitalize
         * @param type $delimiter
         * @return type
         */
        public static function expandString($string, $capitalize = true, $delimiter = '_', $replace = ' ')
        {
                $string = str_replace($delimiter, $replace, $string);
                $finalString = $string;
                if ($capitalize) {
                        $string = explode($replace, $string);
                        foreach ($string as $ss) {
                                $finalString = str_replace($ss, ucfirst($ss), $finalString);
                        }
                }
                return $finalString;
        }

        /**
         * Encript a string
         * @param type $string
         * @param type $min_length
         * @return type
         */
        public static function encryptString($string, $min_length = 6)
        {
                $encript = new EncryptionClass();
                return $encript->encrypt(self::getEncriptionKey(), $string, $min_length);
        }

        /**
         * decript a string
         * @param type $encriptedString
         * @return type
         */
        public static function decryptString($encriptedString)
        {
                $crypt = new EncryptionClass();
                return $crypt->decrypt(self::getEncriptionKey(), $encriptedString);
        }

        private static function getEncriptionKey()
        {
                return 'A-COMPLETELY-RANDOM-KEY-THAT-I-HAVE-USED';
        }

        /**
         * Replace only a specific tag from a string
         * @param type $string
         * @param type $tag
         * @return type
         */
        public static function stripATag($string, $tags)
        {
                foreach ($tags as $k => $v) {
                        $string = preg_replace("/<\/?" . $k . "(.|\s)*?>/", $v, $string);
                }
                return $string;
        }

        /**
         * Unzip a zipped file
         * @param type $file_path
         * @param type $extract_to
         */
        public static function unzip($file_path, $extract_to)
        {
                $zip = new ZipArchive;
                $res = $zip->open($file_path);
                if ($res === TRUE) {
                        $zip->extractTo($extract_to . '/');
                        $zip->close();
                        return true;
                }
                return false;
        }

        /**
         * Generates a random number
         * @param type $digits
         * @return type
         */
        public static function generateRandomNumber($digits = 4)
        {
                return str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
        }

        /**
         * Join two strings
         * @param type $string1
         * @param type $string2
         * @param type $delimiter
         * @return type
         */
        public static function joinTwoStrings($string1, $string2, $delimiter = ' ')
        {
                $string = '';
                if (!empty($string1))
                        $string.=$string1;
                if (!empty($string1) && !empty($string2))
                        $string.=$delimiter;
                if (!empty($string2))
                        $string.=$string2;
                return $string;
        }

        /**
         * my word wrap
         * @param type $str
         * @param type $size
         * @param type $linebreak
         * @return type
         */
        public static function myWordwrap($str, $size, $linebreak = '<br />\n')
        {
                return wordwrap($str, $size, $linebreak, TRUE);
        }

        /**
         * check whether a given date is a particular day of week
         * e.g check if date "2012-09-12" is "saturday"
         * @param string $dateString
         * @param integer $day_int e.g 1=Mon,2=Tue,3=Wed,4=Thur,5=Fri,6=Sat,7=Sun
         * @return boolean
         */
        public static function isDayofWeek($dateString, $day_int)
        {
                return date('w', strtotime($dateString)) == $day_int;
        }

        /**
         * add ordinal number suffix
         * @param type $num
         * @return type
         */
        public static function addOrdinalNumberSuffix($num)
        {
                if (!in_array(($num % 100), array(11, 12, 13))) {
                        switch ($num % 10) {
                                // Handle 1st, 2nd, 3rd
                                case 1: return $num . 'st';
                                case 2: return $num . 'nd';
                                case 3: return $num . 'rd';
                        }
                }
                return $num . 'th';
        }

        /**
         * Trancate a string
         * @param type $string
         * @param type $max_length
         * @param type $suffix
         * @return type
         */
        public static function trancateString($string, $max_length, $suffix = '...')
        {
                return (strlen($string) > $max_length) ? substr($string, 0, $max_length) . $suffix : $string;
        }

        /**
         * get months array
         * @param type $add_tip
         * @return string
         */
        public static function getMonths($add_tip = true)
        {
                $prefix = array('' => '--month--');
                $months = array(
                    1 => "January",
                    2 => "February",
                    3 => "March",
                    4 => "April",
                    5 => "May",
                    6 => "June",
                    7 => "July",
                    8 => "August",
                    9 => "September",
                    10 => "October",
                    11 => "November",
                    12 => "December",
                );
                if ($add_tip)
                        return $prefix + $months;
                else
                        return $months;
        }

        /**
         * Get array of years: for select box use
         * @param type $startYear
         * @param type $forward
         * @param type $maxCount
         * @param type $add_tip
         * @return type
         */
        public static function getYears($startYear = null, $forward = true, $maxCount = 30, $add_tip = true)
        {
                $prefix = array('' => '--year--');
                if (empty($startYear))
                        $startYear = date('Y');
                $years = array();
                for ($i = 0; $i < $maxCount; $i++) {
                        $years[$startYear] = $startYear;
                        if ($forward)
                                $startYear++;
                        else
                                $startYear--;
                }
                if ($add_tip)
                        return $prefix + $years;
                return $years;
        }

        /**
         * Gets a string format of a month given an int e.g 1=January
         * @param type $monthInt
         */
        public static function monthToString($monthInt)
        {
                if (empty($monthInt))
                        return false;
                $monthInt = (int) $monthInt;
                $months = self::getMonths();
                return $months[$monthInt];
        }

        /**
         * The gap in seconds
         * @param type $gap
         * @return type
         */
        public static function getTime($gap = 1800)
        {
                $time_arr = array();
                $start = strtotime('12:00am');
                $end = strtotime('11:59pm');
                for ($i = $start; $i <= $end; $i += $gap) {
                        $time_arr[date('H:i:s', $i)] = date('g:i a', $i);
                }
                return $time_arr;
        }

        /**
         * sanitize an input and remove all non-digit characters
         * @param type $string
         * @return type
         */
        public static function parseInt($string)
        {
                return (int) preg_replace('/\D/', '', $string);
                //or
                //return (int) preg_replace('/[^0-9]/', '', $string);
        }

        /**
         * Gets the integer format of a month given a month in string format
         * @param type $stringMonth e.g January
         * @return int e.g 1
         */
        public static function monthToInt($stringMonth)
        {
                $month = date_parse($stringMonth);
                return $month['month'];
        }

        /**
         *  Upload an image
         * @param type $basePath
         * @param type $file_element_name
         * @param type $new_file_name
         * @param type $allowed_ext
         * @param type $max_size
         * @param string $allowed_types
         * @return type
         */
        public static function uploadImage($basePath, $file_element_name = 'file', $new_file_name = null, $allowed_ext = array('gif', 'jpeg', 'jpg', 'png'), $max_size = 6291456, $allowed_types = array("image/gif", "image/jpg", "image/jpeg", "image/pjpeg", "image/x-png", "image/png"))
        {
                $response = array();
                //validate file types
                if (!in_array($_FILES[$file_element_name]["type"], $allowed_types)) {
                        $response['error'] = 'Invalid file type.';
                        return $response;
                }
                //validate extension type
                $extension = end(explode(".", $_FILES[$file_element_name]["name"]));
                if (!in_array($extension, $allowed_ext)) {
                        $response['error'] = 'Invalid file extension.';
                        return $response;
                }

                //validate file size
                if ($_FILES[$file_element_name]["size"] > $max_size) {
                        $response['error'] = 'The file is more than the maximum allowed size. The maximum allowed size is ' . ($max_size / (1024 * 1024)) . 'MB.';
                        return $response;
                }

                if ($_FILES["file"]["error"] > 0) {
                        $response['error'] = $_FILES[$file_element_name]["error"];
                        return $response;
                }

                //now upload the file and return the file name
                $file_name = !empty($new_file_name) ? $new_file_name . '.' . $extension : $_FILES[$file_element_name]["name"];
                move_uploaded_file($_FILES[$file_element_name]["tmp_name"], $basePath . DS . $file_name);
                $response['file_name'] = $file_name;
                $response['file_path'] = $basePath . DS . $file_name;
                $response['extension'] = $extension;
                $response['success'] = 'File uploaded successfully';
                return $response;
        }

        /**
         * Clean a string by removing space and special characters
         * @param type $string
         * @param type $space_holder
         * @param type $allow_numbers
         * @return type
         */
        public static function cleanString($string, $space_holder = '_', $allow_numbers = true)
        {
                if (!empty($space_holder))
                        return str_replace(" ", $space_holder, $string);
                else if ($allow_numbers)
                        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
                else
                        return preg_replace("/[^a-zA-Z]+/", "", $string); // Removes special chars & numbers.
        }

        /**
         * Generate integer lists
         * @param type $start
         * @param type $end
         * @param type $gap
         * @return boolean
         */
        public static function generateIntergersList($start, $end, $gap = 1)
        {
                if (!is_numeric($start) || !is_numeric($end) || !is_numeric($gap))
                        throw new Exception('All params must be a number.');
                if ($start > $end || $gap > $end)
                        throw new Exception('Check your params.');
                $list = array();

                for ($i = $start; $i <= $end; $i+=$gap) {
                        $list[$i] = $i;
                }

                return $list;
        }

        /**
         * Wraps a long string.
         * @param type $string
         * @param type $width
         * @param type $break
         * @return type
         */
        public static function smartWordwrap($string, $width = 75, $break = "\n")
        {
                if (empty($string))
                        return NULL;
                // split on problem words over the line length
                $pattern = sprintf('/([^ ]{%d,})/', $width);
                $output = '';
                $words = preg_split($pattern, $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

                foreach ($words as $word) {
                        if (false !== strpos($word, ' ')) {
                                // normal behaviour, rebuild the string
                                $output .= $word;
                        } else {
                                // work out how many characters would be on the current line
                                $wrapped = explode($break, wordwrap($output, $width, $break));
                                $count = $width - (strlen(end($wrapped)) % $width);

                                // fill the current line and add a break
                                $output .= substr($word, 0, $count) . $break;

                                // wrap any remaining characters from the problem word
                                $output .= wordwrap(substr($word, $count), $width, $break, true);
                        }
                }

                // wrap the final output
                if (strlen($output) <= $width)
                        return $output;
                return wordwrap($output, $width, $break);
        }

        /**
         * Get number of seconds,minutes,hours,days,weeks between two dates
         * @param mixed $date1
         * @param mixed $date2
         * @param string $duration_type either of second,minute,hour,day,week.
         * @return mixed
         * @throws Exception
         */
        public static function getDurationBetween($date1, $date2, $duration_type = 'day')
        {
                $valid_duration_types = array('second', 'minute', 'hour', 'day', 'week');
                if (!in_array($duration_type, $valid_duration_types))
                        throw new Exception('Wrong duration type');
                if (!ctype_digit($date1))
                        $date1 = strtotime($date1);
                if (!ctype_digit($date2))
                        $date2 = strtotime($date2);

                $datediff = abs($date1 - $date2);
                switch ($duration_type) {
                        case 'second':
                                return $datediff;
                                break;
                        case 'minute':
                                return round(($datediff / 60), 2);
                                break;
                        case 'hour':
                                return round(($datediff / 60 * 60), 2);
                                break;
                        case 'day':
                                return round(($datediff / (60 * 60 * 24)), 2);
                                break;
                        case 'week':
                                return round(($datediff / (60 * 60 * 24 * 7)), 2);
                                break;
                        default :
                                return FALSE;
                }
        }

        /**
         * Calculates a percentage.
         * @param type $numerator
         * @param type $denominator
         * @param type $precision
         * @return int
         */
        public static function calculatePercentage($numerator, $denominator, $precision = 0)
        {
                if ((int) $denominator === 0)
                        return 0;
                $percentage = ($numerator / $denominator) * 100;
                return round($percentage, $precision);
        }

        public static function getDirectoryFiles($pattern = '*', $return_associative = true)
        {
                ///var/www/website/app/runtime/application*.log
                $files = array();
                $matches = glob($pattern);
                if (is_array($matches)) {
                        foreach (glob($pattern) as $file) {
                                $files[] = $file;
                        }
                }

                if ($return_associative) {
                        $assc = array();
                        foreach ($files as $k => $v) {
                                $assc[$v] = $v;
                        }
                        return $assc;
                }

                return $files;
        }

        /**
         * Hashes a string based on an algorithm
         * <br/>Please refer to {@link http://php.net/manual/en/function.hash-algos.php} for the supported algorithms for your PHP version<br/>
         * @param string $string The string to be hashed
         * @param string $algorith e.g md5,md2, ripemd256, ripemd320, salsa10, salsa20, snefru256,sha224 etc
         * @param string $raw_output
         */
        public static function generateHash($string = null, $algorith = 'ripemd160', $raw_output = FALSE)
        {
                if ($string === NULL)
                        $string = microtime() . getmypid();

                return hash($algorith, $string, $raw_output);
        }

        /**
         * Parses a given file path and gets the absolute path of directory and the file name
         * @param string $file_path
         * @return array e.g array("name"=>"file_name","dir"=>"absolute path of the directory containing the file")
         */
        public static function parseFilePath($file_path)
        {
                $path_arr = explode(DS, $file_path);
                $file_name = end($path_arr);
                $dir = implode(DS, array_diff($path_arr, array($file_name)));
                return array(
                    'name' => $file_name,
                    'dir' => $dir,
                );
        }

        /**
         * Checks if a function is enabled
         * @param type $function
         * @return boolean
         */
        public static function isFunctionEnabled($function)
        {
                $available = true;
                if (ini_get('safe_mode')) {
                        $available = false;
                } else {
                        $d = ini_get('disable_functions');
                        $s = ini_get('suhosin.executor.func.blacklist');
                        if ("$d$s") {
                                $array = preg_split('/,\s*/', "$d,$s");
                                if (in_array($function, $array)) {
                                        $available = false;
                                }
                        }
                }
                return $available;
        }

        /**
         * Converts xml to json
         * @param type $xml
         * @return type
         */
        public static function convertXmlToJson($xml)
        {
                $xml = str_replace(array("\n", "\r", "\t"), '', $xml);

                $xml = trim(str_replace('"', "'", $xml));

                $simpleXml = simplexml_load_string($xml);

                $json = json_encode($simpleXml);

                return $json;
        }

        /**
         * Adopted from Yii Framework
         * @link http://www.yiiframework.com/doc/api/1.1/CCodeModel#pluralize-detail
         * Converts a word to its plural form.
         * Note that this is for English only!
         * For example, 'apple' will become 'apples', and 'child' will become 'children'.
         * @param string $name the word to be pluralized
         * @return string the pluralized word
         */
        public static function pluralize($name)
        {
                $rules = array(
                    '/(m)ove$/i' => '\1oves',
                    '/(f)oot$/i' => '\1eet',
                    '/(c)hild$/i' => '\1hildren',
                    '/(h)uman$/i' => '\1umans',
                    '/(m)an$/i' => '\1en',
                    '/(s)taff$/i' => '\1taff',
                    '/(t)ooth$/i' => '\1eeth',
                    '/(p)erson$/i' => '\1eople',
                    '/([m|l])ouse$/i' => '\1ice',
                    '/(x|ch|ss|sh|us|as|is|os)$/i' => '\1es',
                    '/([^aeiouy]|qu)y$/i' => '\1ies',
                    '/(?:([^f])fe|([lr])f)$/i' => '\1\2ves',
                    '/(shea|lea|loa|thie)f$/i' => '\1ves',
                    '/([ti])um$/i' => '\1a',
                    '/(tomat|potat|ech|her|vet)o$/i' => '\1oes',
                    '/(bu)s$/i' => '\1ses',
                    '/(ax|test)is$/i' => '\1es',
                    '/s$/' => 's',
                );
                foreach ($rules as $rule => $replacement) {
                        if (preg_match($rule, $name))
                                return preg_replace($rule, $replacement, $name);
                }
                return $name . 's';
        }

}
