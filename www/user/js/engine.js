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
                    setTimeout(function(){
                        eval(result.callback);
                        callback();
                    }, timeout);
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
    element.removeClass();
    element.addClass(clazz);
    element.find('#mess-result-text').html(mess);

    element.show(500);
}