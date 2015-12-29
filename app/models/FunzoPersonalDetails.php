<?php

/**
 * This is the model class for table "funzo_personal_details".
 *
 * The followings are the available columns in table 'funzo_personal_details':
 * @property integer $APP_ID
 * @property string $MIDDLE_NAME
 * @property string $LAST_NAME
 * @property string $FAST_NAME
 * @property string $IDno
 * @property string $PINNO
 * @property string $DOB
 * @property string $GENDER
 * @property string $EMAIL
 * @property string $IMPAIRED_IDFK
 * @property string $TEL_
 * @property string $BOX_NO
 * @property string $POSTAL_CODE
 * @property string $TOWN
 * @property string $LOCATION
 * @property string $DIVISION
 * @property integer $DISTRICT_IDFK
 * @property integer $APPLICATION_TYPE
 * @property string $SERIAL_NO
 * @property string $EMPLOYED
 * @property integer $CONSTITUENCY_IDFK
 * @property integer $FORM_PRINT
 * @property string $DATE_POSTED
 * @property integer $COUNTY_IDFK
 * @property integer $M_STATUS
 * @property string $SPOUSE_NAME
 * @property integer $CURR_COUNTY_IDFK
 * @property string $CATEGORY
 * @property string $LOAN_TYPE
 * @property string $SERVICE_TYPE
 * @property string $DOB_D
 * @property string $DOB_M
 * @property string $DOB_Y
 */
class FunzoPersonalDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'funzo_personal_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('APP_ID, DISTRICT_IDFK, APPLICATION_TYPE, CONSTITUENCY_IDFK, FORM_PRINT, COUNTY_IDFK, M_STATUS, CURR_COUNTY_IDFK', 'numerical', 'integerOnly'=>true),
			array('MIDDLE_NAME, LAST_NAME, FAST_NAME, IDno, EMAIL, TEL_, SPOUSE_NAME', 'length', 'max'=>50),
			array('PINNO', 'length', 'max'=>48),
			array('DOB, GENDER, IMPAIRED_IDFK, DATE_POSTED', 'length', 'max'=>20),
			array('BOX_NO, POSTAL_CODE, TOWN, LOCATION, DIVISION, SERIAL_NO, EMPLOYED', 'length', 'max'=>200),
			array('CATEGORY', 'length', 'max'=>25),
			array('LOAN_TYPE, SERVICE_TYPE', 'length', 'max'=>30),
			array('DOB_D, DOB_M, DOB_Y', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('APP_ID, MIDDLE_NAME, LAST_NAME, FAST_NAME, IDno, PINNO, DOB, GENDER, EMAIL, IMPAIRED_IDFK, TEL_, BOX_NO, POSTAL_CODE, TOWN, LOCATION, DIVISION, DISTRICT_IDFK, APPLICATION_TYPE, SERIAL_NO, EMPLOYED, CONSTITUENCY_IDFK, FORM_PRINT, DATE_POSTED, COUNTY_IDFK, M_STATUS, SPOUSE_NAME, CURR_COUNTY_IDFK, CATEGORY, LOAN_TYPE, SERVICE_TYPE, DOB_D, DOB_M, DOB_Y', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'APP_ID' => 'App',
			'MIDDLE_NAME' => 'Middle Name',
			'LAST_NAME' => 'Last Name',
			'FAST_NAME' => 'Fast Name',
			'IDno' => 'Idno',
			'PINNO' => 'Pinno',
			'DOB' => 'Dob',
			'GENDER' => 'Gender',
			'EMAIL' => 'Email',
			'IMPAIRED_IDFK' => 'Impaired Idfk',
			'TEL_' => 'Tel',
			'BOX_NO' => 'Box No',
			'POSTAL_CODE' => 'Postal Code',
			'TOWN' => 'Town',
			'LOCATION' => 'Location',
			'DIVISION' => 'Division',
			'DISTRICT_IDFK' => 'District Idfk',
			'APPLICATION_TYPE' => 'Application Type',
			'SERIAL_NO' => 'Serial No',
			'EMPLOYED' => 'Employed',
			'CONSTITUENCY_IDFK' => 'Constituency Idfk',
			'FORM_PRINT' => 'Form Print',
			'DATE_POSTED' => 'Date Posted',
			'COUNTY_IDFK' => 'County Idfk',
			'M_STATUS' => 'M Status',
			'SPOUSE_NAME' => 'Spouse Name',
			'CURR_COUNTY_IDFK' => 'Curr County Idfk',
			'CATEGORY' => 'Category',
			'LOAN_TYPE' => 'Loan Type',
			'SERVICE_TYPE' => 'Service Type',
			'DOB_D' => 'Dob D',
			'DOB_M' => 'Dob M',
			'DOB_Y' => 'Dob Y',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('APP_ID',$this->APP_ID);
		$criteria->compare('MIDDLE_NAME',$this->MIDDLE_NAME,true);
		$criteria->compare('LAST_NAME',$this->LAST_NAME,true);
		$criteria->compare('FAST_NAME',$this->FAST_NAME,true);
		$criteria->compare('IDno',$this->IDno,true);
		$criteria->compare('PINNO',$this->PINNO,true);
		$criteria->compare('DOB',$this->DOB,true);
		$criteria->compare('GENDER',$this->GENDER,true);
		$criteria->compare('EMAIL',$this->EMAIL,true);
		$criteria->compare('IMPAIRED_IDFK',$this->IMPAIRED_IDFK,true);
		$criteria->compare('TEL_',$this->TEL_,true);
		$criteria->compare('BOX_NO',$this->BOX_NO,true);
		$criteria->compare('POSTAL_CODE',$this->POSTAL_CODE,true);
		$criteria->compare('TOWN',$this->TOWN,true);
		$criteria->compare('LOCATION',$this->LOCATION,true);
		$criteria->compare('DIVISION',$this->DIVISION,true);
		$criteria->compare('DISTRICT_IDFK',$this->DISTRICT_IDFK);
		$criteria->compare('APPLICATION_TYPE',$this->APPLICATION_TYPE);
		$criteria->compare('SERIAL_NO',$this->SERIAL_NO,true);
		$criteria->compare('EMPLOYED',$this->EMPLOYED,true);
		$criteria->compare('CONSTITUENCY_IDFK',$this->CONSTITUENCY_IDFK);
		$criteria->compare('FORM_PRINT',$this->FORM_PRINT);
		$criteria->compare('DATE_POSTED',$this->DATE_POSTED,true);
		$criteria->compare('COUNTY_IDFK',$this->COUNTY_IDFK);
		$criteria->compare('M_STATUS',$this->M_STATUS);
		$criteria->compare('SPOUSE_NAME',$this->SPOUSE_NAME,true);
		$criteria->compare('CURR_COUNTY_IDFK',$this->CURR_COUNTY_IDFK);
		$criteria->compare('CATEGORY',$this->CATEGORY,true);
		$criteria->compare('LOAN_TYPE',$this->LOAN_TYPE,true);
		$criteria->compare('SERVICE_TYPE',$this->SERVICE_TYPE,true);
		$criteria->compare('DOB_D',$this->DOB_D,true);
		$criteria->compare('DOB_M',$this->DOB_M,true);
		$criteria->compare('DOB_Y',$this->DOB_Y,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FunzoPersonalDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
