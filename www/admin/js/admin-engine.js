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
    modal.on('click', '.toggle-form-field,.form-field .title', function () {
        $(this).parent().find('.form-rows').slideToggle();

        var i = $(this).parent().find('.toggle-form-field i');
        if(i.hasClass('fa-minus')){
            i.removeClass('fa-minus');
            i.addClass('fa-plus');
        } else{
            i.removeClass('fa-plus');
            i.addClass('fa-minus');
        }
    });
    modal.on('click', '.del-form-field,.del-variants', function () {
        removeParent($(this));
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
        dataType: 'json',
        success: function (data) {
            $('#modal').show();
            var container = $('#modal-container');
            container.find('.context').html(data['context']);
            container.find('.modal-title').html(data['title']);
            container.slideDown(500);
            $('#modal-shadow,#close').show(10).click(function () {
                $('#modal-container').slideUp(500);
                $('#modal-shadow,#modal').fadeOut(700);
            });
        }
    }, 'json');
}

function addFieldForm(name){
    var selector = $('#fields-count');
    var cnt = parseInt(selector.val());
    var html = '<div class="form-field" data-id="' + cnt + '" style="display: none">' +
        '<div class="del-form-field"><i class="fa fa-times"></i></div>' +
        '<div class="toggle-form-field"><i class="fa fa-plus"></i></div>' +
        '<div class="title">Блок поля ' + cnt + '</div>' +
        '<div class="form-rows" style="display: none">' +
        '<input type="hidden" name="cnt[]" value="1">' +
        '<input type="hidden" name="type-' + cnt + '" value="' + name + '">' +
        '<div class="row">' +
        '<label for="title-' + cnt + '" class="row-item">Титул</label>' +
        '<div class="row-item">' +
        '<input class="in in-text" type="text" name="title-' + cnt + '" id="title-' + cnt + '">' +
        '</div>' +
        '</div>' +
        '<div class="row">' +
        '<label for="name-' + cnt + '" class="row-item">Название(name)</label>' +
        '<div class="row-item">' +
        '<input class="in in-text" type="text" name="name-' + cnt + '" id="name-' + cnt + '">' +
        '</div>' +
        '</div>';
    if (name === 'checkbox' || name === 'radio' || name === 'select'){
        html += '<div class="row">' +
            '<label for="int-' + cnt + '" class="row-item">Варианты</label>' +
            '<div class="row-item">' +
            '<div class="row-variants">' +
            '<input class="in-radio" type="radio" name="selects-' + cnt + '" value="0">' +
            '<input class="in in-text" type="text" name="variants-' + cnt + '[]">' +
            '</div>' +
            '<div class="add-variants btn btn-green btn-small" data-id="' + cnt + '">' +
            'Еще <i class="fa fa-plus"></i>' +
            '</div>' +
            '</div>' +
            '</div>';
    }

    html += '<div class="row">' +
        '<label class="row-item">Integer</label>' +
        '<div class="row-item">' +
        '<div class="row-variants">' +
        '<input class="in-radio" type="radio" name="int-' + cnt + '" id="int-' + cnt + '" value="1">' +
        '<label for="int-' + cnt + '">Да</label>' +
        '</div>' +
        '<div class="row-variants">' +
        '<input class="in-radio" type="radio" name="int-' + cnt + '" id="int-' + cnt + '-no" value="0" checked="checked">' +
        '<label for="int-' + cnt + '-no">Нет</label>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="clear"></div>';

    $('.fields-types').before(html);
    $('.form-field[data-id="' + cnt + '"]').show(500);

    cnt++;
    selector.val(cnt);
}

function addVariantsRow(id){
    var val = $('input[name="selects-' + id + '"]').length;
    var html = '<div class="row-variants">' +
        '<input class="in-radio" type="radio" name="selects-' + id + '" value="' + val + '">' +
        '<input class="in in-text" type="text" name="variants-' + id + '[]">' +
        '<div class="del-variants"><i class="fa fa-times"></i></div>' +
        '</div>';
    $('.add-variants[data-id="' + id + '"]').before(html);
}

function removeParent(elem){
    $(elem).parent().hide(500, function () {
        $(this).remove();
    });
}