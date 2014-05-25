/* Resize page to fill browser window */
/* Depends on jQuery */

var WINDOW_MIN_HEIGHT = 440;

function resize_window() {
    var page_outer_height = parseInt($('.page').css('margin-top')) + parseInt($('.page').css('margin-bottom')) +
        parseInt($('.page').css('border-top-width')) + parseInt($('.page').css('border-bottom-width'));
    $(window).resize(function () {
        if ($('.page').height() < $(window).height()) {
            $('.page').height(Math.max(WINDOW_MIN_HEIGHT, Math.max(0, ($(window).height() - page_outer_height))));
        }
    }).resize();
}

$(resize_window);
