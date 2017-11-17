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

    swal.setDefaults({
        animation: false,
        background: "#000",
        customClass: "modal-swal-style",
        buttonsStyling: false,
        confirmButtonClass: "modal-swal-btn-style"
    });

    $("#contact-form-btn").on("click", function () {
        $("#contact-form-btn").prop("disabled", true);
        $.ajax({
            url: "api/addContact.php",
            data: {
                "name": $('#contact_name').val(),
                "email": $('#contact_email').val(),
                "message": $('#contact_message').val()
            },
            type: 'post',
            success: function (response) {
                if (!response.error) {
                    swal("Succes", "We will respond to you as soon as possible.", "success");
                } else {
                    swal("ERROR", response.error, "error");
                }
                $("#contact-form-btn").prop("disabled", false);
            },
            error: function () {
                swal("Server error!");
                $("#contact-form-btn").prop("disabled", false);
            }
        });
    });

    $("#newsletter-form-btn").on("click", function () {
        $("#contact-form-btn").prop("disabled", true);
        $.ajax({
            url: "api/confirmSubscribe.php",
            data: {
                "email": $('#newsletter_email').val()
            },
            type: 'post',
            success: function (response) {
                response = JSON.parse(response);
                if (!response.error) {
                    swal("Succes", "We sent confirmation for subscribing to your email.", "success");
                } else {
                    swal("ERROR", response.error, "error");
                }
                $("#contact-form-btn").prop("disabled", false);
            },
            error: function () {
                swal("Server error!");
                $("#contact-form-btn").prop("disabled", false);
            }
        });
    });

    var query_str = location.search.substr(1),
        params = query_str.split('&'),
        msg = params.find(function (elem) {
            return elem && RegExp(/msg=.*/i).test(elem);
        });

    if (msg) {
        var values = msg.split('=');
        swal(values[1], "", "success");
    }
});