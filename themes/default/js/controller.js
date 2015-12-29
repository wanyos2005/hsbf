/**
 * Contains all controllers js functions
 * @author Fred <mconyango@gmail.com>
 * @type type
 */
var MyController = {};
MyController = {
        Shared: {
                init: function() {
                        'use strict';
                        this.change_status();
                        this.grid_delete_multiple();
                        this.post_selected_grid_ids();
                        this.update_grid_view();
                        this.link_table_rows();
                        //show colorbox
                        $('body').on('click', 'a.show-colorbox', function() {
                                MyUtils.showColorbox($(this).attr('href'), true);
                                return false;
                        });
                        // $('body .timeago').timeago();
                }
                ,
                link_table_rows: function() {
                        var selector = 'tr.linked-table-row'
                                , href = $(selector).data('href');
                        //onclick
                        $('body').on('click', selector, function() {
                                MyUtils.reload(href);
                        });

                }
                ,
                change_status: function() {
                        'use strict';
                        var post_request = function(e) {
                                var url = $(e).data('ajax-url');
                                $.ajax({
                                        type: 'POST',
                                        url: url,
                                        success: function(data) {
                                                MyUtils.reload();
                                        }
                                        ,
                                        beforeSend: function() {
                                                MyUtils.startBlockUI('Please wait...');
                                        }
                                        ,
                                        complete: function() {
                                                MyUtils.stopBlockUI();
                                        }
                                        ,
                                        error: function(XHR) {
                                                var message = XHR.responseText;
                                                MyUtils.showAlertMessage(message, 'error');
                                                return false;
                                        }
                                });
                        };
                        //event
                        $('button.change_status').on('click', function() {
                                post_request(this);
                        });
                        return false;
                }
                ,
                grid_delete_multiple: function() {
                        'use strict';
                        $('.grid_delete_multiple').on('click', function() {
                                MyUtils.GridView.deleteMultiple(this);
                                return false;
                        });
                },
                post_selected_grid_ids: function() {
                        'use strict';
                        $('.post_selected_grid_ids').on('click', function() {
                                var grid_id = $(this).data('grid_id')
                                        , selected_ids = MyUtils.GridView.getSelectedIds(grid_id);
                                if (MyUtils.empty(selected_ids))
                                        return false;
                                var url = MyUtils.addParameterToURL($(this).data('ajax-url'), 'ids', selected_ids)
                                        , is_colorbox = $(this).data('colorbox');
                                if (typeof is_colorbox === 'undefined')
                                        MyUtils.reload(url);
                                else
                                        MyUtils.showColorbox(url);
                        });
                },
                update_grid_view: function() {
                        'use strict';
                        var update_grid = function(e) {

                                var grid_id = $(e).data('grid_id')
                                        , url = $(e).data('ajax-url')
                                        , confirm_msg = $(e).data('confirm');
                                if (typeof confirm_msg !== 'undefined') {
                                        if (!confirm(confirm_msg))
                                                return false;
                                }
                                MyUtils.GridView.submitGridView(grid_id, url);
                                return false;
                        };

                        $('body').on('click', '.my-update-grid', function() {
                                return update_grid(this);
                        });
                }

        }
        ,
        Users: {
                Roles: {
                        init: function() {
                                'use strict';
                                MyController.Users.Roles.toggleCheckAll();
                        },
                        toggleCheckAll: function()
                        {
                                'use strict';
                                $('button.my-select-all').on('click', function() {
                                        var checked = $(this).data('checked');
                                        if (checked) {
                                                $('input:checkbox.my-roles-checkbox').prop('checked', true);
                                                $(this).text('Uncheck all');
                                        }
                                        else {
                                                $('input:checkbox.my-roles-checkbox').prop('checked', false);
                                                $(this).text('Check all');
                                        }

                                        $(this).data('checked', !checked);
                                });
                        }
                },
                User: {
                        init: function() {
                                'use strict';
                                $('.Users_changeStatus').on('click', function() {
                                        return MyController.Users.User.changeStatus(this);
                                });
                                $('#Users_invited_by_id').on('blur', function() {
                                        return MyController.Users.User.verifyMember(this);
                                });
                        },
                        changeStatus: function(e) {
                                'use strict';
                                if (!confirm('Are you really sure?')) {
                                        return false;
                                }
                                var url = $(e).data('ajax-url');
                                $.ajax({
                                        type: 'post',
                                        url: url,
                                        success: function(response) {
                                                MyUtils.reload(response.redirectLink);
                                        },
                                        beforeSend: function() {
                                                MyUtils.startBlockUI('Processing...');
                                        },
                                        complete: function() {
                                                MyUtils.stopBlockUI();
                                        },
                                        error: function(XHR) {
                                                var message = XHR.responseText;
                                                MyUtils.showAlertMessage(message, 'error');
                                        }
                                });
                                return false;
                        },
                        verifyMember: function(e) {
                                'use strict';
                                var member_name_container = $('#mem_membername');
                                if (typeof member_name_container === 'undefined')
                                        return false;
                                var loading_html = member_name_container.html();
                                var url = $(e).data('ajax-url');
                                var value = $(e).val();
                                $.ajax({
                                        type: 'get',
                                        url: url,
                                        data: 'id=' + value,
                                        dataType: 'json',
                                        success: function(response) {
                                                console.log(response);
                                                if (response.success) {
                                                        member_name_container.html(response.message);
                                                }
                                                else {
                                                        $(e).val(''); //clear the invited_by_id field
                                                        member_name_container.html(response.message);
                                                }
                                        },
                                        beforeSend: function() {
                                                member_name_container.html(loading_html);
                                                member_name_container.removeClass('hidden');
                                        },
                                        complete: function() {

                                        },
                                        error: function(XHR) {
                                                var message = XHR.responseText;
                                                MyUtils.showAlertMessage(message, 'error');
                                                member_name_container.addClass('hidden');
                                        }
                                });
                                return false;
                        }
                },
                UserLevels: {},
        },
        Settings: {
                Email: {
                        init: function() {
                                'use strict';
                                var mailer_selector = '#settings_email_mailer';
                                MyController.Settings.Email.toggleSmtpSettings(mailer_selector);
                                $(mailer_selector).on('change', function() {
                                        MyController.Settings.Email.toggleSmtpSettings(this);
                                });
                        },
                        toggleSmtpSettings: function(e) {
                                'use strict';
                                if ($(e).val() === 'smtp') {
                                        $('#sendmail_settings').addClass('hidden');
                                        $('#smtp_settings').removeClass('hidden');
                                }
                                else {
                                        $('#smtp_settings').addClass('hidden');
                                        $('#sendmail_settings').removeClass('hidden');
                                }
                        }
                },
                Units: {
                        init: function() {
                                'use strict';
                                var from_selector = '#SettingsUnitsConversion_from_unit_id';
                                MyController.Settings.Units.getToSelectLists(from_selector);
                                $(from_selector).on('change', function() {
                                        MyController.Settings.Units.getToSelectLists(this);
                                });
                        },
                        getToSelectLists: function(e) {
                                'use strict';
                                var selected = $(e).val();
                                if (MyUtils.empty(selected))
                                        return false;
                                var form = $(e).closest('form');
                                var to_selector = '#SettingsUnitsConversion_to_unit_id';
                                var to_value = $(to_selector).data('selected-option');
                                $.ajax({
                                        type: 'get',
                                        url: $(e).data('ajax-link'),
                                        data: 'from=' + selected + '&to=' + to_value,
                                        dataType: 'json',
                                        success: function(response) {
                                                MyUtils.populateDropDownList(to_selector, response, to_value);
                                                $(to_selector).removeAttr('disabled');
                                        },
                                        beforeSend: function() {
                                                form.find('i.my-icon-loading').removeClass('hidden');
                                                $(to_selector).addClass('hidden');
                                        },
                                        complete: function() {
                                                form.find('i.my-icon-loading').addClass('hidden');
                                                $(to_selector).removeClass('hidden');
                                                form.colorbox.resize();
                                        },
                                        error: function(XHR) {
                                                var message = XHR.responseText;
                                                MyUtils.showAlertMessage(message, 'error', '#my-colorbox-notif');
                                        }
                                });
                                return false;
                        }
                },
                Tax: {
                        init: function() {
                                'use strict';
                                $('.delete-tax-category').on('click', function() {
                                        return MyController.Settings.Tax.delete_category(this);
                                });
                        }
                        ,
                        initForm: function() {
                                'use strict';
                                //spiner
                                $('#SettingsTaxes_rate').ace_spinner({value: 1, min: 1, max: 100, step: 1, btn_up_class: 'btn-info', btn_down_class: 'btn-info'});
                        },
                        delete_category: function(e) {
                                'use strict';
                                if (!confirm('Are you sure?'))
                                        return false;
                                $.ajax({
                                        type: 'POST',
                                        url: $(e).attr('href'),
                                        success: function(response) {
                                                MyUtils.reload();
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
                                return false;
                        },
                }
        },
        Inventory: {
                Items: {
                        maxImages: 4,
                        init: function() {

                        },
                        initForm: function() {
                                'use strict';
                                MyController.Inventory.Items.addImageField('#Inventory_images_container');
                        },
                        addImageField: function(e) {
                                'use strict';
                                var url, count, loader, loadingId;
                                url = $(e).data('image-field-link');
                                count = $(e + ' .item-image').length;
                                if (MyUtils.empty(count))
                                        count = 0;
                                count = parseInt(count) + 1;
                                if (count > MyController.Inventory.Items.maxImages)
                                        return false;
                                loadingId = 'item_image_loading_' + count;
                                loader = '<div class="col-lg-3 item-image-loading" id="' + loadingId + '"><i class="fa fa-spinner fa-spin fa-5x my-icon-loading"></i></div>';
                                $.ajax({
                                        type: 'get',
                                        url: url,
                                        data: 'count=' + 'tmp_' + count,
                                        success: function(html) {
                                                $('#' + loadingId).remove();
                                                $(e).append(html);
                                        },
                                        beforeSend: function() {
                                                $(e).append(loader);
                                        },
                                        complete: function() {
                                        },
                                        error: function(XHR) {
                                                $('#' + loadingId).remove();
                                                var message = XHR.responseText;
                                                MyUtils.showAlertMessage(message, 'error');
                                        }
                                });
                                return false;
                        }
                },
                Stock: {
                        init: function() {
                                'use strict';
                                $('.easy-pie-chart.percentage').each(function() {
                                        var e = this;
                                        $(e).easyPieChart({
                                                trackColor: "#444",
                                                scaleColor: false,
                                                lineCap: 'butt',
                                                lineWidth: 15,
                                                animate: false,
                                                size: 120,
                                                barColor: function(e) {
                                                        return "rgb(" + Math.round(200 * (1 - e / 100)) + ", " + Math.round(200 * e / 100) + ", 0)"
                                                }
                                        });
                                });
                        }
                },
        },
        Msg: {
                Message: {
                        init: function() {
                                'use strict';
                                var notification_anchor = '#topbar_messages_anchor';
                                MyController.Msg.Message.getNotifications(notification_anchor);
                        },
                        getNotifications: function(e) {
                                'use strict';
                                var notif_container_selector = '#topbar_messages'
                                        , notif_message_list_selector = '#topbar_messages_list'
                                        , unread_count_selector = notif_container_selector + ' span.unread'
                                        , url = $(e).data('ajax-url')
                                        , unread = $(e).data('unread');
                                var re_initialize_js = function() {
                                        $('.timeago').timeago();
                                };
                                $.ajax({
                                        type: 'get',
                                        url: url,
                                        data: 'unread=' + unread,
                                        dataType: 'json',
                                        success: function(response) {
                                                $(unread_count_selector).html(response.unread);
                                                $(e).data('unread', response.unread);
                                                if (response.html) {
                                                        $(notif_message_list_selector).html(response.html);
                                                }
                                                if (response.unread > 0) {
                                                        $(e + ' span.unread').removeClass('hidden');
                                                }
                                                else {
                                                        $(e + ' span.unread').addClass('hidden');
                                                }
//wait for 20 secs before checking for new notification again
                                                setTimeout(function() {
                                                        MyController.Msg.Message.getNotifications(e);
                                                }, 20000);
                                        },
                                        beforeSend: function() {
                                        },
                                        complete: function() {
                                                re_initialize_js();
                                        },
                                        error: function(XHR) {
                                        }
                                });
                                return false;
                        },
                        Inbox: {
                                active_sort_link_id: undefined,
                                init: function() {
                                        'use strict';
                                        var content = $('.message-container');
                                        //basic initializations
                                        $('.message-list').on('click', '.message-item input[type=checkbox]', function() {
                                                $(this).closest('.message-item').toggleClass('selected');
                                                if (this.checked)
                                                        MyController.Msg.Message.Inbox.display_bar(1); //display action toolbar when a message is selected
                                                else {
                                                        MyController.Msg.Message.Inbox.display_bar($('.message-list input[type=checkbox]:checked').length);
                                                        //determine number of selected messages and display/hide action toolbar accordingly
                                                }
                                        });
                                        //check/uncheck all messages
                                        $('#id-toggle-all').removeAttr('checked').on('click', function() {
                                                if (this.checked) {
                                                        MyController.Msg.Message.Inbox.select_all();
                                                } else
                                                        MyController.Msg.Message.Inbox.select_none();
                                        });
                                        //select all
                                        $('#id-select-message-all').on('click', function(e) {
                                                e.preventDefault();
                                                MyController.Msg.Message.Inbox.select_all();
                                        });
                                        //select none
                                        $('#id-select-message-none').on('click', function(e) {
                                                e.preventDefault();
                                                MyController.Msg.Message.Inbox.select_none();
                                        });
                                        //select read
                                        $('#id-select-message-read').on('click', function(e) {
                                                e.preventDefault();
                                                MyController.Msg.Message.Inbox.select_read();
                                        });
                                        //select unread
                                        $('#id-select-message-unread').on('click', function(e) {
                                                e.preventDefault();
                                                MyController.Msg.Message.Inbox.select_unread();
                                        });
                                        //delete selected
                                        content.on('click', '#_delete_selected', function() {
                                                MyController.Msg.Message.Inbox.delete_selected(this);
                                        });
                                        //mark as _mark_as_
                                        $('.message-container').on('click', 'ul#_mark_as_ li > a', function() {
                                                MyController.Msg.Message.Inbox.mark_thread_as(this);
                                        });
                                        //timeago
                                        $('time.timeago').timeago();
                                        //show active sort
                                        if (typeof MyController.Msg.Message.Inbox.active_sort_link_id !== 'undefined') {
                                                var $this = $('#' + MyController.Msg.Message.Inbox.active_sort_link_id);
                                                $this.closest('ul').find('li>a>i').removeClass('green').addClass('invisible');
                                                $this.find('i').removeClass('invisible').addClass('green');
                                        }
                                        $('.inbox-listview-sorter a').on('click', function() {
                                                MyController.Msg.Message.Inbox.active_sort_link_id = $(this).attr('id');
                                        });
                                        //linkify message-item
                                        $('.message-item span').on('click', function() {
                                                window.location = $(this).closest('.message-item').data('target');
                                        });
                                        //slimScroll for message body
                                        MyController.Msg.Message.Inbox.set_slimscroll();
                                        //thread-list
                                        $('.thread-list a.sender').on('click', function() {
                                                MyController.Msg.Message.Inbox.show_thread(this);
                                                return false;
                                        });
                                        //mark inbox as read when the inbox is opened
                                        MyController.Msg.Message.Inbox.mark_inbox_as_read();
                                },
                                //displays a toolbar according to the number of selected messages
                                display_bar: function(count) {
                                        'use strict';
                                        if (count == 0) {
                                                $('#id-toggle-all').removeAttr('checked');
                                                $('#id-message-list-navbar .message-toolbar').addClass('hide');
                                                $('#id-message-list-navbar .message-infobar').removeClass('hide');
                                        }
                                        else {
                                                $('#id-message-list-navbar .message-infobar').addClass('hide');
                                                $('#id-message-list-navbar .message-toolbar').removeClass('hide');
                                        }
                                }
                                ,
                                select_all: function() {
                                        var count = 0;
                                        $('.message-item input[type=checkbox]').each(function() {
                                                this.checked = true;
                                                $(this).closest('.message-item').addClass('selected');
                                                count++;
                                        });
                                        $('#id-toggle-all').get(0).checked = true;
                                        MyController.Msg.Message.Inbox.display_bar(count);
                                }
                                ,
                                select_none: function() {
                                        $('.message-item input[type=checkbox]').removeAttr('checked').closest('.message-item').removeClass('selected');
                                        $('#id-toggle-all').get(0).checked = false;
                                        MyController.Msg.Message.Inbox.display_bar(0);
                                }
                                ,
                                select_read: function() {
                                        $('.message-unread input[type=checkbox]').removeAttr('checked').closest('.message-item').removeClass('selected');
                                        var count = 0;
                                        $('.message-item:not(.message-unread) input[type=checkbox]').each(function() {
                                                this.checked = true;
                                                $(this).closest('.message-item').addClass('selected');
                                                count++;
                                        });
                                        MyController.Msg.Message.Inbox.display_bar(count);
                                }
                                ,
                                select_unread: function() {
                                        $('.message-item:not(.message-unread) input[type=checkbox]').removeAttr('checked').closest('.message-item').removeClass('selected');
                                        var count = 0;
                                        $('.message-unread input[type=checkbox]').each(function() {
                                                this.checked = true;
                                                $(this).closest('.message-item').addClass('selected');
                                                count++;
                                        });
                                        MyController.Msg.Message.Inbox.display_bar(count);
                                }
                                ,
                                /**
                                 *Returns the ids(comma separated) of the selected messages
                                 * @returns {Array}
                                 */
                                getSelection: function() {
                                        var e = $('#inbox-listview'),
                                                keys = e.find('.keys span'),
                                                selection = [];
                                        e.find('.message-item').each(function(i) {
                                                if ($(this).hasClass('selected')) {
                                                        selection.push(keys.eq(i).text());
                                                }
                                        });
                                        return selection;
                                }
                                ,
                                delete_selected: function(e) {
                                        'use strict';
                                        var message_container_id = 'inbox-listview'
                                                , url = $(e).data('ajax-url')
                                                , ids = $(e).data('id');
                                        if (typeof ids === 'undefined')
                                                ids = MyController.Msg.Message.Inbox.getSelection();
                                        if (ids.length === 0 || ids === '') {
                                                return false;
                                        }

                                        if (!confirm('Are you sure?'))
                                                return false;
                                        $.fn.yiiListView.update(message_container_id, {
                                                type: 'POST',
                                                url: url,
                                                data: 'ids=' + ids,
                                                success: function(data) {
                                                        $.fn.yiiListView.update(message_container_id);
                                                }
                                                ,
                                                beforeSend: function() {
                                                }
                                                ,
                                                complete: function() {
                                                        MyUtils.stopBlockUI();
                                                }
                                                ,
                                                error: function(XHR) {
                                                        var message = XHR.responseText;
                                                        MyUtils.showAlertMessage(message, 'error');
                                                        return false;
                                                }
                                        });
                                        return false;
                                }
                                ,
                                mark_thread_as: function(e) {
                                        'use strict';
                                        var message_container_id = 'inbox-listview'
                                                , url = $(e).data('ajax-url')
                                                , ids = $(e).data('id');
                                        if (typeof ids === 'undefined')
                                                ids = MyController.Msg.Message.Inbox.getSelection();
                                        if (ids.length === 0 || ids === '') {
                                                return false;
                                        }

                                        $.fn.yiiListView.update(message_container_id, {
                                                type: 'POST',
                                                url: url,
                                                data: 'ids=' + ids,
                                                success: function(data) {
                                                        $.fn.yiiListView.update(message_container_id);
                                                }
                                                ,
                                                beforeSend: function() {
                                                }
                                                ,
                                                complete: function() {
                                                        MyUtils.stopBlockUI();
                                                }
                                                ,
                                                error: function(XHR) {
                                                        var message = XHR.responseText;
                                                        MyUtils.showAlertMessage(message, 'error');
                                                        return false;
                                                }
                                        });
                                        return false;
                                }
                                ,
                                reload_thread: function(options)
                                {
                                        'use strict';
                                        $.fn.yiiListView.update('inbox-listview', options);
                                }
                                ,
                                show_thread: function(e) {
                                        'use strict';
                                        var thread_list = $(e).closest('.thread-list');
                                        var active_thread = $('.thread-list.active');
                                        active_thread.removeClass('active');
                                        active_thread.find('.message-body').slimScroll({
                                                destroy: true,
                                        });
                                        thread_list.addClass('active');
                                        MyController.Msg.Message.Inbox.set_slimscroll();
                                        //mark as read
                                        MyController.Msg.Message.Inbox.mark_inbox_as_read();
                                        //sidemenu.css("overflow", "");

                                },
                                set_slimscroll: function() {
                                        'use strict';
                                        $('.thread-list.active').find('.message-body').slimScroll({
                                                height: 150,
                                                railVisible: true
                                        });
                                }
                                ,
                                mark_inbox_as_read: function() {
                                        'use strict';
                                        var e = $('.thread-list.unread.active');
                                        if (typeof e === 'undefined')
                                                return false;
                                        var url = $(e).data('mark-as-url');
                                        $.ajax({
                                                type: 'POST',
                                                url: url,
                                                success: function(response) {
                                                        $(e).removeClass('unread');
                                                },
                                        });
                                        return false;
                                }
                        },
                },
        }
        ,
        Earning: {
                Level: {
                        init: function() {
                                'use strict';
                                this.get_grown_levels();
                        }
                        ,
                        get_grown_levels: function() {
                                var selector = '#EarningLevel_rank'
                                        , get_grown_levels = function(e) {
                                                var weight = parseInt($(e).val())
                                                        , ajax_url = $(e).data('grown_levels_url')
                                                        , grown_levels_option_selector = '#EarningLevel_required_grown_level_id'
                                                        , selected = $(grown_levels_option_selector).data('selected');

                                                if (MyUtils.empty(weight))
                                                        return false;

                                                $.ajax({
                                                        type: 'GET',
                                                        url: ajax_url,
                                                        data: 'weight=' + weight,
                                                        success: function(response) {
                                                                console.log(response);
                                                                MyUtils.populateDropDownList(grown_levels_option_selector, response, selected);
                                                        }
                                                });
                                                return true;
                                        };

                                //onload
                                get_grown_levels(selector);
                                //onblur
                                $(selector).on('blur', function() {
                                        get_grown_levels(this);
                                        return true;
                                });
                        }
                }
                ,
                Matrix: {
                        options: {
                                base_id: 'EarningProfitMatrix',
                                product_id_field: 'product_id',
                                initial_profit_field: 'initial_profit',
                                subsequent_profit_field: 'subsequent_profit',
                                initial_buying_price_field: 'initial_buying_price',
                                subsequent_buying_price_field: 'subsequent_buying_price',
                                selling_price_field: 'selling_price',
                                button_id: 'earning_matrix_button',
                        }
                        ,
                        init: function(options) {
                                'use strict';
                                var settings = $.extend({}, this.options, options || {});
                                this.update_profit(settings);
                                this.submit_form(settings);
                        }
                        ,
                        update_profit: function(settings) {
                                var selector = '.earning-calculation'
                                        , get_id = function(product_id, field) {
                                                return  settings.base_id + '_' + product_id + '_' + field;
                                        },
                                        calculate_profit = function(buying_price, selling_price) {
                                                if (MyUtils.empty(buying_price))
                                                        return 0;
                                                var profit = ((selling_price - buying_price) / buying_price) * 100;
                                                return Math.round(profit);
                                        },
                                        update_profit = function(e) {
                                                var parent = $(e).closest('.earning-matrix-row')
                                                        , product_id = parent.data('product_id')
                                                        , selling_price = $('#' + get_id(product_id, settings.selling_price_field)).val()
                                                        , initial_buying_price = $('#' + get_id(product_id, settings.initial_buying_price_field)).val()
                                                        , initial_profit_selector = '#' + get_id(product_id, settings.initial_profit_field)
                                                        , subsequent_buying_price = $('#' + get_id(product_id, settings.subsequent_buying_price_field)).val()
                                                        , subsequent_profit_selector = '#' + get_id(product_id, settings.subsequent_profit_field);

                                                if (!MyUtils.empty(selling_price)) {
                                                        if (!MyUtils.empty(initial_buying_price)) {
                                                                $(initial_profit_selector).val(calculate_profit(initial_buying_price, selling_price));
                                                        }
                                                        if (!MyUtils.empty(subsequent_buying_price)) {
                                                                $(subsequent_profit_selector).val(calculate_profit(subsequent_buying_price, selling_price));
                                                        }
                                                }
                                        }
                                ;
                                //on blur event
                                $(selector).on('blur', function() {
                                        update_profit(this);
                                });
                        }
                        ,
                        submit_form: function(settings) {
                                var button = $('#' + settings.button_id)
                                        , form = button.closest('form')
                                        , alert_selector = '#form_ajax_alert'
                                        , submit_form = function() {
                                                var action = form.attr('action')
                                                        , method = form.attr('method') || 'POST';

                                                $.ajax({
                                                        type: method,
                                                        url: action,
                                                        data: form.serialize(),
                                                        dataType: 'json',
                                                        success: function(response) {
                                                                if (response.success) {
                                                                        MyUtils.reload();
                                                                }
                                                                else {
                                                                        var row = '#' + settings.base_id + '_' + response.id;
                                                                        form.find('.earning-matrix-row').removeClass('bg-danger');
                                                                        $(row).addClass('bg-danger');
                                                                }
                                                        },
                                                        beforeSend: function() {
                                                                MyUtils.startBlockUI('Saving ...');
                                                        },
                                                        complete: function() {
                                                                MyUtils.stopBlockUI();
                                                        },
                                                        error: function(XHR) {
                                                                MyUtils.showAlertMessage(XHR.responseText, 'error', alert_selector);
                                                        }
                                                });
                                                return false;
                                        };

                                button.on('click', function() {
                                        submit_form();
                                        return false;
                                });
                        }
                }
        }
}
