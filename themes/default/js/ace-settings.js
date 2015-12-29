if (!('ace' in window))
        window['ace'] = {};
var $ = jQuery;
ace.settings = {
        namespace: 'mlm_ace_settings',
        is: function(item, status) {
                return (MyUtils.myCookie.get(ace.settings.namespace, item + '-' + status) == 1);
        },
        exists: function(item, status) {
                return (MyUtils.myCookie.get(ace.settings.namespace, item + '-' + status) !== null);
        },
        set: function(item, status) {
                MyUtils.myCookie.set(ace.settings.namespace, item + '-' + status, 1);
        },
        unset: function(item, status) {
                MyUtils.myCookie.set(ace.settings.namespace, item + '-' + status, -1);
        },
        remove: function(item, status) {
                MyUtils.myCookie.remove(ace.settings.namespace, item + '-' + status);
        },
        sidebar_collapsed: function(collpase) {
                collpase = collpase || false;

                var sidebar = $('#sidebar');
                var icon = $('#sidebar-collapse i');
                var $icon1 = icon.data('icon1');//the icon for expanded state
                var $icon2 = icon.data('icon2');//the icon for collapsed state

                if (collpase) {
                        sidebar.addClass('menu-min');
                        icon.removeClass($icon1);
                        icon.addClass($icon2);

                        ace.settings.set('sidebar', 'collapsed');
                } else {
                        sidebar.removeClass('menu-min');
                        icon.removeClass($icon2);
                        icon.addClass($icon1);

                        ace.settings.unset('sidebar', 'collapsed');
                }
                ace.settings.reset_sidebar_slimscroll(sidebar);
        },
        check_sidebar: function() {
                'use strict';
                var item = 'sidebar'
                        , value = 'collapsed'
                        , collapse_class = 'menu-min'
                        , status
                        , sidebar;

                status = ace.settings.is(item, value);// is sidebar-collapsed?
                sidebar = $('#' + item);
                if (status != sidebar.hasClass(collapse_class)) {
                        ace.settings.sidebar_collapsed(status);
                }
                ace.settings.reset_sidebar_slimscroll(sidebar);
        },
        reset_sidebar_slimscroll: function(sidebar) {
                var sidemenu = sidebar.find('.nav-list');
                if (sidebar.hasClass('menu-min')) {
                        if (sidemenu.attr('style') !== undefined) {
                                sidemenu.slimScroll({
                                        destroy: true,
                                });
                                sidemenu.css("overflow", "");
                        }
                }
                else {
                        sidemenu.slimScroll({
                                height: '450px',
                                distance: 0,
                                size: '6px'
                        });
                }
        },
        set_skin: function(e) {
                'use strict';
                var skin_class = $(e).find('option:selected').data('skin');
                MyUtils.myCookie.set(ace.settings.namespace, 'skin', skin_class);
                ace.settings.check_skin();
        },
        check_skin: function()
        {
                'use strict';
                var skin_class = MyUtils.myCookie.get(ace.settings.namespace, 'skin');
                var color_picker = '#skin-colorpicker';
                var selected_color = $(color_picker + ' option[data-skin="' + skin_class + '"]').attr('value');
                $(color_picker).val(selected_color);
                var body = $(document.body);
                body.removeClass('skin-1 skin-2 skin-3');

                if (skin_class != 'default')
                        body.addClass(skin_class);

                if (skin_class == 'skin-1') {
                        $('.ace-nav > li.grey').addClass('dark');
                }
                else {
                        $('.ace-nav > li.grey').removeClass('dark');
                }

                if (skin_class == 'skin-2') {
                        $('.ace-nav > li').addClass('no-border margin-1');
                        $('.ace-nav > li:not(:last-child)').addClass('light-pink').find('> a > [class*="icon-"]').addClass('pink').end().eq(0).find('.badge').addClass('badge-warning');
                }
                else {
                        $('.ace-nav > li').removeClass('no-border margin-1');
                        $('.ace-nav > li:not(:last-child)').removeClass('light-pink').find('> a > [class*="icon-"]').removeClass('pink').end().eq(0).find('.badge').removeClass('badge-warning');
                }

                if (skin_class == 'skin-3') {
                        $('.ace-nav > li.grey').addClass('red').find('.badge').addClass('badge-yellow');
                } else {
                        $('.ace-nav > li.grey').removeClass('red').find('.badge').removeClass('badge-yellow');
                }

                //renew cookie
                MyUtils.myCookie.set(ace.settings.namespace, 'skin', skin_class);
        }
};
