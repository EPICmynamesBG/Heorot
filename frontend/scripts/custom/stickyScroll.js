var obj = $("#sticky-scroll");
var spacer = $("#sticky-spacer");
var wrapper = $('#scroll-wrapper');

wrapper.on("scroll", function (e) {
    if (wrapper.scrollTop() > 144 && $(window).width() > 992) {
        obj.addClass("stuck");
        spacer.addClass('active');
    } else {
        obj.removeClass("stuck");
        spacer.removeClass('active');
    }

});
