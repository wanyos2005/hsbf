<?php

/**
 * This is the model class for table "modules_enabled".
 *
 * The followings are the available columns in table 'modules_enabled':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $status
 * @property string $date_created
 * @property integer $created_by
 */
class ModulesEnabled extends ActiveRecord implements IMyActiveSearch {

    const STATUS_ENABLED = 'Enabled';
    const STATUS_DISABLED = 'Disabled';
    //module constants
    const MOD_DEPT = 'dept';
    const MOD_PARKING = 'parking';
    const MOD_BUSINESS_PERMIT = 'bizpermit';
    const MOD_LAND_RATES = 'landrates';
    const MOD_MARKET_FEES = 'marketfees';
    const MOD_CESS = 'cess';
    const MOD_INCOME = 'income';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'modules_enabled';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {

        return array(
            array('id, name', 'required'),
            array('created_by', 'numerical', 'integerOnly' => true),
            array('id, name', 'length', 'max' => 30),
            array('description', 'length', 'max' => 255),
            array('status', 'length', 'max' => 10),
            array('id,' . self::SEARCH_FIELD, 'safe', 'on' => self::SCENARIO_SEARCH),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Lang::t('Module ID'),
            'name' => Lang::t('Module Name'),
            'description' => Lang::t('Description'),
            'status' => Lang::t('Status'),
            'date_created' => Lang::t('Date Created'),
            'created_by' => Lang::t('Created By'),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ModulesEnabled the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchParams() {
        return array(
            array('id', self::SEARCH_FIELD, true, 'OR'),
            array('name', self::SEARCH_FIELD, true, 'OR'),
            'status',
        );
    }

    public static function getStatuses() {
        return array(
            self::STATUS_ENABLED => Lang::t(self::STATUS_ENABLED),
            self::STATUS_DISABLED => Lang::t(self::STATUS_DISABLED),
        );
    }

    /**
     * Check if module is enabled
     * @param type $id
     * @return type
     */
    public function isModuleEnabled($id) {
        return $this->exists('`id`=:id AND `status`=:status', array(':id' => $id, ':status' => self::STATUS_ENABLED));
    }

}
