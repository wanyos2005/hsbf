<?php

/**
 * This is the model class for table "next_receipt_no".
 *
 * The followings are the available columns in table 'next_receipt_no':
 * @property string $receiptno
 */
class NextReceiptNo extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'next_receipt_no';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('receiptno', 'required'),
            array('receiptno', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('receiptno', 'safe', 'on' => 'search'),
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
            'receiptno' => 'Receiptno',
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

        $criteria->compare('receiptno', $this->receiptno, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return NextReceiptNo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 
     * @return \NextReceiptNo model
     */
    public function returnReceiptNo() {
        $theNextReceiptNo = $this->find();

        if (empty($theNextReceiptNo))
            $theNextReceiptNo = new NextReceiptNo;

        if (empty($theNextReceiptNo->receiptno))
            $theNextReceiptNo->receiptno = $this->receiptNoFiveDigits(1);

        return $theNextReceiptNo;
    }

    /**
     * 
     * @return int receipt no.
     */
    public function receiptNo() {
        $receiptNo = $this->returnReceiptNo();
        return $this->receiptNoFiveDigits($receiptNo->receiptno);
    }

    /**
     * 
     * @param int $receiptNo receipt no.
     */
    public function updateNextReceiptNo($receiptNo) {
        $theNextReceiptNo = $this->returnReceiptNo();

        if ($receiptNo >= $theNextReceiptNo->receiptno) {
            $theNextReceiptNo->receiptno = $this->receiptNoFiveDigits( ++$receiptNo);
            $theNextReceiptNo->save(false);
        }
    }

    /**
     * 
     * @param array $receipts receipt numbers
     */
    public function printReceipts($receipts) {
        Pdf::model()->executePdf(
                Pdf::PORTRAIT, Pdf::A4, 'Receipts', 'application.views.pdf.receipts', array(
            'receipts' => $receipts
                ), 'Receipts'
        );
    }

    /**
     * at least 5 digits
     * 
     * @param int $receiptNo receipt no
     * @return int receipt no
     */
    public function receiptNoFiveDigits($receiptNo) {
        switch (strlen($receiptNo)) {
            case 1: return "0000$receiptNo";
                break;
            case 2: return "000$receiptNo";
                break;
            case 3: return "00$receiptNo";
                break;
            case 4: return "0$receiptNo";
                break;

            default: return "$receiptNo";
                break;
        }
    }

}
