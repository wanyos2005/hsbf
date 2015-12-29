<?php

Yii::import('zii.widgets.grid.CGridView');

/**
 * Extends CGridView
 * @author Fred <mconyango@gmail.com>
 */
class GridView extends CGridView {

        public $cssFile = false;
        public $pagerCssClass = 'dataTables_paginate paging_bootstrap';
        public $itemsCssClass = 'table table-bordered table-hover dataTable';
        public $enableSorting = true;

        /**
         * New attribute to regulate the display of summary text;
         * @var type
         */
        public $enableSummary = true;

        /**
         * If set then the value will be set as the template
         * @var type
         */
        public $altTemplate;

        /**
         * Max buttons to show in a pagination
         */
        public $pager_max_buttons = 10;

        /**
         *
         * @var type
         */
        public $htmlOptions = array(
            'class' => 'grid-view table-responsive'
        );
        public $pager = array(
            'cssFile' => false,
            'header' => '',
            'hiddenPageCssClass' => 'disabled',
            'firstPageLabel' => '<i class="icon-step-backward middle"></i>',
            'lastPageLabel' => '<i class="icon-step-forward middle"></i>',
            'nextPageLabel' => '<i class="icon-caret-right middle"></i>',
            'prevPageLabel' => '<i class="icon-caret-left middle"></i>',
            'selectedPageCssClass' => 'active',
            'htmlOptions' => array('class' => 'pagination'),
        );
        public $nullDisplay = '________';
        //custom attributes
        public $addRowLink = false;
        public $rowLinkExpression = 'Yii::app()->controller->createUrl("view",array("id"=>$data->id))';
        public $showFooter = true;

        public function init()
        {
                $this->summaryText = Lang::t('summary_text');
                $this->pager['maxButtonCount'] = $this->pager_max_buttons;
                if (empty($this->altTemplate)) {
                        if ($this->showFooter)
                                $this->template = '<div class="grid-view-table-wrapper">{items}</div><div class="row grid-view-footer"><div class="col-lg-5"><div class="dataTables_info text-muted">{summary}</div></div><div class="col-lg-7">{pager}</div></div>';
                        else
                                $this->template = '<div class="grid-view-table-wrapper">{items}</div>';
                } else
                        $this->template = $this->altTemplate;

                if (!$this->enableSummary)
                        $this->summaryText = FALSE;

                if ($this->addRowLink) {
                        $this->rowHtmlOptionsExpression = 'array("class"=>"linked-table-row","data-href"=>' . $this->rowLinkExpression . ')';
                }

                parent::init();
        }

        public function run()
        {
                return parent::run();
        }

}
