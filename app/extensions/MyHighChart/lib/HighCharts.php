<?php

/**
 * Highchart reports library
 * See {@link http://www.highcharts.com/}
 * @author Fred <mconyango@gmail.com>
 */
class HighCharts {

        /**
         * The graph types e.g spline,column,pie
         * @var type
         */
        public static $graphType;

        /**
         * date range
         * @var type
         */
        public static $dateRange;

        /**
         * If the date range is 90days (~3 months) or less then show x labels in days
         * @var type
         */
        public static $max_x_interval_day = 90;

        /**
         * If the date range is greater than 60days(~2 months) or less than or equal to 366days (~1 year) show x labels in months
         * @var type
         */
        public static $max_x_interval_month = 366;

        //x interval constants

        const X_INTERVAL_DAY = 'day';
        const X_INTERVAL_MONTH = 'month';
        const X_INTERVAL_YEAR = 'year';
        //define get params
        const GET_PARAM_GRAPH_TYPE = 'g_t';
        const GET_PARAM_DATE_RANGE = 'd_r';
        const GET_PARAM_HIGHCHART_FLAG = 'ajax_highchart_request';
        //graph types
        const GRAPH_PIE = 'pie';
        const GRAPH_LINE = 'line';
        const GRAPH_SPLINE = 'spline';
        const GRAPH_COLUMN = 'column';
        const GRAPH_AREA = 'area';
        const GRAPH_AREASPLINE = 'areaspline';

        public static function init()
        {
                self::setDateRange();
                self::setGraphType();
        }

        /**
         * get all the graph types
         * @return type
         */
        public static function graphTypes()
        {
                return array(
                    self::GRAPH_PIE => Lang::t('Pie'),
                    self::GRAPH_LINE => Lang::t('Line'),
                    self::GRAPH_SPLINE => Lang::t('Smooth Line'),
                    self::GRAPH_COLUMN => Lang::t('Bar/Column'),
                    self::GRAPH_AREA => Lang::t('Area'),
                    self::GRAPH_AREASPLINE => Lang::t('Smooth Area'),
                );
        }

        /**
         *
         * @param type $format
         * @return string
         */
        public static function defaultDateRange($format = 'M d, Y')
        {
                $from = Common::addDate(date('Y-m-d'), -1, 'month', $format);
                $to = date($format, time());
                $date_range = $from . ' - ' . $to;
                return $date_range;
        }

        /**
         * Set Date Range
         */
        public static function setDateRange()
        {
                if (isset($_GET[self::GET_PARAM_DATE_RANGE]))
                        self::$dateRange = $_GET[self::GET_PARAM_DATE_RANGE];
                if (empty(self::$dateRange))
                        self::$dateRange = self::defaultDateRange();
        }

        /**
         * Get date range string
         * @return type
         */
        public static function getDateRange()
        {
                return self::$dateRange;
        }

        /**
         * Set graph type
         * @param type $value
         */
        public static function setGraphType($value = NULL)
        {
                if (isset($_GET[self::GET_PARAM_GRAPH_TYPE]))
                        self::$graphType = $_GET[self::GET_PARAM_GRAPH_TYPE];
                else if (!empty($value))
                        self::$graphType = $value;
                else
                        self::$graphType = self::GRAPH_PIE;
                $graph_type = self::graphTypes();
                if (!array_key_exists(self::$graphType, $graph_type))
                        self::$graphType = array_shift(array_keys($graph_type));
        }

        public static function getGraphType()
        {
                return self::$graphType;
        }

        /**
         *  Format daterange into from and to array values
         * @param type $format
         * @return type
         */
        public static function explodeDateRange($format = 'Y-m-d')
        {
                $date_range = explode('-', self::$dateRange);
                $from = Common::formatDate(trim($date_range[0]), $format);
                $to = isset($date_range[1]) ? Common::formatDate(trim($date_range[1]), $format) : NULL;
                return array(
                    'from' => trim($from),
                    'to' => trim($to),
                );
        }

        /**
         * Generate xvalues
         * @param type $max_label
         * @return array
         */
        public static function getXAxisParams($max_label = NULL)
        {
                $max_label = (int) $max_label;
                if (empty($max_label))
                        $max_label = 12;
                $result = array();
                $date_range = self::explodeDateRange();
                $from = $date_range['from'];
                $to = $date_range['to'];
                $date_interval = Common::getDateDiff($from, $to);
                $days_interval = $date_interval->days;

                if ($days_interval <= self::$max_x_interval_day) {
                        $x_interval = (int) round($days_interval / $max_label);
                        $x_dates = Common::generateDateSpan($from, $to, 1, 'day');
                        $result['type'] = self::X_INTERVAL_DAY;
                        $result['dates'] = self::getXAxisDates($x_dates, 'M j, Y');
                        $result['step'] = $x_interval;
                } else if ($days_interval > self::$max_x_interval_day && $days_interval <= self::$max_x_interval_month) {
                        //assume each month is 30days
                        $x_interval = (int) round(($days_interval / 30) / $max_label);
                        $x_dates = Common::generateDateSpan($from, $to, $x_interval, 'month');
                        $result['type'] = self::X_INTERVAL_MONTH;
                        $result['dates'] = self::getXAxisDates($x_dates, 'M Y');
                        $result['step'] = 1;
                } else {
                        //assume each year is 365days
                        $x_interval = (int) round(($days_interval / 365) / $max_label);
                        $x_dates = Common::generateDateSpan($from, $to, $x_interval, 'year');
                        $result['type'] = self::X_INTERVAL_YEAR;
                        $result['dates'] = self::getXAxisDates($x_dates, 'Y');
                        $result['step'] = 1;
                }
                $result['graph_type'] = self::$graphType;

                return $result;
        }

        private static function getXAxisDates($date_range_dates, $format)
        {
                $previous_formated = array();
                $x_axis_dates = array();
                foreach ($date_range_dates as $date) {
                        $formated = Common::formatDate($date, $format);
                        if (!in_array($formated, $previous_formated)) {
                                array_push($x_axis_dates, array(
                                    'date' => $date,
                                    'label' => $formated,
                                ));
                        }

                        $previous_formated[] = $formated;
                }
                return $x_axis_dates;
        }

}
