/**
 * Created by CrazyBobik on 13.10.2015.
 */
$(function () {
    var modal = $('#modal');
    
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

    $('.add-type').on('click', function () {
        modalOpen($(this));
    });

    modal.on('click', '.one-type', function(){
        addFieldForm($(this).data('type'));
    });
    modal.on('click', '.add-variants', function(){
        addVariantsRow($(this).data('id'));
    });
});

function showFormResult(clazz, mess, element){
    element.removeClass();
    element.addClass(clazz);
    element.find('#mess-result-text').html(mess);

    element.show(500);
}

function modalOpen(elem){
    var method = elem.data('method');

    $.ajax({
        url: '/admin/modal/'+method,
        dataType: 'html',
        success: function (data) {
            $('#modal').show();
            $('#modal-container').html(data).slideDown(500);
            $('#modal-shadow').show(10).click(function () {
                $('#modal-container').slideUp(500, function () {
                    $('#modal-shadow,#modal').hide('500');
                });
            });
        }
    });
}

function addFieldForm(name){
    var cnt = parseInt($('#fields-count').val());
    var html = '<div class="form-filed">' +
        '<input type="hidden" name="type-' + cnt + '" value="' + name + '">' +
        '<div class="row">' +
        '<label for="title-' + cnt + '">Титул</label>' +
        '<input type="text" name="title-' + cnt + '" id="title-' + cnt + '">' +
        '</div>' +
        '<div class="row">' +
        '<label for="name-' + cnt + '">Название(name)</label>' +
        '<input type="text" name="name-' + cnt + '" id="name-' + cnt + '">' +
        '</div>';
    if (name === 'checkbox' || name === 'radio' || name === 'select'){
        html += '<div class="row">' +
            '<label for="int-' + cnt + '">Варианты</label>' +
            '<div class="variants">' +
            '<div class="row">' +
            '<input type="radio" name="selects-' + cnt + '" value="0">' +
            '<input type="text" name="variants-' + cnt + '[]">' +
            '</div>' +
            '<div class="add-variants" data-id="' + cnt + '">Еще</div>' +
            '</div>' +
            '</div>';
    }

    html += '<div class="row">' +
        '<label for="int-' + cnt + '">Integer</label>' +
        '<input type="radio" name="int-' + cnt + '" id="int-' + cnt + '" value="1">' +
        '<label for="int-' + cnt + '">Да</label>' +
        '<input type="radio" name="int-' + cnt + '" id="int-' + cnt + '-no" value="0" checked="checked">' +
        '<label for="int-' + cnt + '-no">Нет</label>' +
        '</div>' +
        '</div>';

    $('.fields-types').before(html);
    cnt++;
    $('#fields-count').val(cnt);
}

function addVariantsRow(id){
    var val = $('input[name="selects-' + id + '"]').length;
    var html = '<div class="row">' +
        '<input type="radio" name="selects-' + id + '" value="' + val + '">' +
        '<input type="text" name="variants-' + id + '[]">' +
        '</div>';
    $('.add-variants[data-id="' + id + '"]').before(html);
}