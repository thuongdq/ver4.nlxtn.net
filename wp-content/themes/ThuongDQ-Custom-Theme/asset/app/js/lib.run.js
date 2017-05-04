$(window).load(function() {
    //     $(".right").find("#content-slider").lightSlider({
    //         loop: true,
    //         keyPress: true,
    //         item: 1
    //     });
    //     $(".left").find("#content-slider").lightSlider({
    //         loop: true,
    //         keyPress: true,
    //         item: 1
    //     });
    // alert($('.nav').find('.menu-item-has-children').find('a').first().html());
    $('.nav').find('.menu-item-has-children').each(function(index, item) {
        $(item).addClass('dropdown');
        element_a = $(item).find('a').first();
        element_a.html(element_a.html() + "<span class='caret navbar-toggle sub-arrow'></span>");
    });
    // $('.has-submenu').each(function(index, item) {
    //     $(item).html($(item).html() + "<span class='caret navbar-toggle sub-arrow'></span>");
    // });
    // $('.dropdown').each(function(index, item) {
    //     extend = $(item).find('a').first();
    //     alert(extend.html())

    //     $(item).html($(item).html() + "<span class='caret navbar-toggle sub-arrow'></span>");
    // });
});