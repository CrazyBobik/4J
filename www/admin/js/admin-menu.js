/**
 * Created by CrazyBobik on 29.12.2015.
 */
$(function () {
    var head = $('#head');
    var menu = $('#main-menu');
    var center = $('#center');
    var foot = $('#footer');

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

    $('.dropdown-click').on('click', function () {
        $(this).next('.dropdown-menu').slideToggle(500);
    });

    $('.toggle-config').on({
        mouseenter: function () {
            $(this).find('.fa-cog').addClass('fa-spin');
        },
        mouseleave: function () {
            $(this).find('.fa-cog').removeClass('fa-spin');
        },
        click: function () {
            var sett = $('#settings');
            if(parseInt(sett.css('width')) == 0) {
                sett.css('width', '230px');
            } else{
                sett.css('width', '0');
            }
        }
    });
    $('.main-menu-toggle').on('click', function () {
        if(parseInt(menu.css('width')) == 50) {
            menu.css('width', '230px');
            $('.logo').css({'width': '230px', 'padding': '0 7px'});
            $('.logo-mini').fadeOut(200, function () {
                $('.logo-lg').fadeIn(200);
            });
            foot.css('margin-left', '230px');
            center.css('margin-left', '230px');
            $('.head-bar').css('margin-left', '230px');
        } else{
            menu.css('width', '50px');
            $('.logo').css({'width': '50px', 'padding': '0 7px'});
            $('.logo-lg').fadeOut(200, function () {
                $('.logo-mini').fadeIn(200);
            });
            foot.css('margin-left', '50px');
            center.css('margin-left', '50px');
            $('.head-bar').css('margin-left', '50px');
        }
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