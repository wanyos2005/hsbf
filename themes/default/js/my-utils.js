/**
 * Contains all functions that are commonly used in the application
 * @author Fred <mconyango@gmail.com>
 * @type object
 */
var $ = jQuery;
var MyUtils = {
        /**
         *reloads a page
         *@param {string} url  The url to reload to
         *@param {integer} delay : the delay in milliseconds e.g 1000,2000 for 1 sec and 2 sec respectively
         */
        reload: function(url, delay) {
                "use strict";
                if (!url || typeof url === 'undefined') {
                        url = location.href;
                }
                if (!delay || typeof delay === 'undefined')
                        window.location = url;
                else {
                        setTimeout(function() {
                                window.location = url;
                        }, delay);
                }
        },
        /**
         * Initialises the colorbox modal
         * @param {string} url : The remote Url to load
         * @param {boolean} reloadOnclean : If set to true the page refreshes after the colorbox is closed
         */
        showColorbox: function(url, reloadOnclean) {
                'use strict';
                if (typeof reloadOnclean === 'undefined')
                        reloadOnclean = true;
                $.colorbox({
                        href: url,
                        overlayClose: false,
                        onCleanup: function() {
                                if (reloadOnclean)
                                        MyUtils.reload();
                        },
                        onComplete: function() {
                                $(this).colorbox.resize();
                        }
                });
                return false;
        },
        /**
         * Trigger submit event on a form
         * @param {string} selector The form selector
         * @returns {Boolean}
         */
        triggerSubmit: function(selector) {
                $(selector).trigger('submit');
                return false;
        },
        /**
         *Pupulates a select options with a given data in JSON format e.g [{id:"1",name:"Sample1"},{id:"2",name:"Sample2"}]
         * @param {string} selecter
         * @param {object} jsonData JSON data
         * @param {string} selected_id
         * @returns {void}
         */
        populateDropDownList: function(selecter, jsonData, selected_id) {
                'use strict';
                var options = '';
                try {
                        jsonData = $.parseJSON(jsonData)
                }
                catch (e) {
                        //console.log(e);
                }
                $.each(jsonData, function(i, item) {
                        if (item.id === null)
                                item.id = "";
                        options += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                $(selecter).html(options);
                if (typeof selected_id !== 'undefined' && !MyUtils.empty(selected_id)) {
                        $(selecter).val(selected_id).change();
                }
        },
        /**
         * Formats a number with grouped thousands~
         * Strip all characters but numerical ones.
         * @param {mixed} number
         * @param {integer} decimals
         * @param {string} dec_point
         * @param {string} thousands_sep
         * @returns {@exp;s@call;join}
         */
        number_format: function(number, decimals, dec_point, thousands_sep) {
                "use strict";
                number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
                var n = !isFinite(+number) ? 0 : +number,
                        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                        s = '',
                        toFixedFix = function(n, prec) {
                                var k = Math.pow(10, prec);
                                return '' + Math.round(n * k) / k;
                        };
                // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                if (s[0].length > 3) {
                        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                }
                if ((s[1] || '').length < prec) {
                        s[1] = s[1] || '';
                        s[1] += new Array(prec - s[1].length + 1).join('0');
                }
                return s.join(dec);
        },
        /**
         *Adds more params to a url
         *@param {string} url The url
         *@param {string} key the $_GET key
         *@param {string} value the $_GET value for the key
         */
        addParameterToURL: function(url, key, value) {
                "use strict";
                var _url = url;
                _url += (_url.split('?')[1] ? '&' : '?') + key + '=' + value;
                return _url;
        },
        /**
         * Starts a block UI
         * @param {string} message
         * @returns {void}
         */
        startBlockUI: function(message) {
                if (typeof message === 'undefined') {
                        message = 'Loading...';
                }
                var content = '<span id="my_block_ui">' + message + '</span>';
                $.blockUI({
                        message: content,
                        css: {
                                border: 'none',
                                padding: '15px',
                                backgroundColor: '#333C44',
                                '-webkit-border-radius': '3px',
                                '-moz-border-radius': '3px',
                                opacity: 1,
                                color: '#fff',
                        },
                        overlayCSS: {
                                backgroundColor: '#000',
                                opacity: 0.4,
                                cursor: 'wait',
                                'z-index': 1030,
                        },
                });
        },
        /**
         * Stops a block ui
         * @returns {undefined}
         */
        stopBlockUI: function() {
                $.unblockUI();
        },
        /**
         * Checks whether a given string is a valid integer
         * @param {string} number
         * @returns {Boolean}
         */
        isInt: function(number) {
                if (Math.floor(number) == number && $.isNumeric(number))
                        return true;
                else
                        return false;
        },
        /**
         *Show alert message.
         * @param {string} message
         * @param {string} type
         * @param {string} containerSelector
         * @returns {void}
         */
        showAlertMessage: function(message, type, containerSelector)
        {
                var validTypes = ['success', 'error', 'notice'], html = '';
                if (typeof type === 'undefined' || (jQuery.inArray(type, validTypes) < 0))
                        type = validTypes[0];
                if (type === 'success') {
                        html += '<div class="alert alert-success alert-block">';
                }
                else if (type === 'error') {
                        html += '<div class="alert alert-danger alert-block">';
                }
                else {
                        html += '<div class="alert alert-warning alert-block">';
                }
                html += '<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>';
                html += '<p>' + message + '</p>';
                html += '</div>';
                if (typeof containerSelector === 'undefined')
                        containerSelector = '#user-flash-messages';
                $(containerSelector).html(html).removeClass('hidden');
        },
        //Grid view operations
        GridView: {
                /**
                 *get selection ids from gridview
                 *@param grid_id : The ID of the CgridView Table
                 *@return selectionIds (e.g 1,2,3)
                 */
                getSelectedIds: function(grid_id) {
                        "use strict";
                        var selectionIds = $.fn.yiiGridView.getSelection(grid_id);
                        if (selectionIds.length === 0 || selectionIds === '') {
                                return false;
                        }
                        return selectionIds;
                },
                /**
                 * delete many records when the gridview items are selected
                 * @param e : element object
                 * @param grid_id : The ID of the CgridView Table
                 * @param confirmMsg : The delete confirmation message
                 */
                deleteMultiple: function(e, confirmMessage) {
                        "use strict";

                        if (typeof confirmMessage === 'undefined')
                                confirmMessage = 'Are you really sure?';
                        var grid_id = $(e).data('grid_id')
                                , selectionIds = MyUtils.GridView.getSelectedIds(grid_id);
                        if (MyUtils.empty(selectionIds))
                                return false;
                        if (!confirm(confirmMessage))
                                return false;
                        var url = $(e).data('ajax-url')
                                , data = 'ids=' + selectionIds;
                        return MyUtils.GridView.submitGridView(grid_id, url, data);
                },
                /**
                 * Submit Gridview operation via AJAX
                 * @param {string} grid_id
                 * @param {string} url
                 * @returns {Boolean}
                 */
                submitGridView: function(grid_id, url, data) {
                        "use strict";
                        $.fn.yiiGridView.update(grid_id, {
                                type: 'POST',
                                url: url,
                                data: data,
                                success: function(data) {
                                        $.fn.yiiGridView.update(grid_id);
                                },
                                error: function(XHR) {
                                        MyUtils.showAlertMessage(XHR.responseText, 'error');
                                }
                        });
                        return false;
                },
                /**
                 * Passes the selected values to a colorbox
                 * @param elem : The element object
                 * @param grid_id : The ID of the CgridView Table
                 */
                gridViewColorBoxInit: function(e) {
                        "use strict";
                        var grid_id = $(e).attr('data-grid_id')
                                , ids = MyUtils.GridView.getSelectedIds(grid_id);
                        if (!ids)
                                return false;
                        var href = MyUtils.addParameterToURL($(e).attr('href'), 'ids', ids);
                        MyUtils.showColorbox(href);
                        return false;
                }
        },
        bootstrapDatePicker: function(e) {
                'use strict';
                var nowTemp = new Date();
                var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
                $(e).datepicker({
                        format: 'yyyy-mm-dd',
                        onRender: function(date) {
                                if ($(e).data('date-disabled') === 'past') {
                                        return date.valueOf() < now.valueOf() ? 'disabled' : '';
                                }
                                else if ($(e).data('date-disabled') === 'future') {
                                        return date.valueOf() > now.valueOf() ? 'disabled' : '';
                                }
                        }
                });
        },
        empty: function(mixed_var) {
                // Checks if the argument variable is empty
                // undefined, null, false, number 0, empty string,
                // string "0", objects without properties and empty arrays
                // are considered empty
                //
                // http://kevin.vanzonneveld.net
                // +   original by: Philippe Baumann
                // +      input by: Onno Marsman
                // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
                // +      input by: LH
                // +   improved by: Onno Marsman
                // +   improved by: Francesco
                // +   improved by: Marc Jansen
                // +      input by: Stoyan Kyosev (http://www.svest.org/)
                // +   improved by: Rafal Kukawski
                // *     example 1: empty(null);
                // *     returns 1: true
                // *     example 2: empty(undefined);
                // *     returns 2: true
                // *     example 3: empty([]);
                // *     returns 3: true
                // *     example 4: empty({});
                // *     returns 4: true
                // *     example 5: empty({'aFunc' : function () { alert('humpty'); } });
                // *     returns 5: false
                var undef, key, i, len;
                var emptyValues = [undef, null, false, 0, "", "0"];

                for (i = 0, len = emptyValues.length; i < len; i++) {
                        if (mixed_var === emptyValues[i]) {
                                return true;
                        }
                }

                if (typeof mixed_var === "object") {
                        for (key in mixed_var) {
                                // TODO: should we check for own properties only?
                                //if (mixed_var.hasOwnProperty(key)) {
                                return false;
                                //}
                        }
                        return true;
                }

                return false;
        },
        /**
         * Cookie management
         * @type type
         */
        myCookie: {
                options: {
                        expires: 7,
                        path: '/',
                        domain: undefined, //defaults to the domain where the cookie was created,
                        secure: false
                },
                /**
                 *
                 * @param {string} namespace
                 * @param {string} key
                 * @param {string} value
                 * @returns {void}
                 */
                set: function(namespace, key, value, options)
                {
                        'use strict';

                        options = $.extend({}, MyUtils.myCookie.options, options || {});
                        $.cookie(namespace + '_' + key, value, options);
                },
                /**
                 * Get stored cookie
                 * @param {string} namespace
                 * @param {string} key
                 * @returns {mixed} value
                 */
                get: function(namespace, key)
                {
                        'use strict';
                        return $.cookie(namespace + '_' + key);
                },
                remove: function(namespace, key)
                {
                        'use strict';
                        $.removeCookie(namespace + '_' + key, MyUtils.myCookie.options);
                }
        }
        ,
        display_model_errors: function(string, notif_container_selector) {
                var message
                        , jsonData
                        , input_error_class = 'my-form-error'
                        , addErrorClass = function(id) {
                                $('#' + id).addClass(input_error_class);
                        };
                //remove all errors
                $('.' + input_error_class).removeClass(input_error_class);

                try {
                        jsonData = $.parseJSON(string);
                        message = '<ul>';
                        $.each(jsonData, function(i) {
                                if ($.isArray(jsonData[i])) {
                                        $.each(jsonData[i], function(j, msg) {
                                                message += '<li>' + msg + '</li>';
                                        });
                                }
                                else
                                        message += '<li>' + jsonData[i] + '</li>';
                                addErrorClass(i);
                        });
                        message += '</ul>'
                        this.showAlertMessage(message, 'error', notif_container_selector);
                } catch (e) {
                        this.showAlertMessage(string, 'error', notif_container_selector);
                }
        }
        ,
        /**
         * Clear all form values
         * @param {string} form_id
         * @returns {undefined}
         */
        clear_form: function(form_id) {
                $(':input', '#' + form_id).not(':button, :submit, :reset').val('').removeAttr('checked').removeAttr('selected').removeClass('my-form-error');
        }

}
