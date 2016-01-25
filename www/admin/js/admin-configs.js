/**
 * Created by CrazyBobik on 25.01.2016.
 */
$(function () {
    var config = $('#settings');

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
});
