/**
 * Created by CrazyBobik on 29.12.2015.
 */
$(function () {
    $('.toggle-menu').on('click', function () {
        $(this).parent().next('.menu').slideToggle(500);
    });

    $('.add-tree-leaf').on('click', function () {
        var val = $(this).parent().data('id');

        $.ajax({
            url: '/admin/tree/getAddLeafForm',
            data: {
                pid: val
            },
            method: 'POST',
            dataType: 'html',
            success: function (html) {
                $('#center').html(html);
            }
        }, 'html');
    });

    $('.del-tree-leaf').on('click', function () {
        var id = $(this).parent().data('id');
        var type = $(this).parent().data('type');

        $.ajax({
            url: '/admin/' + type + '/delete' + type,
            data: {
                id: id
            },
            method: 'POST',
            dataType: 'html',
            success: function (html) {
                if(html){
                    alert('ydaleno');
                }
            }
        }, 'html');
    });

    $('.update-tree-leaf').on('click', function () {
        var id = $(this).parent().data('id');
        var type = $(this).parent().data('type');

        $.ajax({
            url: '/admin/' + type + '/get' + type,
            data: {
                id: id
            },
            method: 'POST',
            dataType: 'html',
            success: function (html) {
                $('#center').html(html);
            }
        }, 'html');
    });
});