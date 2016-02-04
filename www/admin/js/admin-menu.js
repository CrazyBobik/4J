/**
 * Created by CrazyBobik on 29.12.2015.
 */
$(function () {
    var head = $('#head');
    var menu = $('#main-menu');
    var center = $('#center');
    var foot = $('#footer');

    menu.on('click', '.toggle-sub-menu', function () {
        if ($(this).hasClass('up')) {
            closeMenu($(this));
        } else {
            openMenu($(this));
        }
    });

    menu.on('click', '.add-tree-leaf', function () {
        var val = $(this).closest('.main-menu-item').data('id');

        $.ajax({
            url: '/admin/tree/getAddLeafForm',
            data: {
                pid: val
            },
            method: 'POST',
            dataType: 'html',
            success: function (html) {
                changeCenter(html);
            }
        }, 'html');
    });

    menu.on('click', '.del-tree-leaf', function () {
        if (confirm('Вы уверены что хотите удалить этот элемент?')) {
            var id = $(this).closest('.main-menu-item').data('id');
            var type = $(this).closest('.main-menu-item').data('type');

            $.ajax({
                url: '/admin/' + type + '/delete' + type + '/ajax',
                data: {
                    id: id
                },
                method: 'POST',
                dataType: 'html',
                success: function (html) {
                    reloadMenu();
                }
            }, 'html');
        }
    });

    menu.on('click', '.update-tree-leaf', function () {
        var id = $(this).parent().data('id');
        var type = $(this).parent().data('type');

        $.ajax({
            url: '/admin/' + type + '/get' + type + '/ajax',
            data: {
                id: id
            },
            method: 'POST',
            dataType: 'html',
            success: function (html) {
                changeCenter(html);
            }
        }, 'html');
    });

    $('.dropdown-click').on('click', function () {
        $(this).next('.dropdown-menu').slideToggle(300);
    });

    $('.main-menu-toggle').on('click', function () {
        if (parseInt(menu.css('width')) == 50) {
            menu.css('width', '230px');
            $('#main-menu-bg').css('width', '230px');
            $('.logo').css({'width': '230px', 'padding': '0 7px'});
            $('.logo-mini').fadeOut(200, function () {
                $('.logo-lg').fadeIn(200);
            });
            foot.css('margin-left', '230px');
            center.css('padding-left', '230px');
            $('.main-menu-head').slideDown(300);
            $('.main-menu-item span').fadeIn(300);
            $('.toggle-sub-menu').fadeIn(300);
            $('.head-bar').css('margin-left', '230px');
            openCookieMenu();
        } else {
            menu.css('width', '50px');
            $('#main-menu-bg').css('width', '50px');
            $('.logo').css({'width': '50px', 'padding': '0 7px'});
            $('.logo-lg').fadeOut(200, function () {
                $('.logo-mini').fadeIn(200);
            });
            foot.css('margin-left', '50px');
            center.css('padding-left', '50px');
            $('.main-menu-head').slideUp(300);
            $('.main-menu-item span').fadeOut(300);
            $('.toggle-sub-menu').fadeOut(300);
            $('.head-bar').css('margin-left', '50px');
            closeAllMenu();
        }
    });

    openCookieMenu();
    initDragAndDropBlock();
});

function reloadMenu() {
    $.ajax({
        url: '/admin/helpers/reloadMenu/ajax',
        success: function (result) {
            $('nav').html(result);
            openCookieMenu();
            initDragAndDropBlock();
        }
    });
}

function openMenu(toggle) {
    toggle.parent().next('.sub-menu').slideDown(300);
    toggle.addClass('up');
    toggle.find('.fa').css('transform', 'rotate(180deg)');
    addCoockieArray('menuID', toggle.parent().data('id'));
}

function closeMenu(toggle) {
    toggle.parent().next('.sub-menu').slideUp(300);
    toggle.removeClass('up');
    toggle.find('.fa').css('transform', 'rotate(0)');
    removeCoockieArray('menuID', toggle.parent().data('id'));
}

function closeAllMenu() {
    $('.sub-menu').each(function () {
        var arr = $(this).prev().find('.toggle-sub-menu');
        if (arr.hasClass('up')) {
            arr.parent().next('.sub-menu').slideUp(300);
            arr.removeClass('up');
            arr.find('.fa').css('transform', 'rotate(0)');
        }
    });
}

function openCookieMenu() {
    var ids = getCoockieArray('menuID');
    ids.forEach(function (id) {
        var toggle = $('.main-menu-item[data-id="' + id + '"] .toggle-sub-menu');
        if(toggle.length > 0) {
            toggle.parent().next('.sub-menu').slideDown(300);
            toggle.addClass('up');
            toggle.find('.fa').css('transform', 'rotate(180deg)');
        } else{
            removeCoockieArray('menuID', id);
        }
    });
}

function initDragAndDropBlock(){
    $('.main-menu-item[data-type="page"] + .sub-menu').sortable({
        stop: function(event, ui){
            console.debug(ui.item.attr("data-id"));
        }
    });
}