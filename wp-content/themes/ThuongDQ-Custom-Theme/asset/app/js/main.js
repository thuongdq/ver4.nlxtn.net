// $(".menu-left").find('.dropdown').find('a').removeAttr('data-toggle');
// $('nav .toggle-submenu').click(function(e) {
//     if ($(this).hasClass('open')) {
//         $(this).next('.sub-menu').find('.sub-menu').slideUp();
//         $(this).next('.sub-menu').slideUp();
//         $(this).removeClass('open');
//         $(this).next('.sub-menu').find('.open').removeClass('open');
//     } else {
//         $(this).parent().siblings().find('.sub-menu').slideUp();
//         $(this).parent().siblings().find('.open').removeClass('open');
//         $(this).next('.sub-menu').slideDown();
//         $(this).addClass('open');
//     }
// });

// if ($(".left .menu").find('.current-menu-item').length === 0) {
//     $('.left .menu').find('.menu-item-has-children').first().find(".dropdown-menu").show();
//     console.log('empty');
// } else {
//     console.log("ok");
// }

$(".left").find('.support').addClass("hidden-lg hidden-md");
$(".content").find('.post-hot').addClass("hidden-lg hidden-md");
$('.page-detail').find('.breadcrumb_last').hide();
$('.page-detail').find('.breadcrumb_last').prev().hide();

$(".menu-agency").each(function(index, item) {
    count = $(item).find('li').length;
    if (count > 0) {
        remain = count - Math.floor(count / 2) * 2;
        // alert(remain);
        if (remain > 0) {
            for (i = 0; i < (2 - remain); i++) {
                $(item).append("<li>&nbsp;</li>");
            }
        }
    }
});

$(".list-agency").each(function(index, item) {
    count = $(item).find('.nav').find('li').length;
    if (count > 0) {
        remain = count - Math.floor(count / 3) * 3;
        // alert(remain);
        if (remain > 0) {
            for (i = 0; i < (3 - remain); i++) {
                $(item).find('ul').append("<li>&nbsp;</li>");
            }
        }
    }
});