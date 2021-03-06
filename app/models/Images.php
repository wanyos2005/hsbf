<?php

/**
 * This is the model class for table "{{images}}".
 *
 * The followings are the available columns in table '{{images}}':
 * @property integer $id
 * @property string $image
 */
class Images extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_images';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('image', 'file', 'types' => 'jpg, jpeg, png'),
            array('image', 'length', 'max' => 128),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, image', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'image' => 'Passport Image',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('image', $this->image, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Images the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Assign image attribute
     * 
     * @param array $model model for which to include image
     * @param string $attribute attribute name for image
     * @param string $folder name of folder in which to save image
     */
    public function picha($model, $attribute, $folder) {
        $image = new Images;

        if (isset($_POST['Images'])) {
            $image->image = CUploadedFile::getInstance($image, 'image');
            if (!empty($image->image)) {
                $model->$attribute = $image->image;
                $model->$attribute->saveAs($folder.$model->$attribute);
            }
        }
    }

}
