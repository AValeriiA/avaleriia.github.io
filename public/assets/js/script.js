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

    (function carouselNormalization() {
        var items = $('#carouselCitations .carousel-item'), //grab all slides
            heights = [], //create empty array to store height values
            tallest; //create variable to make note of the tallest slide

        if (items.length) {
            function normalizeHeights() {
                items.each(function() { //add heights to array
                    heights.push($(this).height());
                });
                tallest = Math.max.apply(null, heights); //cache largest value
                items.each(function() {
                    $(this).css('min-height', tallest + 'px');
                });
            }
            normalizeHeights();

            $(window).on('resize orientationchange', function() {
                tallest = 0;
                heights.length = 0; //reset vars
                items.each(function() {
                    $(this).css('min-height', '0'); //reset min-height
                });
                normalizeHeights(); //run it again
            });
        }
    })();

    // Execute on load
    checkWidth();
    // Bind event listener
    $(window).resize(checkWidth);

    // Activate Carousel
    $('.carousel').carousel();

    $("video.header-video").get(0).play();
});