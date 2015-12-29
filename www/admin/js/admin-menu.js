/**
 * Created by CrazyBobik on 29.12.2015.
 */
$(function () {
    $('.toggle-menu').on('click', function () {
        $(this).parent().find('.menu:first').slideToggle(500);
    });
});