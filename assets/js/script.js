$(document).ready(function () {

    function checkWidth() {
        var windowSize = $(window).width();

        if (windowSize >= 991) {
            $('.main-wrapper').on('load scroll', function () {
                var scrolled = $(this).scrollTop();
                $('#headerVideo').css('transform', 'translate3d(0, ' + (scrolled * 0.25) + 'px, 0)'); // parallax (25% scroll rate)
            });

            $('.main-wrapper').on('load scroll', function () {
                console.log(scrolledUp);
                var scrolledUp = $(this).scrollTop();
                var headerVideo = $('.header-video ').height();
                if (scrolledUp >= headerVideo) {
                    $("#videoBottom").addClass('video-bottom_fixed');
                } else {
                    $("#videoBottom").removeClass('video-bottom_fixed');
                }
            });
        }
        else {
            $(window).on('load scroll', function () {
                var scrolled = $(this).scrollTop();
                $('#headerVideo').css('transform', 'translate3d(0, ' + (scrolled * 0.25) + 'px, 0)'); // parallax (25% scroll rate)
            });

            $(window).on('load scroll', function () {
                console.log(scrolledUp);
                var scrolledUp = $(this).scrollTop();
                var headerVideo = $('.header-video ').height();
                if (scrolledUp >= headerVideo) {
                    $("#videoBottom").addClass('video-bottom_fixed');
                } else {
                    $("#videoBottom").removeClass('video-bottom_fixed');
                }
            });
        }
    }

    // Execute on load
    checkWidth();
    // Bind event listener
    $(window).resize(checkWidth);

    $("video.header-video").get(0).play();
});
