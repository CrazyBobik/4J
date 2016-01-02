/**
 * Created by CrazyBobik on 29.12.2015.
 */
$(function () {
    $('.toggle-menu').on('click', function () {
        $(this).parent().next('.menu').slideToggle(500);
    });

    $('.add-tree-leaf').on('click', function () {
        var val = $(this).data('id');

        $.ajax({
            url: '/admin/tree/getAddLeafForm',
            dataType: 'html',
            success: function (html) {
                $('#center').html(html);
            }
        }, 'html');
    });
});