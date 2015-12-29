<?php

Yii::import('zii.widgets.CListView');

/**
 * Extends CListView
 * @author Fred <mconyango@gmail.com>
 */
class ListView extends CListView {

        public $itemsHtmlOptions = array();

        /**
         * Search info template
         * @var type
         */
        public $search_info_template = '<div class="uk-article"><h4 class="uk-article-title">{search_term} <small>{count} Results</small></h4></div><hr class="uk-article-divider">';

        const SEARCH_GET_KEY = 'q';

        public $beforeAjaxUpdate = 'js:function(id) {MyUtils.startBlockUI("Loading...");}';
        public $afterAjaxUpdate = 'js:function(id) {MyUtils.stopBlockUI();}';
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
        public $sorterCssClass = 'uk-subnav uk-subnav-pill my_sort_container';
        public $loadingCssClass = FALSE;
        public $pagerCssClass = 'pagination-container';

        public function init()
        {
                parent::init();
                $this->updateSelector = $this->updateSelector . ', #' . $this->id . ' .' . preg_replace('/\s+/', '.', $this->pagerCssClass) . ' a, .' . preg_replace('/\s+/', '.', $this->sorterCssClass) . ' a';
        }

        public function run()
        {
                $this->registerClientScript();
                echo CHtml::openTag($this->tagName, $this->htmlOptions) . "\n";
                $this->renderSearchInfo();
                $this->renderContent();
                $this->renderKeys();
                echo CHtml::closeTag($this->tagName);
        }

        /**
         * Renders the data item list.
         */
        public function renderItems()
        {
                if (!isset($this->itemsHtmlOptions['class']))
                        $this->itemsHtmlOptions['class'] = $this->itemsCssClass;
                echo CHtml::openTag($this->itemsTagName, $this->itemsHtmlOptions) . "\n";
                $data = $this->dataProvider->getData();
                if (($n = count($data)) > 0) {
                        $owner = $this->getOwner();
                        $viewFile = $owner->getViewFile($this->itemView);
                        $j = 0;
                        foreach ($data as $i => $item) {
                                $data = $this->viewData;
                                $data['index'] = $i;
                                $data['data'] = $item;
                                $data['widget'] = $this;
                                $owner->renderFile($viewFile, $data);
                                if ($j++ < $n - 1)
                                        echo $this->separator;
                        }
                }
                else
                        $this->renderEmptyText();
                echo CHtml::closeTag($this->itemsTagName);
        }

        /**
         * Renders the sorter.
         */
        public function renderSorter()
        {
                if ($this->dataProvider->getItemCount() <= 0 || !$this->enableSorting || empty($this->sortableAttributes))
                        return;
                echo CHtml::openTag('ul', array('class' => $this->sorterCssClass)) . "\n";
                $sort = $this->dataProvider->getSort();
                foreach ($this->sortableAttributes as $name => $label) {
                        echo "<li>";
                        if (is_integer($name))
                                echo $sort->link($label);
                        else
                                echo $sort->link($name, $label);
                        echo "</li>\n";
                }
                echo CHtml::closeTag('ul');
        }

        /**
         * Renders the empty message when there is no data.
         */
        public function renderEmptyText()
        {
                //$emptyText = $this->emptyText === null ? Yii::t('zii', 'No results found.') : $this->emptyText;
                //echo CHtml::tag($this->emptyTagName, array('class' => 'empty'), $emptyText);
        }

        public function renderSearchInfo()
        {
                if (!isset($_GET[self::SEARCH_GET_KEY]))
                        return FALSE;
                $text = CHtml::encode($_GET[self::SEARCH_GET_KEY]);
                $search_info = Common::myStringReplace($this->search_info_template, array(
                            '{search_term}' => $text,
                            '{count}' => number_format($this->dataProvider->getTotalItemCount()),
                ));

                echo $search_info;
        }

}

