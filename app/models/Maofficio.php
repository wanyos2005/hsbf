<?php

/**
 * This is the model class for table "maofficio".
 *
 * The followings are the available columns in table 'maofficio':
 * @property integer $id
 * @property integer $post
 * @property integer $member
 * @property string $since
 * @property string $till
 */
class Maofficio extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'maofficio';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('post, member, since', 'required'),
            array('post, member', 'numerical', 'integerOnly' => true),
            array('till', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, post, member, since, till', 'safe', 'on' => 'search'),
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
            'post' => 'Post',
            'member' => 'Member',
            'since' => 'Since',
            'till' => 'Till',
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
        $criteria->compare('post', $this->post);
        $criteria->compare('member', $this->member);
        $criteria->compare('since', $this->since, true);
        $criteria->compare('till', $this->till, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Maofficio the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Returns member currently holding the given post
     * 
     * @param int $post
     * @return \Maofficio
     */
    public function returnCurrentPostHolder($post) {
        $today = date('Y') . '-' . date('m') . '-' . date('d');
        return Maofficio::model()->find('post=:post && since<=:tdy && till IS NULL', array(':post' => $post, ':tdy' => $today));
    }

    /**
     * Returns the member holding the given post at a given date
     * 
     * @param int $post
     * @param date $date
     * @return \Maofficio
     */
    public function returnPostHolderAtDate($post, $date) {
        $officio = Maofficio::model()->find('post=:post && since<=:tdy && till IS NULL', array(':post' => $post, ':tdy' => $date));

        if (empty($officio))
            $officio = Maofficio::model()->find('post=:post && since<=:tdy && till>:tdy', array(':post' => $post, ':tdy' => $date));

        return $officio;
    }

    /**
     * Establish authority of current user
     * 
     * @return string
     */
    public function officio() {
        $id = Yii::app()->user->id;

        $currentChairman = Maofficio::model()->returnCurrentPostHolder(1);
        if (!empty($currentChairman) && $currentChairman->member == $id)
            return 'chairman';

        $currentSecretary = Maofficio::model()->returnCurrentPostHolder(2);
        if (!empty($currentSecretary) && $currentSecretary->member == $id)
            return 'secretary';

        $currentTreasurer = Maofficio::model()->returnCurrentPostHolder(3);
        if (!empty($currentTreasurer) && $currentTreasurer->member == $id)
            return 'treasurer';
    }

}
