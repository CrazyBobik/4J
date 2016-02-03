/**
 * Created by CrazyBobik on 04.10.2015.
 */
$(function () {
    $('body').on('submit', '.ajax-form', function () {
        var form = $(this);
        form.ajaxSubmit({
            semantic: true,
            dataType: 'json',
            success: function(result){
                var element;
                if (result.messID === undefined){
                    element = $('#mess-result-info');
                } else {
                    element = $(result.messID);
                }

                var clazz;
                if(result.error === true){
                    clazz = 'error';
                } else {
                    clazz = 'success';
                    form.clearForm();
                }

                showFormResult(clazz, result.mess, element);

                var timeout;
                if(result.tout === undefined){
                    timeout = 3000;
                } else {
                    timeout = result.tout;
                }
                if (typeof(result.callback) == "string"){
                    eval(result.callback);
                    callback();
                }
                if (result.redirect !== undefined){
                    setTimeout(function(){location.href = result.redirect}, timeout);
                }
            }
        }, 'json');

        return false;
    });
});

function showFormResult(clazz, mess, element){
    element.hide(300);
    element.find('.mess-img').fadeOut(0);
    element.removeClass('critical info warning success help');
    element.addClass(clazz);
    element.html('<div class="mess-img"></div>' + mess);

    element.show(300, function () {
        $(this).find('.mess-img').fadeIn(300);
    });
}