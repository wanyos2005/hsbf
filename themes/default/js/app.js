//equivalent to jQuery.onload event
jQuery(function($) {
        'user strict'
        try {
                ace.settings.check_sidebar();
        } catch (e) {
        }
        MyController.Shared.init();
});