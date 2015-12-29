<?php

/**
 * This is the model class for table "contributions_by_members".
 *
 * The followings are the available columns in table 'contributions_by_members':
 * @property integer $id
 * @property integer $member
 * @property integer $contribution_type
 * @property string $amount
 * @property string $date
 * @property string $loan_application
 * @property string $savings_interest
 * @property string $receiptno
 * @property string $receiptno_again
 * @property string $payment_mode
 * @property string $transaction_no
 */
class ContributionsByMembers extends CActiveRecord {

    const DEPOSIT = 'Deposit';
    const WITHDRAWAL = 'Withdrawal';
    const DATE = 'date';
    const RECEIPT = 'receipt';
    const FALSE_RECEIPT = '999999999999';
    const SAVINGS_INTEREST = 5;

    /**
     * payment modes
     */
    const PAYMENT_BY_CASH = 'Cash';
    const PAYMENT_BY_BANK = 'Bank';
    const PAYMENT_BY_MPESA = 'M-Pesa';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'contributions_by_members';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('member, contribution_type, amount, date, receiptno', 'required'),
            array('member, contribution_type', 'numerical', 'integerOnly' => true),
            array('amount', 'numerical', 'min' => 0.001),
            array('receiptno, receiptno_again', 'length', 'max' => 20),
            array('payment_mode, transaction_no', 'length', 'max' => 10),
            array('transaction_no', 'transactionNo'),
            array('amount, loan_application', 'length', 'max' => 11),
            array('savings_interest', 'length', 'max' => 5),
            array('receiptno', 'uniqueReceiptNo'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, member, contribution_type, amount, date, loan_application, savings_interest, receiptno, receiptno_again, payment_mode, transaction_no', 'safe', 'on' => 'search'),
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
            'member' => 'Member',
            'contribution_type' => 'Contribution Type',
            'amount' => 'Amount',
            'date' => 'Date',
            'loan_application' => 'Loan Application',
            'savings_interest' => 'Interest On Savings',
            'receiptno' => 'Receipt No.',
            'receiptno_again' => 'Copy Receipt No.',
            'payment_mode' => 'Payment Mode',
            'transaction_no' => 'Transaction No.'
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('member', $this->member);
        $criteria->compare('contribution_type', $this->contribution_type);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('loan_application', $this->loan_application, true);
        $criteria->compare('savings_interest', $this->savings_interest, true);
        $criteria->compare('receiptno', $this->receiptno, true);
        $criteria->compare('receiptno_again', $this->receiptno, true);
        $criteria->compare('payment_mode', $this->payment_mode, true);
        $criteria->compare('transaction_no', $this->transaction_no, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ContributionsByMembers the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * receiptno is conditionally unique
     */
    public function uniqueReceiptNo() {
        if (empty($this->receiptno_again)) {
            $otherReceipt = $this->find(
                    "id!=:id && receiptno=:rcptNo && (receiptno_again IS NULL || receiptno_again='')", //
                    array(':id' => "'$this->id'", ':rcptNo' => $this->receiptno)
            );

            if (!empty($otherReceipt))
                $this->addError('receiptno', 'This Receipt No. Already Exists!');
        }
    }

    /**
     * transaction no required conditionally
     */
    public function transactionNo() {
        if ($this->payment_mode != self::PAYMENT_BY_CASH)
            if (empty($this->transaction_no))
                $this->addError('transaction_no', $this->getAttributeLabel('transaction_no') . ' is required');
    }

    /**
     * Determine which types of contributions a member can make
     * 
     * @param int $member person id
     * @return \ContributionTypes models
     */
    public function contributionType($member) {
        $cri = new CDbCriteria;

        if ($this->registrationFees($member) < RegistrationAndMonthlyContributionAmounts::model()->amount(1))
            $cri->condition = 'id=1';
        else
            $cri->condition = 'id>1';


        $cri->order = 'contribution_type ASC';

        return ContributionTypes::model()->findAll($cri);
    }

    /**
     * 
     * @return array payment modes
     */
    public function paymentModes() {
        return array(
            self::PAYMENT_BY_CASH => self::PAYMENT_BY_CASH,
            self::PAYMENT_BY_BANK => self::PAYMENT_BY_BANK,
            self::PAYMENT_BY_MPESA => self::PAYMENT_BY_MPESA
        );
    }
    
    /**
     * 
     * @param id $pk contribution by members id
     * @return int savings id
     */
    public function savingIdForContribution($pk) {
        $contribution = $this->returnAContribution($pk);
        if (is_object($contribution) && $contribution->contribution_type == 3) {
            foreach (Savings::model()->latestSavingHistoryBetweenAndIncludingTheseDates($pk, $contribution->date, $contribution->date) as $saving)
                ;
            
            if (isset($saving) && is_object($saving))
                return $saving->id;
        }
    }

    /**
     * Save a contribution conditionally
     * then record a loan repayment appropriately
     * and update subsequent loan repayments.
     * 
     * @param \ContributionsByMembers $model
     * @param boolean $rectifySubsequentRepayments TRUE = Rectify Subsequent Loan Repayments; FALSE = Not Rectify Subsequent Loan Repayments
     */
    public function modelSave($model, $rectifySubsequentRepayments) {
        if (($new = $model->isNewRecord) && empty($model->amount))
            ; //don't save
        else
        if ($model->save()) {
            if ($model->contribution_type == 4 && $rectifySubsequentRepayments == true)
                LoanRepayments::model()->updateRepayments($model);

            if ($new && $model->contribution_type == 3)
                Savings::model()->contributionToSavings($model);

            Incomes::model()->contributionIsIncome($model);

            NextReceiptNo::model()->updateNextReceiptNo($model->receiptno);

            Yii::app()->user->setFlash('saved', 'Your contribution has been succcessfully saved');

            return true;
        }

        return false;
    }

    /**
     * 
     * @param int $member person id
     * @return int contribution type id
     */
    public function bankContributionType($member) {
        foreach ($this->contributionType($member) as $contributionType)
            if ($contributionType->id == 1 || $contributionType->id == 4)
                return $contributionType->id;
            else
                return 2;
    }

    /**
     * 
     * @param int $receiptNo receipt no
     * @param int $contributionType contribution type id
     * @param int $loanApplication loan application id
     * @return \ContributionsByMembers model
     */
    public function modelToSave($receiptNo, $contributionType, $loanApplication) {
        if (empty($loanApplication))
            return $this->find("receiptno=:rcpt && contribution_type=:type", array(':rcpt' => $receiptNo, ':type' => $contributionType));

        return $this->find("receiptno=:rcpt && contribution_type=:type && loan_application=:loan", array(':rcpt' => $receiptNo, ':type' => $contributionType, ':loan' => $loanApplication));
    }

    /**
     * 
     * @param int $member person id
     * @param date $date date of contribution
     * @param int $receiptNo receipt no
     * @param \LoanRepayments $loansMemberIsServicing models
     * @return \ContributionsByMembers models - contribution shared between loan repayments and monthly contribution
     */
    public function splitContributionIntoVariousPaymentTypes($member, $date, $receiptNo, $loansMemberIsServicing) {
        $contributions = array();

        $totalOverPayment = 0;
        foreach ($loansMemberIsServicing as $loanApplicationId => $loanMemberIsServicing) {
            $overPayment = 0;
            $contributions[$count = count($contributions)] = $this->modelToSave($receiptNo, 4, $loanMemberIsServicing->primaryKey);
            if (empty($contributions[$count])) {
                $contributions[$count] = new ContributionsByMembers;
                $contributions[$count]->member = $member;
                $contributions[$count]->contribution_type = 4;
                $contributions[$count]->receiptno = $receiptNo;
                $contributions[$count]->date = $date;
                $contributions[$count]->loan_application = $loanApplicationId;
                if ($count > 0)
                    $contributions[$count]->receiptno_again = $contributions[$count]->receiptno;
            }
            $overPayment = $loanMemberIsServicing->amountrecovered - $loanMemberIsServicing->balance;
            $overPayment = $overPayment <= 0 ? 0 : $overPayment;

            $contributions[$count]->amount = $loanMemberIsServicing->amountrecovered - $overPayment;
            $totalOverPayment = $totalOverPayment + $overPayment;
        }

        $contributions[$count = count($contributions)] = $this->modelToSave($receiptNo, 2, null);
        if (empty($contributions[$count])) {
            $contributions[$count] = new ContributionsByMembers;
            $contributions[$count]->member = $member;
            $contributions[$count]->contribution_type = 2;
            $contributions[$count]->receiptno = $receiptNo;
            $contributions[$count]->date = $date;
            if ($count > 0)
                $contributions[$count]->receiptno_again = $contributions[$count]->receiptno;
        }
        $contributions[$count]->amount = round($totalOverPayment, 3);

        echo $totalOverPayment;

        return $contributions;
    }

    /**
     * 
     * @param int $member person id
     * @return double total registration paid
     */
    public function registrationFees($member) {
        return $this->computeTotals($this->memberRegistrationRecords($member));
    }

    /**
     * 
     * @param int $member person id
     * @return \ContributionsByMembers payments towards registration fees
     */
    public function memberRegistrationRecords($member) {
        return $this->findAll('contribution_type=1 && member=:mbr', array(':mbr' => $member));
    }

    /**
     * save bank payment as contribution and copy transaction
     */
    public function bankPayments() {
        foreach (BankPayments::model()->pendingBankPayments() as $bankPayment) {
            $person = Person::model()->memberByIdno($bankPayment->idno);
            if (!empty($person))
                if (
                        $this->rowsToCreate(
                                new ContributionsByMembers, $person->primaryKey, $bankPayment->contribution_type, $bankPayment->amount, $bankPayment->date, NextReceiptNo::model()->receiptNo()
                        )
                )
                    $bankPayment->copyBankPayment($bankPayment);
        }
    }

    /**
     * 
     * @param \ContributionsByMembers $contribution model
     * @param int $person person id
     * @param int $contribution_type contribution type id
     * @param double $amount amount contributed
     * @param date $date date of contribution
     * @param int $receiptNo receipt no
     * @param \LoanRepayments $loansMemberIsServicing models
     * @return \ContributionsByMembers models
     */
    public function rowsToCreate($contribution, $person, $contribution_type, $amount, $date, $receiptNo, $loansMemberIsServicing) {
        if ($contribution_type != 4) {
            if ($contribution->isNewRecord) {
                $contribution->member = $person;
                $contribution->contribution_type = $contribution_type;
                $contribution->date = $date;
                if (empty($contribution->receiptno))
                    $contribution->receiptno = $receiptNo;

                if ($contribution_type == 3)
                    $contribution->savings_interest = self::SAVINGS_INTEREST;
            }
            $contribution->amount = $amount;

            return $this->modelSave($contribution, true);
        } else {
            foreach (
            $contributions = $this->splitContributionIntoVariousPaymentTypes($person, $date, $receiptNo, $loansMemberIsServicing)
            as $c => $contribution
            ) {
                if (!isset($save))
                    $save = true;

                $save = $save && $this->modelSave($contribution, true);
            }

            return $save;
        }
    }

    /**
     * Compute total contributions by a member for a particular contribution type by end of this date.
     * 
     * @param type $member
     * @param type $contribution_type
     * @param date $endDate
     * @return double
     */
    public function totalMemberContribution($member, $contribution_type, $endDate) {
        $contributions = ContributionsByMembers::model()->findAll('member=:mbr && contribution_type=:ctbtn && date<=:dt', array(':mbr' => $member, ':ctbtn' => $contribution_type, ':dt' => $endDate));

        return $this->computeTotals($contributions);
    }

    /**
     * Compute total contributions by a member for a particular contribution type by end of this date.
     * 
     * @param type $member
     * @param type $contribution_type
     * @param date $startDate
     * @param date $endDate
     * @return \ContributionsByMembers models
     */
    public function totalMemberContributionBtwnDates($member, $contribution_type, $startDate, $endDate) {
        $cri = new CDbCriteria;
        $cri->condition = 'member=:mbr && contribution_type=:ctbtn && date>=:dt && date<=:dt1';
        $cri->params = array(':mbr' => $member, ':ctbtn' => $contribution_type, ':dt' => $startDate, ':dt1' => $endDate);
        $cri->order = 'date ASC, receiptno ASC, id ASC';

        return ContributionsByMembers::model()->findAll($cri);
    }

    /**
     * order receipt number according to day, ascending
     * 
     * @param \ContributionsByMembers $contributions models
     * @param date $minDate
     * @param date $maxDate
     * @return \ContributionsByMembers models
     */
    public function orderReceiptNumbers($contributions, $minDate, $maxDate) {

        $newContributions = array();

        while ($minDate <= $maxDate) {
            $dayContributions = array();
            foreach ($contributions as $c => $contribution)
                if ($contribution->date == $minDate) {
                    $dayContributions[count($dayContributions)] = $contribution;
                    unset($contributions[$c]);
                }

            if (!empty($dayContributions))
                foreach ($dayContributions = $this->orderDayReceipts($dayContributions) as $d => $dayContribution) {
                    $newContributions[count($newContributions)] = $dayContribution;
                    unset($dayContributions[$d]);
                }

            $minDate = LoanApplications::model()->dayAfter($minDate);
        }

        return $newContributions;
    }

    /**
     * order daily receiptnos in ascending order
     * 
     * @param \ContributionsByMembers $dayContributions models
     * @return \ContributionsByMembers models
     */
    public function orderDayReceipts($dayContributions) {
        $minReceipt = 99999999;
        $maxReceipt = 0;
        $newDayContributions = array();

        foreach ($dayContributions as $dayContribution) {
            $receiptNo = empty($dayContribution->receiptno_again) ? $dayContribution->receiptno : $dayContribution->receiptno_again;
            $minReceipt = $receiptNo < $minReceipt ? $receiptNo : $minReceipt;
            $maxReceipt = $receiptNo > $maxReceipt ? $receiptNo : $maxReceipt;
        }

        while ($minReceipt <= $maxReceipt) {
            foreach ($dayContributions as $d => $dayContribution) {
                $receiptNo = empty($dayContribution->receiptno_again) ? $dayContribution->receiptno : $dayContribution->receiptno_again;

                if ($receiptNo == $minReceipt) {
                    $newDayContributions[count($newDayContributions)] = $dayContribution;
                    unset($dayContributions[$d]);
                }
            }

            $minReceipt++;
        }

        return $newDayContributions;
    }

    /**
     * 
     * @param \ContributionsByMembers $contributions models
     * @return double
     */
    public function computeTotals($contributions) {
        $total = 0;
        foreach ($contributions as $contribution)
            $total = $total + $contribution->amount;

        return empty($total) ? null : $total;
    }

    /**
     * Return member's total contributions less loan balances and recoveries after this date.
     * 
     * @param int $member
     * @param date $endDate
     * @return double
     */
    public function netTotalMemberContribution($member, $endDate) {
        $totalContributions = $this->totalMemberContribution($member, 2, $endDate);
        $totalLoans = LoanApplications::model()->totalLoanBalances($member, $endDate);
        $totalLoanRecoveries = LoanRepayments::model()->totalLoanRecoveries($member, $endDate);

        if (empty($totalContributions))
            return null;

        return $totalContributions - $totalLoans - $totalLoanRecoveries;
    }

    /**
     * 
     * @param \ContributionsByMembers $contributions models
     * @param \LoanRepayments $loanRecoveries models
     * @return double
     */
    public function membersContributionsBtwnDates($contributions, $loanRecoveries) {
        return $this->computeTotals($contributions) - LoanRepayments::model()->totalRecoveries($loanRecoveries);
    }

    /**
     * Return a split piece of the receipted amount
     * e.g. a receipted value may have paid for a loan
     * and its exceeding value convert as monthly contribution.
     * 
     * @param \ContributionsByMembers $contribution
     * @return \ContributionsByMembers $splitPiece
     */
    public function findTheSplitContribution($contribution) {
        $splitPiece = $this->modelToSave($contribution->receiptno, 2, null);

        if (empty($splitPiece)) {
            $splitPiece = new ContributionsByMembers;
            $splitPiece->attributes = $contribution->attributes;
            $splitPiece->amount = 0;
            $splitPiece->contribution_type = 2;
            $splitPiece->receiptno_again = $splitPiece->receiptno;
        }

        return $splitPiece;
    }

    /**
     * 
     * @param int $member person id
     * @param int $type contribution type id
     * @return boolean member has a contribution
     */
    public function memberHasAContribution($member, $type) {
        $contribution = $this->find('member=:mbr && contribution_type=:type', array(':mbr' => $member, ':type' => $type));
        return !empty($contribution);
    }

    /**
     * Return a required contribution
     * 
     * @param type $pk
     * @return \ContributionsByMembers
     */
    public function returnAContribution($pk) {
        return ContributionsByMembers::model()->findByPk($pk);
    }

    /**
     * 
     * @param int $member person id
     * @param int $contributionType contribution type id
     * @param date $date
     * @param string $receiptNo receipt no
     * @return \ContributionsByMembers model
     */
    public function theJustPrecedingContribution($member, $contributionType, $date, $receiptNo) {
        $cri = new CDbCriteria;
        $cri->condition = 'member=:mbr && contribution_type=:type && receiptno<:rcpt && date<=:dt';
        $cri->params = array(':mbr' => $member, ':type' => $contributionType, ':rcpt' => $receiptNo, ':dt' => $date);
        $cri->order = 'date DESC, receiptno DESC, id DESC';

        foreach ($this->findAll($cri) as $contribution)
            return $contribution;
    }
    
    /**
     * 
     * @param int $member member id
     * @param date $startDate yyyy/mm/dd
     * @param date $endDate yyyy/mm/dd
     * @return \ContributionsByMembers models
     */
    public function allContributionsByMemberBtwnDates($member, $startDate, $endDate) {
        $cri = new CDbCriteria;
        $cri->condition = 'member=:mbr && date>=:dt1 && date<=:dt2';
        $cri->params = array(':mbr' => $member, ':dt1' => $startDate, ':dt2' => $endDate);
        $cri->order = 'date ASC, receiptno ASC';
        
        return $this->findAll($cri);
    }
    
    /**
     * 
     * @param int $member member id
     * @param date $endDate yyyy/mm/dd
     * @return \ContributionsByMembers models
     */
    public function allContributionsByMemberByThisDate($member, $endDate) {
        $cri = new CDbCriteria;
        $cri->condition = 'member=:mbr && date<=:dt2';
        $cri->params = array(':mbr' => $member, ':dt2' => $endDate);
        $cri->order = 'date ASC, receiptno ASC';
        
        return $this->findAll($cri);
        
    }

}
