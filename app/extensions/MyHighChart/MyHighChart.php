<?php

/**
 * HighCharts widget
 * @uses Twitter Bootrap version 2.1.0
 * @author Fred <mconyango@gmail.com>
 */
class MyHighChart extends CWidget {

        /**
         * Graph data
         * @var type
         */
        public $data = array();

        /**
         * The number of charts in a page
         * @var type
         */
        public $chart_count = 1;

        /**
         * HTML options for the chart container
         * @var type
         */
        public $htmlOptions = array();

        /**
         * Graph container id
         * @var type
         */
        private $container_id;

        /**
         *
         * @var type
         */
        public $chartTemplate = '{filter_form}<hr/>{chart}';

        /**
         *
         * @var type
         */
        public $filterFormTemplate = '<div class="row"><div class="col-md-6">{graph_type}</div><div class="col-md-6">{date_range}</div></div>';

        /**
         *
         * @var type
         */
        public $filterFormHtmlOptions = array();

        /**
         *
         * @var type
         */
        public $graphTypeFilterHtmlOptions = array(
        );

        /**
         *
         * @var type
         */
        public $dateRangeFilterHtmlOptions = array(
            'class' => 'my-date-range-picker pull-right',
        );

        /**
         *
         * @var type
         */
        public $showDateRangeFilter = true;

        /**
         *
         * @var type
         */
        public $showGraphTypeFilter = true;

        /**
         *
         * @var type
         */
        public $highChartOptions = array();

        /**
         *
         * @var type
         */
        private $showFilter = true;

        /**
         *
         * @var type
         */
        private $date_range_from = null;

        /**
         *
         * @var type
         */
        private $date_range_to = null;

        /**
         *
         * @var type
         */
        private $dateRangeFormat = array('php' => 'M d, Y', 'js' => 'MMM D, YYYY');

        /**
         *
         * @var type
         */
        private $chartID;

        public function init()
        {
                parent::init();

                $this->container_id = 'my_high_chart_' . $this->chart_count;
                $this->htmlOptions['id'] = $this->container_id;
                $this->htmlOptions['id'] = $this->container_id;
                $this->chartID = $this->container_id . '_chart';
                $this->filterFormHtmlOptions['id'] = $this->container_id . '_form';
                $this->dateRangeFilterHtmlOptions['id'] = $this->container_id . '_' . HighCharts::GET_PARAM_DATE_RANGE;
                $this->graphTypeFilterHtmlOptions['id'] = $this->container_id . '_' . HighCharts::GET_PARAM_GRAPH_TYPE;
                if ($this->showGraphTypeFilter || $this->showDateRangeFilter)
                        $this->showFilter = TRUE;
                else
                        $this->showFilter = FALSE;
                $date_range = HighCharts::explodeDateRange($this->dateRangeFormat['php']);
                $this->date_range_from = $date_range['from'];
                $this->date_range_to = $date_range['to'];

                $this->registerAssets();
        }

        public function run()
        {
                $graph_type_filter = '';
                $date_range_filter = '';
                $filter_form = '';
                if ($this->showGraphTypeFilter) {
                        $graph_type_filter = CHtml::dropDownList(HighCharts::GET_PARAM_GRAPH_TYPE, HighCharts::getGraphType(), HighCharts::graphTypes(), $this->graphTypeFilterHtmlOptions);
                }
                if ($this->showDateRangeFilter) {
                        $date_range_string = $this->date_range_from . ' - ' . $this->date_range_to;
                        $date_range_filter = CHtml::tag('span', array(), $date_range_string);
                        $date_range_hidden = CHtml::hiddenField(HighCharts::GET_PARAM_DATE_RANGE);
                        $date_range_filter_container = CHtml::tag('div', $this->dateRangeFilterHtmlOptions, $date_range_hidden . '<i class="icon-calendar icon-large"></i>&nbsp;' . $date_range_filter . '&nbsp;<b class = "caret"></b>');
                }
                if ($this->showFilter) {
                        $filter_form .= CHtml::beginForm(Yii::app()->createUrl($this->owner->route, $this->owner->actionParams), 'get', $this->filterFormHtmlOptions);
                        $filter_form .= Common::myStringReplace($this->filterFormTemplate, array(
                                    '{graph_type}' => $graph_type_filter,
                                    '{date_range}' => $date_range_filter_container,
                        ));
                        $filter_form.=CHtml::hiddenField(HighCharts::GET_PARAM_HIGHCHART_FLAG, true);
                        $filter_form.=CHtml::endForm();
                }

                $chart = CHtml::tag('div', array('id' => $this->chartID), '', true);
                $contents = Common::myStringReplace($this->chartTemplate, array(
                            '{filter_form}' => $filter_form,
                            '{chart}' => $chart,
                ));
                echo CHtml::tag('div', $this->htmlOptions, $contents);
        }

        protected function registerAssets()
        {
                $options = CJavaScript::encode(array(
                            'highchart' => array(
                                'container_id' => $this->chartID,
                                'data' => $this->data,
                                'highchart_options' => array(),
                            ),
                            'filter' => array(
                                'container_id' => $this->container_id,
                                'show_filter' => $this->showFilter,
                                'filter_form_id' => $this->filterFormHtmlOptions['id'],
                                'date_range_filter_id' => $this->dateRangeFilterHtmlOptions['id'],
                                'graph_type_filter_id' => $this->graphTypeFilterHtmlOptions['id'],
                                'date_range_from' => $this->date_range_from,
                                'date_range_to' => $this->date_range_to,
                                'date_range_format' => $this->dateRangeFormat['js'],
                            )
                ));
                //register scripts
                $assets = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
                $baseUrl = Yii::app()->assetManager->publish($assets);
                Yii::app()->clientScript
                        ->registerScriptFile($baseUrl . '/js/highcharts.js', CClientScript::POS_END)
                        ->registerScriptFile($baseUrl . '/js/modules/exporting.js', CClientScript::POS_END)
                        ->registerScriptFile($baseUrl . '/bootstrap-daterangepicker/moment.min.js', CClientScript::POS_END)
                        ->registerScriptFile($baseUrl . '/bootstrap-daterangepicker/daterangepicker.min.js', CClientScript::POS_END)
                        ->registerCssFile($baseUrl . '/bootstrap-daterangepicker/daterangepicker-bs3.css')
                        //->registerScriptFile($baseUrl . '/js/themes/grid.js', CClientScript::POS_END)
                        ->registerScriptFile($baseUrl . '/js/custom.js', CClientScript::POS_END)
                        ->registerScript($this->container_id . $this->chart_count, "MyHighChart.init(" . $options . ");", CClientScript::POS_READY);
        }

}
