<?php

/**
 * This is the model class for table "voteheads".
 *
 * The followings are the available columns in table 'voteheads':
 * @property integer $id
 * @property string $votehead
 * @property string $incomeOrExpense
 */
class Voteheads extends CActiveRecord {

    /**
     * types of vote heads
     */
    const INCOME = 'Income';
    const EXPENSE = 'Expense';

    /**
     * headings for income and expenditure
     */
    const INCOME_HEADING = 'Cash Inflow';
    const EXPENSE_HEADING = 'Cash Outflow';

    /**
     * add a vote head
     */
    const NEW_VOTEHEAD = 'New Votehead';

    /**
     * field types for vote head on form
     */
    const SELECT = 'dropDown';
    const TEXT = 'Enter';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'voteheads';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('votehead, incomeOrExpense', 'required'),
            array('votehead', 'length', 'min' => 4, 'max' => 50),
            array('votehead', 'voteUnique'),
            array('incomeOrExpense', 'length', 'max' => 7),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, votehead, incomeOrExpense', 'safe', 'on' => 'search'),
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
            'votehead' => 'Votehead',
            'incomeOrExpense' => 'Income Or Expense',
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
        $criteria->compare('votehead', $this->votehead, true);
        $criteria->compare('incomeOrExpense', $this->incomeOrExpense, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Voteheads the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * vote head is conditionally unique
     */
    public function voteUnique() {
        if (is_numeric($this->votehead))
            $this->addError('votehead', 'Votehead cannot be numeric');
        else
            foreach ($others = $this->findAll('id!=:id', array(':id' => "'$this->id'")) as $i => $other)
                if (
                        strtoupper($other->votehead) != strtoupper($this->votehead) || strtoupper($other->incomeOrExpense) != strtoupper($this->incomeOrExpense)
                )
                    unset($others[$i]);


        if (!empty($others))
            $this->addError('votehead', 'This votehead already exists');
    }

    /**
     * 
     * @param string $type Income or Expense
     * @return \Voteheads models - voteheads of particular type
     */
    public function voteHeadsForType($type) {
        $cri = new CDbCriteria;
        $cri->condition = 'incomeOrExpense=:type';
        $cri->params = array(':type' => $type);
        $cri->order = 'votehead ASC';

        return $this->findAll($cri);
    }

    /**
     * 
     * @param string $type Income or Expense
     * @return list dropDownList for voteheads
     */
    public function voteHeadDropDowns($type) {
        $items = $this->voteHeadsForType($type);

        $items[$index = count($items)] = new Voteheads;
        $items[$index]->votehead = self::NEW_VOTEHEAD;

        return CHtml::listData($items, 'votehead', 'votehead');
    }

    /**
     * 
     * @return array
     */
    public static function incomeOrExpenditure() {
        return array(
            self::EXPENSE => 'Expenditure Journal',
            self::INCOME => 'Income Journal'
        );
    }

}
