/**
 * Created by CrazyBobik on 13.10.2015.
 */
$(function () {
    var modal = $('#modal');
    var center = $('#center');

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
                    clazz = 'critical';
                } else {
                    clazz = 'success';
                    if (result.clear === undefined || result.clear == true){
                        form.clearForm();
                    }
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

    center.on('change', '#select-type', function () {
        var val = $(this).val();

        $.ajax({
            url: '/admin/type/getType/ajax',
            method: 'POST',
            data: {
                id: val
            },
            dataType: 'html',
            success: function (html) {
                changeCenter(html);
            }
        }, 'html');
    });
    center.on('click', '.delete-type', function () {
        if(confirm('Удалить тип?')){
            var val = $('#select-type').val();

            $.ajax({
                url: '/admin/type/deleteType/ajax',
                method: 'POST',
                data: {
                    id: val
                },
                dataType: 'html',
                success: function (html) {
                    addType();
                }
            }, 'html');
        }
    });

    center.on('click', '.one-type', function(){
        addFieldForm($(this).data('type'));
    });
    center.on('click', '.add-variants', function(){
        addVariantsRow($(this).data('id'));
    });
    center.on('click', '.toggle-form-field,.form-field .title', function () {
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
    center.on('click', '.del-form-field,.del-variants', function () {
        removeParent($(this));
    });
    center.on('keyup', '.form-field .form-rows .row input', function () {
        var parent = $(this).parent().parent().parent().parent();
        var id = parent.data('id');
        var val = $('#title-' + id).val();
        parent.find('.title').text(val);
    });

    center.on('change', '#select-type-leaf', function () {
        $('#add-tree-leaf-form').slideUp(500);
        var val = $(this).val();

        if(val !== '') {
            $.ajax({
                url: '/admin/' + val + '/get' + val + '/ajax',
                method: 'POST',
                data: {
                    pid: $('#tree-leaf-pid').val()
                },
                dataType: 'html',
                success: function (html) {
                    setTimeout(function () {
                        $('#add-tree-leaf-form').html(html).slideDown(500);
                        initTinyMCE();
                    }, 500);
                }
            }, 'html');
        }
    });
    center.on('click', '.delete-img', function () {
        var name = $(this).data('name');
        $('#' + name).val('');
        $('.prev-img[data-name="' + name + '"]').slideUp(300);
    });

    $('.lang-btn').on('click', function () {
        var lang = $(this).data('lang');

        $.ajax({
            url: '/admin/helpers/changeLang/ajax',
            method: 'POST',
            data:{
                lang: lang
            },
            success: function (result) {
                if(result) {
                    location.reload();
                }
            }
        });
    });

    center.on('click', '.one-img.choice', function(){
        var val = $(this).find('img').attr('src');
        val = '<img src="' + val + '">';
        tinymce.activeEditor.execCommand('mceInsertContent', false, val);
    });
    center.on('click', '.one-img.upload', function(){
        $('#upload-new-file').click();
    });

    center.on('click', '.del-img', function () {
        var elem = $(this);
        var name = $(this).data('name');
        $.ajax({
            url: '/admin/choicefile/removeFile/ajax',
            method: 'POST',
            data: {name: name},
            success: function () {
                elem.parent().slideUp(300, function () {
                    $(this).remove();
                });
            }
        })
    });

    initTinyMCE();
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

function modalOpen(elem){
    var method = elem.data('method');

    $.ajax({
        url: '/admin/modal/' + method + '/ajax',
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

function changeCenter(html){
    $('#center').fadeOut(300, function () {
        $(this).html(html).fadeIn(300);
        initTinyMCE();
    });
}

function reloadChoiceFile(){
    $.ajax({
        url: '/admin/choicefile/genHTML/ajax',
        success: function (html) {
            $('.choice-img').fadeOut(300, function () {
                $(this).html(html).fadeIn(300);
            });
        }
    });
}

function reloadGalleryFile(){
    $.ajax({
        url: '/admin/choicefile/genGalleryHTML/ajax',
        success: function (html) {
            changeCenter(html);
        }
    });
}

function initTinyMCE(){
    var selector = '.tinymce textarea';

    tinymce.init({
        selector: selector,
        plugins: 'autolink autoresize link image lists preview table code wordcount',
        autoresize_min_height: 250,
        autoresize_max_height: 500
    });
    $(selector).each(function(){
        $(this).closest('.row').find('.row-item').css('width', '100%');
    });
}