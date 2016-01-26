/**
 * Created by CrazyBobik on 25.01.2016.
 */
$(function () {
    var config = $('#settings');

    $('.toggle-config').on({
        mouseenter: function () {
            $(this).find('.fa-cog').addClass('fa-spin');
        },
        mouseleave: function () {
            $(this).find('.fa-cog').removeClass('fa-spin');
        },
        click: function () {
            toggleConfig();
        }
    });
    config.on('click', '.one-tab', function () {
        var id = $(this).data('id');

        $('.one-tab').removeClass('active');
        $(this).addClass('active');
        $('.tab-context.active').fadeOut(300, function () {
            $(this).removeClass('active');
            $('.tab-context[data-id="' + id + '"]').fadeIn(300, function () {
                $(this).addClass('active');
            });
        });
    });

    $('.add-type').on('click', function () {
        $.ajax({
            url: '/admin/type/getType',
            method: 'POST',
            data: {
                ajax: 1
            },
            dataType: 'html',
            success: function (html) {
                changeCenter(html);
            }
        }, 'html');
    });

    $('.style-btn').on('click', function(){
        var color = $(this).data('style');

        $.ajax({
            url: '/admin/helpers/setStyle',
            data: {
                color: color
            },
            method: 'POST',
            success: function () {
                location.reload();
            }
        });
    });
});

function toggleConfig(){
    var config = $('#settings');

    if(parseInt(config.css('width')) == 0) {
        config.css({'width': '230px'});
    } else{
        config.css({'width': '0'});
    }
}
