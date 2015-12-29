<?php

Yii::import('ext.MyHighChart.lib.*');

/**
 *
 */
abstract class HighChartActiveRecord extends ActiveRecord implements IMyHighCharts {

        /**
         * SQL query options
         * @var type
         */
        public $highchart_sql_query_options = array(
            'filters' => array(), //Any $key=>$value table filters where $key is a column name and $value is the columns value. This will lead to a series of AND conditions
            'condition' => '', //Any condition that must be passed to all querys. This value is only necessary when passing other conditions which are not "AND". for conditions with "AND" use table_filters instead. e.g  "(`org_id`='3' OR `org_id`='6')",
            'date_field' => 'date_created',
            'sum' => false, //If this value is FALSE then COUNT(*) will be applied. If you want to get the SUM(`colum_name`) then pass the column_name e.g "sum"=>"column_name"
        );

        /**
         * Options for the display of the graph
         * @var type
         */
        public $highchart_graph_options = array(
            'graph_type' => null,
            'title' => 'Report',
            'subtitle' => NULL,
            'y_axis_label' => NULL,
            'default_series_name' => NULL, //this will be used as piechart series name
        );

        /**
         * The hicharts series
         * {@link  http://api.highcharts.com/highcharts#series}
         * @var type
         */
        private $highchart_series = array();

        /**
         * @see {HighCharts::getXAxisParams()}
         * @var type
         */
        private $highchart_x_axis_params = array();

        /**
         *
         * @var type
         */
        protected $highchart_graph_type;

        /**
         * Get x,y axis graph data
         * @return type
         */
        protected function getHighChartGraphData()
        {
                $sum = $this->highchart_sql_query_options['sum'];
                $dates = $this->highchart_x_axis_params['dates'];
                $from = current($dates);
                $to = end($dates);
                $x_labels = array();
                $type = $this->highchart_x_axis_params['type'];
                $query = $this->prepareHighChartQuery($from['date'], $to['date']);
                $base_condition = $query['condition'];
                $base_params = $query['params'];
                $series = !empty($this->highchart_series) ? $this->highchart_series : array();
                $date_field = $this->highchart_sql_query_options['date_field'];

                foreach ($dates as $date) {
                        $x_labels[] = $date['label'];
                        $condition = !empty($base_condition) ? $base_condition . ' AND ' : $base_condition;
                        $params = $base_params;
                        if ($type === HighCharts::X_INTERVAL_DAY) {
                                $condition .= "(DATE(`{$date_field}`)=DATE(:{$date_field}))";
                        } else if ($type === HighCharts::X_INTERVAL_MONTH) {
                                $condition .= "(MONTH(`{$date_field}`)=MONTH(:{$date_field}) AND YEAR(`{$date_field}`)=YEAR(:{$date_field}))";
                        } else {
                                $condition .= "(YEAR(`{$date_field}`)=YEAR(:{$date_field}))";
                        }
                        $params[":{$date_field}"] = $date['date'];

                        foreach ($series as $k => $element) {
                                $final_condition = !empty($element['condition']) ? $element['condition'] . ' AND ' . $condition : $condition;
                                $final_params = !empty($element['params']) ? array_merge($element['params'], $params) : $params;
                                $data = $sum ? $this->getSum($sum, $final_condition, $final_params) : $this->getTotals($final_condition, $final_params);
                                $series[$k]['data'][] = (int) $data;
                        }
                }

                $series_colors = array();
                $new_series = array();
                foreach ($series as $k => $element) {
                        $element['type'] = $this->highchart_graph_type;
                        if (isset($element['condition']))
                                unset($element['condition']);
                        if (isset($element['params']))
                                unset($element['params']);
                        if (isset($element['color'])) {
                                $series_colors[] = $element['color'];
                                unset($element['color']);
                        }
                        array_push($new_series, $element);
                }

                return array(
                    'graph_type' => $this->highchart_graph_type,
                    'series' => $new_series,
                    'x_labels' => $x_labels,
                    'subtitle' => !empty($this->highchart_graph_options['subtitle']) ? $this->highchart_graph_options['subtitle'] : HighCharts::getDateRange(),
                    'y_axis_title' => $this->highchart_graph_options['y_axis_label'],
                    'step' => $this->highchart_x_axis_params['step'],
                    'title' => $this->highchart_graph_options['title'],
                    'colors' => $series_colors,
                );
        }

        /**
         * Get Pie chart data (non x,y axis)
         */
        public function getHighChartPieData()
        {
                $sum = $this->highchart_sql_query_options['sum'];
                $date_range = HighCharts::explodeDateRange();
                $query = $this->prepareHighChartQuery($date_range['from'], $date_range['to']);
                $base_condition = $query['condition'];
                $base_params = $query['params'];
                $series = $this->highchart_series;
                $series_colors = array();
                $data = isset($series[0]['data']) ? $series[0]['data'] : array();
                $series[0]['type'] = $this->highchart_graph_type;
                $chart_title = $this->highchart_graph_options['title'];
                $series[0]['name'] = !empty($this->highchart_graph_options['default_series_name']) ? $this->highchart_graph_options['default_series_name'] : $chart_title;

                foreach ($data as $k => $element) {
                        $condition = !empty($element['condition']) ? $element['condition'] . ' AND ' . $base_condition : $base_condition;
                        $params = !empty($element['params']) ? array_merge($element['params'], $base_params) : $base_params;
                        $data = $sum ? $this->getSum($sum, $condition, $params) : $this->getTotals($condition, $params);
                        $series[0]['data'][$k]['y'] = (int) $data;
                        if (isset($series[0]['data'][$k]['condition']))
                                unset($series[0]['data'][$k]['condition']);
                        if (isset($series[0]['data'][$k]['params']))
                                unset($series[0]['data'][$k]['params']);
                        if (isset($series[0]['data'][$k]['color'])) {
                                $series_colors[] = $series[0]['data'][$k]['color'];
                                unset($series[0]['data'][$k]['color']);
                        }
                }

                return array(
                    'graph_type' => $this->highchart_graph_type,
                    'series' => $series,
                    'subtitle' => !empty($this->highchart_graph_options['subtitle']) ? $this->highchart_graph_options['subtitle'] : HighCharts::getDateRange(),
                    'title' => $chart_title,
                    'colors' => $series_colors,
                );
        }

