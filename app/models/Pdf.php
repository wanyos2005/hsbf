<?php

/**
 * For doing pdfs
 */
class Pdf extends CActiveRecord {
    
    /**
     * paper orientations
     */
    const PORTRAIT = 'P';
    const LANDSCAPE = 'L';
    
    /**
     * page size
     */
    const A4 = 'A4';
    
    /**
     * various form headings
     * ensure it has a sub heading
     */
    const MEMBERSHIP_HEADING = 'Membership application & agreement form';
    const LOAN_APPLICATION_HEADING = 'Loan application & agreement form';
    const CASH_WITHDRAWAL_HEADING = 'HSBF SAVINGS ACCOUNT';
    const MONTHLY_CONTRIBUTIONS_HEADING = 'STATEMENT OF ACCOUNT';
    const SAVINGS_HEADING = self::MONTHLY_CONTRIBUTIONS_HEADING;
    const LOAN_REPAYMENT_HEADING = self::MONTHLY_CONTRIBUTIONS_HEADING;
    const RECEIPT_HEADING = 'Receipt Acknowledgement';
    const JOURNAL_HEADING = 'Payment Journal';
    const CASHBOOK_HEADING = 'CashBook';
    const BALANCE_SHEET_HEADING = 'Balance Sheet';
    const LEDGER_BOOK_HEADING = 'Ledger Book';
    const TRIAL_BALANCE_HEADING = 'Trial Balance';
    
    /**
     * respective subheadings
     * ensure it has a heading
     */
    const MEMBERSHIP_SUBHEADING = '(to be filled in duplicate)';
    const LOAN_APPLICATION_SUBHEADING = NULL;
    const CASH_WITHDRAWAL_SUBHEADING = 'Withdrawal form';
    const MONTHLY_CONTRIBUTIONS_SUBHEADING = 'Monthly Contributions';
    const SAVINGS_SUBHEADING = 'Savings Account';
    const LOAN_REPAYMENT_SUBHEADING = 'Loan Repayment Schedule';
    const EXPENDITURE_JOURNAL_SUBHEADING = 'Expenditure';
    const INCOME_JOURNAL_SUBHEADING = 'Income';

    /**
     * 
     * @param string $className class name
     * @return \Pdf model
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 
     * @param string $orientation P / L
     * @param string $size paper size
     * @param string $title document title
     * @return \TCPDF model
     */
    public function initializePdf($orientation, $size, $title) {
        Yii::createComponent('ext.tcpdf.TcPdf', 'P', 'cm', 'A4', true, 'UTF-8');
        spl_autoload_unregister(array('YiiBase', 'autoload'));

        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        spl_autoload_register(array('YiiBase', 'autoload'));

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle($title);

        //no headers and footers
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        
        //automatically insert page break bottom
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->addPage($orientation, $size);

        return $pdf;
    }

    /**
     * 
     * @param string $view view file name
     * @param array $array variables for view
     * @return page html page
     */
    public function htmlView($view, $array) {
        //Write the html from a Yii view
        return Yii::app()->controller->renderPartial($view, $array, true, false);
    }

    /**
     * 
     * @param \TCPDF $pdf model
     * @param page $html html page
     * @param string $name pdf file name
     */
    public function writePdf($pdf, $html, $name) {
        //Convert the Html to a pdf document
        $pdf->writeHTML($html, true, true, true, true, '');
        // reset pointer to the last page
        $pdf->lastPage();
        //Close and output PDF document
        $pdf->Output("$name.pdf", 'I');
    }

    /**
     * 
     * @param string $orientation P / L
     * @param string $size paper size
     * @param string $title page title
     * @param string $view view file name
     * @param array $array variable for view
     * @param string $name pdf file name
     */
    public function executePdf($orientation, $size, $title, $view, $array, $name) {
        $this->writePdf(
                $this->initializePdf(
                        $orientation, $size, $title
                ), $this->htmlView(
                        $view, $array
                ), $name
        );
    }

}
