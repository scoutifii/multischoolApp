$(document).ready(function () {

    $('#doc-menu').affix({
        offset: {
            top: ($('#header').outerHeight(true) + $('#doc-header').outerHeight(true)) + 45,
            bottom: ($('#footer').outerHeight(true) + $('#promo-block').outerHeight(true)) + 75
        }
    });

    $(window).on('load resize', function () {
        $(window).trigger('scroll');
    });

    $('body').scrollspy({target: '#doc-nav', offset: 100});

    /* Smooth scrolling */
    $('a.scrollto').on('click', function (e) {
        //store hash
        var target = this.hash;
        e.preventDefault();
        $('body').scrollTo(target, 800, {offset: 0, 'axis': 'y'});

    });
    $('#gsms-wrapper .module-inner').matchHeight();
    $('#showcase .card').matchHeight();

    $(document).delegate('*[data-toggle="lightbox"]', 'click', function (e) {
        e.preventDefault();
        $(this).ekkoLightbox();
    });
});