        /**
         * pepare a hichart data query
         * @param type $from_date
         * @param type $to_date
         * @return type
         */
        protected function prepareHighChartQuery($from_date = null, $to_date = null)
        {
                $params = array();
                //filters
                $condition = $this->highchart_sql_query_options['condition'];
                $table_filters = $this->highchart_sql_query_options['filters'];
                $date_field = $this->highchart_sql_query_options['date_field'];

                foreach ($table_filters as $k => $v) {
                        if (!empty($v) && $this->hasAttribute($k)) {
                                $condition.=!empty($condition) ? ' AND ' : '';
                                $condition .= "(`{$k}`=:{$k})";
                                $params[":{$k}"] = $v;
                        }
                }
                //date boundary
                if (!empty($from_date) && !empty($to_date)) {
                        //make sure that data falls between "from date" and "to date"
                        $condition.=!empty($condition) ? ' AND ' : '';
                        $condition .= "(DATE(`{$date_field}`)>=DATE(:t1_from) AND DATE(`{$date_field}`)<=DATE(:t2_to))";
                        $params[':t1_from'] = $from_date;
                        $params[':t2_to'] = $to_date;
                }
                return array(
                    'condition' => $condition,
                    'params' => $params,
                );
        }

        /**
         * Get graph data e.g line graph,bar graph etc
         * @param array $highchart_sql_query_options {@see HighChartActiveRecord::highchart_sql_query_options}
         * @param array $highchart_graph_options {@see HighChartActiveRecord::highchart_graph_options}
         * @param integer $max_labels Maximum labels of x,y axis graph . Default is 12
         * @return array $data
         */
        public function getHighChartData(array $highchart_sql_query_options = array(), array $highchart_graph_options = array(), $max_labels = 12)
        {
                $data = array();
                $this->setVariables($highchart_sql_query_options, $highchart_graph_options);
                if ($this->highchart_graph_type !== HighCharts::GRAPH_PIE) {
                        //get other graph data(with x and y axis)
                        $this->highchart_x_axis_params = HighCharts::getXAxisParams($max_labels);
                        $data = $this->getHighChartGraphData();
                } else {
                        $data = $this->getHighChartPieData();
                }

                if (isset($_GET[HighCharts::GET_PARAM_HIGHCHART_FLAG])) {
                        echo CJSON::encode($data);
                        Yii::app()->end();
                } else
                        return $data;
        }

        /**
         * Initialize the properties
         * @param array $highchart_sql_query_options
         * @param array $highchart_graph_options
         */
        protected function setVariables(array $highchart_sql_query_options, array $highchart_graph_options)
        {
                if (!empty($highchart_sql_query_options))
                        $this->highchart_sql_query_options = $highchart_sql_query_options;
                if (empty($this->highchart_sql_query_options['sum']))
                        $this->highchart_sql_query_options['sum'] = FALSE;
                if (empty($this->highchart_sql_query_options['date_field']))
                        $this->highchart_sql_query_options['date_field'] = 'date_created';
                if (empty($this->highchart_sql_query_options['condition']))
                        $this->highchart_sql_query_options['condition'] = '';
                if (empty($this->highchart_sql_query_options['filters']) || !is_array($this->highchart_sql_query_options['filters']))
                        $this->highchart_sql_query_options['filters'] = array();

                if (!empty($highchart_graph_options))
                        $this->highchart_graph_options = $highchart_graph_options;
                if (empty($this->highchart_graph_options['title']))
                        $this->highchart_graph_options['title'] = Lang::t('Reports');
                if (empty($this->highchart_graph_options['y_axis_label']))
                        $this->highchart_graph_options['y_axis_label'] = $this->highchart_graph_options['title'];

                HighCharts::init();

                if (!empty($this->highchart_graph_options['graph_type']))
                        HighCharts::setGraphType($this->highchart_graph_options['graph_type']);
                $this->highchart_graph_type = HighCharts::getGraphType();

                if ($this->highchart_graph_type === HighCharts::GRAPH_PIE)
                        $this->highchart_series = $this->getHighChartPieSeries();
                else
                        $this->highchart_series = $this->getHighChartGraphSeries();
        }

        //ensure you override this method. This is just an example
        public function getHighChartGraphSeries()
        {
                return array(
                    array(
                        'name' => $this->highchart_graph_options['title'],
                        'condition' => NULL,
                        'params' => NULL,
                    ),
                );
        }

        //ensure you override this method. This is just an example
        public function getHighChartPieSeries()
        {
                return array(
                    array(
                        'data' => array(
                            array(
                                'name' => 'Variable1',
                                'condition' => NULL,
                                'params' => array(),
                            ),
                            array(
                                'name' => 'Variable2',
                                'condition' => NULL,
                                'params' => array(),
                            )
                        ),
                    )
                );
        }

}
