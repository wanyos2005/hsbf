<?php

/**
 * All models implementing hicharts should have the following methods
 */
interface IMyHighCharts {

        /**
         *
         * Applies for X,Y axis based graphs:
         * <pre>
         *      array(
         *                  array(
         *                              "name"=>"Males",
         *                              "condition"=>"`gender`=:gender",
         *                              "params"=>array(":gender"=>"male"))),
         *                  array(
         *                              "name"=>"Females",
         *                              "condition"=>"`gender`=:gender",
         *                              "params"=>array(":gender"=>"female")))
         *           )
         * </pre>
         * @return array series.
         */
        public function getHighChartGraphSeries();

        /**
         * Series for PIE CHART
         * <pre>
         *  array(
         *          array(
         *                 'data' => array(
         *                   array(
         *                     'name' =>"Males",
         *                      'condition' => '`gender`=:gender',
         *                      'params' => array(':gender' =>"Male"),
         *                   ),
         *                 array(
         *                      'name' => "Females",
         *                      'condition' => '`gender`=:gender',
         *                      'params' => array(':gender' =>"Females"),
         *              ),
         *      )
         *   )
         * );
         * </pre>
         * Return Type Example
         * @return array $series
         */
        public function getHighChartPieSeries();
}
