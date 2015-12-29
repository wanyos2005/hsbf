<?php

/**
 * This is the model class for table "person".
 *
 * The followings are the available columns in table 'person':
 * @property string $id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $idno
 * @property string $gender
 * @property string $birthdate
 * @property integer $birthdate_estimated
 * @property string $profile_image
 * @property string $date_created
 * @property string $created_by
 * @property string $last_modified
 * @property string $membershipno
 * @property string $department
 * @property string $payrollno
 * @property string $married
 * @property string $havechildren
 *
 * The followings are the available model relations:
 * @property PersonAddress[] $personAddresses
 */
class Person extends ActiveRecord {

    //gender constants
    const GENDER_MALE = 'Male';
    const GENDER_FEMALE = 'Female';
    //base dir name where images and files are stores
    const BASE_DIR = 'profile';

    /**
     * Holds the temp file for profile image if file upload via ajax.
     * @var type
     */
    public $temp_profile_image;

    /**
     * Full name of the person
     * @var type
     */
    public $name;
    //birthdate variables
    public $birthdate_year;
    public $birthdate_month;
    public $birthdate_day;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'person';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('first_name,middle_name, last_name, idno, married, havechildren', 'required'),
            array('birthdate_estimated,idno, membershipno, department', 'numerical', 'integerOnly' => true),
            array('first_name, middle_name, last_name', 'length', 'min' => 4, 'max' => 30),
            array('gender', 'length', 'max' => 6),
//            array('membershipno','membershipNoRequired'),
            array('married, havechildren', 'length', 'is' => 1),
            array('idno', 'length', 'min' => 7, 'max' => 8),
            array('payrollno', 'length', 'min' => 4, 'max' => 10),
            array('profile_image', 'length', 'max' => 128),
            array('created_by', 'length', 'max' => 10),
            array('idno', 'unique'),
            array('birthdate', 'date', 'format' => 'yyyy-M-d', 'message' => Lang::t('Please choose a valid birthdate')),
            array('birthdate, idno,last_modified,temp_profile_image,birthdate_year,birthdate_month,birthdate_day', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'personAddresses' => array(self::HAS_MANY, 'PersonAddress', 'person_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Lang::t('ID'),
            'first_name' => Lang::t('First Name'),
            'middle_name' => Lang::t('Middle Name'),
            'last_name' => Lang::t('Last Name'),
            'idno' => Lang::t('National ID. No.'),
            'gender' => Lang::t('Gender'),
            'birthdate' => Lang::t('Birthdate'),
            'birthdate_estimated' => Lang::t('Birthdate Estimated'),
            'profile_image' => Lang::t('Profile Image'),
            'date_created' => Lang::t('Date Created'),
            'membershipno' => Lang::t('Membership No.'),
            'department' => Lang::t('Department'),
            'payrollno' => Lang::t('Payroll No.'),
            'married' => Lang::t('Married'),
            'havechildren' => Lang::t('Have Children'),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Person the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function membershipNoRequired() {
        if (!$this->isNewRecord && empty($this->membershipno))
            $this->addError('membershipno', $this->generateAttributeLabel('membershipno') . ' is required!');
    }

    /**
     * 
     * @param string $idno person idno
     * @return \Person model
     */
    public function memberByIdno($idno) {
        return $this->find('idno=:idno', array(':idno' => $idno));
    }

    public function beforeSave() {
        if (!empty($this->id))
            $this->setProfileImage();
        return parent::beforeSave();
    }

    public function afterDelete() {
        $dir = $this->getBaseDir() . DS . $this->id;
        if (is_dir($dir))
            Common::deleteDir($dir);

        return parent::afterDelete();
    }

    /**
     * Get the dir of a user
     * @param string $id
     */
    public function getDir($id = null) {
        if (!empty($this->id))
            $id = $this->id;
        return Common::createDir($this->getBaseDir() . DS . $id);
    }

    public function getBaseDir() {
        return Common::createDir(PUBLIC_DIR . DS . self::BASE_DIR);
    }

    /**
     * Gets user profile image path
     * @param type $id
     * @return string
     */
    public function getProfileImagePath($id = null) {
        if (!empty($this->id))
            $id = $this->id;
        $profile_image = !empty($this->id) ? $this->profile_image : $this->get($id, 'profile_image');
        if (!empty($profile_image)) {
            $file_path = $this->getDir($id) . DS . $profile_image;

            if (file_exists($file_path))
                return $file_path;
        }
        return $this->getDefaultProfileImagePath();
    }

    protected function getDefaultProfileImagePath() {
        return Yii::getPathOfAlias('webroot.themes') . DS . Yii::app()->theme->name . DS . 'images' . DS . 'default-profile-image.png';
    }

    public function setProfileImage() {
        //using fineuploader
        if (!empty($this->temp_profile_image)) {
            $temp_file = Common::parseFilePath($this->temp_profile_image);
            $file_name = $temp_file['name'];
            $temp_dir = $temp_file['dir'];
            if (copy($this->temp_profile_image, $this->getDir() . DS . $file_name)) {
                if (!empty($temp_dir))
                    Common::deleteDir($temp_dir);
                $this->profile_image = $file_name;
                $this->temp_profile_image = null;
            }
        }
    }

    public function afterFind() {
        $this->name = $this->first_name . " " . $this->last_name;
        if (!empty($this->birthdate)) {
            $this->birthdate_day = Common::formatDate($this->birthdate, 'd');
            $this->birthdate_month = Common::formatDate($this->birthdate, 'm');
            $this->birthdate_year = Common::formatDate($this->birthdate, 'Y');
        }
        return parent::afterFind();
    }

    public function beforeValidate() {
        if (!empty($this->birthdate_day) || !empty($this->birthdate_month) || !empty($this->birthdate_year))
            $this->birthdate = $this->birthdate_year . "-" . $this->birthdate_month . "-" . $this->birthdate_day;
        return parent::beforeValidate();
    }

    /**
     * Get gender options
     * @return array Gender Options
     */
    public static function genderOptions() {
        return array(
            self::GENDER_MALE => Lang::t(self::GENDER_MALE),
            self::GENDER_FEMALE => Lang::t(self::GENDER_FEMALE),
        );
    }

    /**
     * Birth date year options
     * @return type
     */
    public static function birthDateYearOptions() {
        $min_year = 10;
        $max_year = 100;
        $current_year = date('Y');
        $years = array('' => Lang::t('Year'));

        for ($i = $min_year; $i <= $max_year; $i++) {
            $year = $current_year - $i;
            $years[$year] = $year;
        }

        return $years;
    }

    /**
     * Birth date month options
     * @return type
     */
    public static function birthDateMonthOptions() {
        return array(
            '' => Lang::t('Month'),
            1 => Lang::t('Jan'),
            2 => Lang::t('Feb'),
            3 => Lang::t('Mar'),
            4 => Lang::t('Apr'),
            5 => Lang::t('May'),
            6 => Lang::t('Jun'),
            7 => Lang::t('Jul'),
            8 => Lang::t('Aug'),
            9 => Lang::t('Sep'),
            10 => Lang::t('Oct'),
            11 => Lang::t('Nov'),
            12 => Lang::t('Dec'),
        );
    }

    /**
     * Birthdate day options
     * @return type
     */
    public static function birthDateDayOptions() {
        $days = array('' => Lang::t('Day'));
        for ($i = 1; $i <= 31; $i++) {
            $days[$i] = $i;
        }
        return $days;
    }

    /**
     * 
     * @param \Person $persons
     * @return \Person
     */
    public function onlyActiveMembers($persons) {
        foreach ($persons as $p => $person)
            if ($this->personHasActiveAccount($person) == false)
                unset($persons[$p]);

        return empty($persons) ? array() : $persons;
    }

    /**
     * 
     * @param \Person $person
     */
    public function personHasActiveAccount($person) {
        return Users::model()->accountActive(Users::model()->findByPk($person->primaryKey));
    }

    /**
     * @return Person models
     */
    public function membersForTrialBalance() {
        $incm = Incomes::model()->tableName();
        $exps = Expenditures::model()->tableName();
        $user = Users::model()->tableName();

        $cri = new CDbCriteria;
        $cri->select = 't.id, t.first_name, t.middle_name, t.last_name';
        $cri->distinct = true;

        $cri->condition = "(EXISTS (SELECT member FROM $incm WHERE member=t.id LIMIT 1) || "
                . "EXISTS (SELECT member FROM $exps WHERE member=t.id LIMIT 1)) && "
                . "EXISTS (SELECT id FROM $user WHERE id=t.id && status=:stts)";

        $cri->params = array(':stts' => Users::STATUS_ACTIVE);

        $cri->order = 't.first_name ASC, t.middle_name ASC, t.last_name ASC';

        return $this->findAll($cri);
    }

}
