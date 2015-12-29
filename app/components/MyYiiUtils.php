<?php

if (!defined('YII_PATH'))
        exit('No direct script access allowed');

/**
 * Contains all utility functions that depends on YII
 * Created on 17th Sep. 2013
 * @author Fred <mconyango@gmail.com>
 */
class MyYiiUtils {

        /**
         * Generate a random string
         * wrapper function for CsecurityManager::generateRandomString()
         * @param type $length
         * @return type
         */
        public static function generateRandomString($length = 8)
        {
                return Yii::app()->getSecurityManager()->generateRandomString($length);
        }

        /**
         * Format date
         * @param type $date
         * @param type $format
         * @return type
         */
        public static function formatDate($date, $format = 'M j, Y g:i a')
        {
                if (empty($date))
                        return NULL;
                return Yii::app()->localtime->toLocalDateTime($date, $format);
        }

        /**
         * Create an image thumb using easyImage extension
         * Requires easyImage Yii extension.
         * @link http://www.yiiframework.com/extension/easyimage/
         * @param string $original_path
         * @param string $new_path
         * @param integer $width
         * @param integer $height
         */
        public static function createEasyImageThumb($original_path, $new_path, $width = 256, $height = 256)
        {
                $image = new EasyImage($original_path);
                $image->resize($width, $height);
                $image->save($new_path);
                if ($original_path !== $new_path)
                        @unlink($original_path);
        }

        /**
         * Creates a thumbnail from the original image and return the thumbnail url
         *
         * @param string $image_path Path to original image
         * @param array $options {@link Yii::app()->easyImage->thumbof()} image options
         * @example  $options  array("resize"=>array("width"=>128,"height"=>120),"background"=>"#fff","type"=>"jpg","quality"=>100)
         * @param string $default
         * @return string image url
         */
        public static function getThumbSrc($image_path, $options = array(), $default = null)
        {
                if (empty($image_path) || !file_exists($image_path)) {
                        if (empty($default)) {
                                $default = 'http://placehold.it/';
                                if (!isset($options['resize'])) {
                                        $dimensions = '200x200';
                                } else {
                                        $dimensions = !empty($options['resize']['width']) ? $options['resize']['width'] : '200';
                                        $dimensions.='x';
                                        $dimensions.=!empty($options['resize']['height']) ? $options['resize']['height'] : '200';
                                }
                                $default.=$dimensions . '&text=' . urlencode('No Image');
                        }
                        return $default;
                }

                //default background
                if (!isset($options['background'])) {
                        $options['background'] = array(
                            'color' => '#ffffff',
                            'opacity' => '1',
                        );
                }
                //default type
                if (!isset($options['type'])) {
                        $options['type'] = 'jpg';
                }
                //default quality
                if (!isset($options['quality'])) {
                        $options['quality'] = 100;
                }

                return Yii::app()->easyImage->thumbSrcOf($image_path, $options);
        }

        /**
         * Formats an amount to money format e.g $300.00 etc
         * @param double $amount
         * @param integer $decimals defaults to 0
         * @param boolean $symbol If set to TRUE formats using the currency symbol.
         * @return string The formatted amount
         */
        public static function formatMoney($amount, $decimals = 2, $symbol = true)
        {
                $currency = Yii::app()->settings->get(Constants::CATEGORY_GENERAL, Constants::KEY_CURRENCY, 'USD');
                return SettingsCurrency::model()->formatMoney($currency, $amount, $decimals, $symbol);
        }

        /**
         * Shortens a long string and inserts a suffix
         * @param type $string
         * @param type $maxLength
         * @param type $suffix
         * @param  mixed $word_wrap_width
         * @return type
         */
        public static function myShortenedString($string, $maxLength, $suffix = '...', $word_wrap_width = null)
        {
                $string = CHtml::encode($string);
                if (strlen($string) > $maxLength)
                        $new_string = substr($string, 0, $maxLength);
                else
                        $new_string = $string;
                if ($word_wrap_width && strlen($new_string) > $word_wrap_width)
                        $new_string = Common::smartWordwrap($new_string, $word_wrap_width, '<br/>');
                if (strlen($string) > $maxLength)
                        $new_string.=$suffix;
                return $new_string;
        }

        /**
         * This function chuncks a given string using a given line break
         * example: "yellow,green,red"  will become "yellow<br/>green<br/>red" where "<br/>" is the line break
         * @param string $string
         * @param string $line_break
         * @param string $separator what separates the given string. Mostly a comma (,)
         * @param boolean $linkify Whether to link each chunk
         * @param string $route The action route. Only necessary if $linkify is true.
         * @param string $chunk_param_key The $_GET param key for the chunk. Only necessary if $linkify is true.
         * @param array $other_params The $key=>$value pair of other params if any. Only necessary if $linkify is true.
         * @return string The chunked string.
         */
        public static function chunkString($string, $line_break = '<br/>', $separator = ',', $linkify = false, $route = '', $chunk_param_key = null, $other_params = array())
        {
                if (empty($string))
                        return $string;

                $new_string = '';
                $string_arr = explode($separator, $string);

                foreach ($string_arr as $str) {
                        if ($linkify) {
                                $params = $other_params;
                                $params[$chunk_param_key] = $str;
                                $link = CHtml::link($str, Yii::app()->createUrl($route, $params), array());
                                $new_string.=$link . $line_break;
                        } else
                                $new_string.=$str . $line_break;
                }
                //remove the last line break
                return preg_replace('/' . preg_quote($line_break, '/') . '$/', '', $new_string);
        }

        /**
         * Deletes all temp files in the temp folder
         * more than chunksExpireIn seconds ago
         * @param type $expiry_secs default is 86400sec (1 day)
         */
        public static function clearTempFiles($expiry_secs = 86400)
        {
                defined('APP_TEMP_DIR') or define('APP_TEMP_DIR', Yii::getPathOfAlias('webroot') . DS . 'public' . DS . 'temp');
                foreach (scandir(APP_TEMP_DIR) as $item) {
                        if ($item == "." || $item == "..")
                                continue;
                        $path = APP_TEMP_DIR . DS . $item;

                        if (is_file($path) && (time() - filemtime($path) >= $expiry_secs))
                                @unlink($path);

                        elseif (is_dir($path) && (time() - filemtime($path) >= $expiry_secs)) {
                                Common::deleteDir($path);
                        }
                }
        }

}
