/**
 * Created by CrazyBobik on 29.12.2015.
 */
$(function () {
    $('.toggle-menu').on('click', function () {
        $(this).parent().next('.menu').slideToggle(500);
    });
});