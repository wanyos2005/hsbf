/**
 * Handles colorbox functions.
 * Please ensure that colorbox css and js are loaded before you call this extension.
 * This extension only handles form submit operation in colorbox
 * @author Fred <mconyango@gmail.com>
 */
(function($) {
        'use strict';

        var _mycolorbox = {
                options: {
                        notificationContainerSelector: undefined,
                        formSelector: undefined,
                        successClass: undefined,
                        errorClass: undefined,
                        submitButton: undefined,
                        cancelButton: undefined
                },
                submitButton: undefined,
                cancelButton: undefined,
                // METHODS
                /**
                 * Unitialize the form events.
                 * @param {array} options
                 * @returns {void}
                 */
                init: function(options) {
                        _mycolorbox.options = $.extend({}, _mycolorbox.options, options || {});
                        //_mycolorbox.options = options;

                        var form;

                        form = $(_mycolorbox.options.formSelector);
                        _mycolorbox.submitButton = form.find('button[type=submit]');
                        _mycolorbox.cancelButton = form.find('button[type=cancel]');

                        //close the colorbox when the cancel button is closed
                        _mycolorbox.cancelButton.on("click", function(event) {
                                event.preventDefault();
                                $.colorbox.close();
                        });

                        _mycolorbox.submitButton.on("click", function(event) {
                                event.preventDefault();
                                _mycolorbox.submitForm();
                                return false;
                        });
                },
                /**
                 * Submit the form via ajax
                 * @param {object} form
                 * @returns {void}
                 */
                submitForm: function() {
                        'use strict';
                        var form = $(_mycolorbox.options.formSelector)
                                , data = form.serialize()
                                , action = form.attr('action')
                                , method = form.attr('method')
                                , originalButtonHtml = form.find('button[type=submit]').html()
                                , notification_container = this.options.notificationContainerSelector;

                        if (typeof method === 'undefined')
                                method = 'POST';
                        $.ajax({
                                type: method,
                                url: action,
                                data: data,
                                dataType: 'json',
                                success: function(response) {
                                        if (response.success) {
                                                var message = '<i class=\"uk-icon-ok\"></i> ';
                                                message += response.message;
                                                MyUtils.showAlertMessage(message, 'success', notification_container);

                                                if (typeof response.redirectUrl !== 'undefined' && response.redirectUrl)
                                                        MyUtils.reload(response.redirectUrl, 1000);

                                                if (typeof response.select !== 'undefined' && typeof response.optionData !== 'undefined') {
                                                        var selected = null;
                                                        if (typeof response.selected !== 'undefined')
                                                                selected = response.selected;
                                                        MyUtils.populateDropDownList(response.select, response.optionData, selected);
                                                        form.colorbox.close();
                                                }
                                        }
                                        else {
                                                MyUtils.display_model_errors(response.message, notification_container);
                                        }
                                },
                                beforeSend: function() {
                                        _mycolorbox.submitButton.attr('disabled', 'disabled').html('Please wait....');
                                },
                                complete: function() {
                                        form.colorbox.resize();
                                        _mycolorbox.submitButton.html(originalButtonHtml).removeAttr('disabled');
                                },
                                error: function(XHR) {
                                        MyUtils.showAlertMessage(XHR.responseText, 'error', notification_container);
                                }
                        });
                }
        };

        //subscription plugin definition
        $.fn.mycolorbox = function(args) {
                if (_mycolorbox[args]) {
                        return _mycolorbox[ args ].apply(this, Array.prototype.slice.call(arguments, 1));
                } else if (typeof args === 'object' || !args) {
                        return _mycolorbox.init.apply(this, arguments);
                } else {
                        $.error('Method ' + args + ' does not exist on jQuery.mycolorbox');
                }
        };
}(jQuery));