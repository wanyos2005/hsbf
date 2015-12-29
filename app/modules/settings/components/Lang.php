<?php

/**
 * Language translation class
 * @author Fred <mconyango@gmail.com>
 */
class Lang {

    const CATEGORY = 'core';

    /**
     * Language translator
     * This a wrapper function for {@see Yii::t()}. Please note that this function should only be used in Yii projects.
     * @param string $text
     * @param array $params
     * @return string Translated text.
     */
    public static function t($text, $params = array()) {
        if (empty($text))
            return $text;
        return Yii::t(self::CATEGORY, $text, $params);
    }

}
