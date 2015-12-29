/**
 * Customization and initialization of highcharts
 * @author Fred <mconyango@gmail.com>
 *
 */
var MyHighChart = {
        chartContent: null,
        highchart: null,
        data: null,
        defaults: {
                credits: {enabled: false},
                exporting: {
                        enabled: true,
                        buttons: {
                                contextButton: {
                                        enabled: true
                                }
                        }
                }
        }
        ,
        create: function() {
                new Highcharts.Chart(this.highchart);
        }
        ,
        init: function(options) {
                'use strict';
                var defaults = {
                        highchart: {
                                container_id: 'my_high_chart_1',
                                data: {},
                                highchart_options: {}
                        },
                        filter: {
                                show_filter: true,
                                filter_form_id: 'my_high_chart_1_form',
                                date_range_filter_id: 'my_high_chart_1_d_r',
                                graph_type_filter_id: 'my_high_chart_1_g_t',
                                date_range_from: null,
                                date_range_to: null
                        }

                };
                this.new_options = jQuery.extend({}, defaults, options || {});

                if (this.new_options.filter.show_filter) {
                        this.set_graph_filter(this.new_options.filter);
                }

                this.show_chart(this.new_options.highchart.data);

        },
        show_chart: function(data) {
                'use strict';
                //blue,dark blue,light green,red
                var colors = ['#2f7ed8', '#0d233a', '#8bbc21', '#910000', '#1aadce', '#492970', '#f28f43', '#77a1e5', '#c42525', '#a6c96a'];
                this.chartContent = this.new_options.highchart.container_id;
                this.data = data;

                var settings;
                if (this.data.graph_type !== 'pie') {
                        this.set_graph_options();
                        settings = jQuery.extend({}, this.graph_options, this.new_options.highchart.highchart_options || {});
                }
                else {
                        this.set_pie_options();
                        settings = jQuery.extend({}, this.pie_options, this.new_options.highchart.highchart_options || {});
                }

                this.highchart = jQuery.extend({}, this.defaults, settings);
                this.highchart.chart.renderTo = this.chartContent;

                if (!MyUtils.empty(this.data.colors)) {
                        colors = this.data.colors;
                }
                Highcharts.setOptions({
                        colors: colors,
                });
                this.create();
        }
        ,
        new_options: {}
        ,
        graph_options: {}
        ,
        set_graph_options: function() {
                var data = this.data;
                this.graph_options = {
                        chart: {
                                type: data.graph_type,
                        },
                        title: {text: data.title},
                        subtitle: {text: data.subtitle},
                        xAxis: {
                                categories: data.x_labels,
                                labels: {
                                        rotation: -45,
                                        align: 'right',
                                        style: {
                                                fontSize: '10px',
                                        },
                                        step: data.step
                                }
                        },
                        yAxis: {
                                title: {text: data.y_axis_title, style: {fontWeight: 'normal'}},
                                min: 0,
                                allowDecimals: false,
                                minRange: 10,
                        }, tooltip: {
                                crosshairs: true,
                                shared: true
                        },
                        series: data.series
                }

        }
        ,
        pie_options: {}
        ,
        set_pie_options: function() {
                var data = this.data;
                this.pie_options = {
                        chart: {
                                plotBackgroundColor: null,
                                plotBorderWidth: null,
                                plotShadow: false
                        },
                        title: {text: data.title},
                        subtitle: {text: data.subtitle}, tooltip: {
                                pointFormat: '{point.y} {series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                                pie: {
                                        allowPointSelect: true,
                                        cursor: 'pointer',
                                        showInLegend: true,
                                        dataLabels: {
                                                enabled: true,
                                                color: '#000000',
                                                connectorColor: '#000000',
                                                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                                        }
                                }
                        },
                        series: data.series
                }
        }
        ,
        set_graph_filter: function(options) {
                'use strict';
                var date_range_selector = '#' + options.date_range_filter_id;
                //set date range picker
                $(date_range_selector).daterangepicker(
                        {
                                ranges: {
                                        'Today': [moment(), moment()],
                                        'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                                        'Last 7 Days': [moment().subtract('days', 6), moment()],
                                        'Last 30 Days': [moment().subtract('days', 29), moment()],
                                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                                        'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                                },
                                startDate: options.date_range_from,
                                endDate: options.date_range_to,
                                format: 'MMM D, YYYY',
                        },
                        function(start, end) {
                                var date = start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY');
                                $(date_range_selector + ' span').html(date);
                                $(date_range_selector).find('input[type="hidden"]').val(date);
                                MyHighChart.reload_graph();
                        }
                );

                //graph_type events
                $('#' + options.graph_type_filter_id).on('change', function() {
                        MyHighChart.reload_graph();
                });
        },
        reload_graph: function()
        {
                'use strict';
                var form = $('#' + this.new_options.filter.filter_form_id)
                        , url = form.attr('action')
                        , data = form.serialize();

                $.ajax({
                        type: 'get',
                        url: url,
                        data: data,
                        dataType: 'json',
                        success: function(response) {
                                MyHighChart.show_chart(response);
                        },
                        beforeSend: function() {
                                MyUtils.startBlockUI('Please wait...');
                        },
                        complete: function() {
                                MyUtils.stopBlockUI();
                        },
                        error: function(XHR) {
                                var message = XHR.responseText;
                                MyUtils.showAlertMessage(message, 'error');
                        }
                });
        }
};