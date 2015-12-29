/**
 * Ajax search for cgridview search
 * @type type
 */
var ExtAjaxSearch = {
        options: {
                form_id: undefined,
                grid_id: undefined,
                grid_type: 'cgridview',
                search_trigger: 'keypress',
        },
        init: function(options) {
                'use strict';
                var settings
                        , searchForm;

                settings = $.extend({}, ExtAjaxSearch.options, options || {});
                searchForm = $('#' + settings.form_id);

                //key press trigger
                if (settings.search_trigger === 'keypress') {
                        searchForm.delayed('keyup', 500, function() {
                                $(this).trigger('submit');
                                return false;
                        });
                }
                //blur trigger
                if (settings.search_trigger === 'blur') {
                        searchForm.find('input[type="text"]').on('blur', function() {
                                searchForm.trigger('submit');
                        });
                }

                if (settings.grid_type === 'cgridview') {
                        searchForm.submit(function() {
                                $.fn.yiiGridView.update(settings.grid_id, {
                                        data: $(this).serialize()
                                });
                                return false;
                        });
                }
                else {
                        searchForm.submit(function() {
                                $.fn.yiiListView.update(settings.grid_id, {
                                        data: $(this).serialize()
                                });
                                return false;
                        });
                }

        }
}

