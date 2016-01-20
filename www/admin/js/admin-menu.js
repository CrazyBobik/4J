/**
 * Created by CrazyBobik on 29.12.2015.
 */
$(function () {
    var menu = $('nav');
    menu.on('click', '.toggle-menu', function () {
        $(this).parent().next('.menu').slideToggle(500);
    });

    menu.on('click', '.add-tree-leaf', function () {
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

    menu.on('click', '.del-tree-leaf', function () {
        var id = $(this).parent().data('id');
        var type = $(this).parent().data('type');

        $.ajax({
            url: '/admin/' + type + '/delete' + type,
            data: {
                id: id,
                ajax: 1
            },
            method: 'POST',
            dataType: 'html',
            success: function (html) {
                reloadMenu();
            }
        }, 'html');
    });

    menu.on('click', '.update-tree-leaf', function () {
        var id = $(this).parent().data('id');
        var type = $(this).parent().data('type');

        $.ajax({
            url: '/admin/' + type + '/get' + type,
            data: {
                id: id,
                ajax: 1
            },
            method: 'POST',
            dataType: 'html',
            success: function (html) {
                $('#center').html(html);
            }
        }, 'html');
    });
});

function reloadMenu(){
    $.ajax({
        url: '/admin/helpers/reloadMenu',
        method: 'POST',
        data:{
            ajax: 1
        },
        success: function (result) {
            $('nav').html(result);
        }
    });
}