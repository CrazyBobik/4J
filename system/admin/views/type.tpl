<form action="/admin/type/{action}Type" class="ajax-form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" id="type_id" value="{id_value}">
    <div class="row">
        <label for="type-title" class="row-item">Титул</label>

        <div class="row-item">
            <input class="in in-text" type="text" name="title" id="type-title" value="{title_value}">
        </div>
    </div>
    <div class="row">
        <label for="type-name" class="row-item">Название (name)</label>

        <div class="row-item">
            <input class="in in-text" type="text" name="name" id="type-name" value="{name_value}">
        </div>
    </div>
    <div class="row">
        <label class="row-item">SEO</label>

        <div class="row-item">
            <div class="row-variants">
                <input class="in-radio" type="checkbox" name="seo" value="1" id="type-seo" {seo_value}>
                <label for="type-seo">Добавить СЕО</label>
            </div>
        </div>
    </div>

    <div class="fields">{fields}
        <div class="fields-types">
            <div class="title">Добавить поле:</div>

            <div class="one-type btn btn-green btn-auto" data-type="text">
                Текст
                <i class="fa fa-plus"></i>
            </div>
            <div class="one-type btn btn-green btn-auto" data-type="textarea">
                Текстовое поле
                <i class="fa fa-plus"></i>
            </div>
            <div class="one-type btn btn-green btn-auto" data-type="checkbox">
                Чекбокс
                <i class="fa fa-plus"></i>
            </div>
            <div class="one-type btn btn-green btn-auto" data-type="select">
                Селект
                <i class="fa fa-plus"></i>
            </div>
            <div class="one-type btn btn-green btn-auto" data-type="radio">
                Радиобокс
                <i class="fa fa-plus"></i>
            </div>
            <div class="one-type btn btn-green btn-auto" data-type="file">
                Файл
                <i class="fa fa-plus"></i>
            </div>
            <div class="one-type btn btn-green btn-auto data-type="hidden">
                Скрытое поле
                <i class="fa fa-plus"></i>
            </div>
        </div>

        <input type="hidden" name="fields-count" id="fields-count" value="0">
    </div>

    <div class="row">
        <input type="submit" value="Сохранить" class="btn btn-green">
    </div>
</form>
<div id="mess-result-info" style="display: none">
    <div id="mess-result-text"></div>
</div>