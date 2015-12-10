<form action="/admin/type/{action}Type" class="ajax-form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" id="type_id" value="{id_value}">
    <div class="row">
        <label for="type-title">Титул</label>
        <input type="text" name="title" id="type-title" value="{title_value}">
    </div>
    <div class="row">
        <label for="type-name">Название (name)</label>
        <input type="text" name="name" id="type-name" value="{name_value}">
    </div>
    <div class="row">
        <label for="type-seo">SEO</label>
        <input type="checkbox" name="seo" value="1" id="type-seo" {seo_value}>
    </div>

    <div class="fields">{fields}
        <div class="fields-types">
            <div class="one-type" data-type="text">Текст</div>
            <div class="one-type" data-type="textarea">Текстовое поле</div>
            <div class="one-type" data-type="checkbox">Чекбокс</div>
            <div class="one-type" data-type="select">Селект</div>
            <div class="one-type" data-type="radio">Радиобокс</div>
            <div class="one-type" data-type="file">Файл</div>
            <div class="one-type" data-type="hidden">Скрытое поле</div>
        </div>

        <input type="hidden" name="fields-count" id="fields-count" value="0">
    </div>

    <div class="row">
        <input type="submit" value="Сохранить">
    </div>
</form>
<div id="mess-result-info" style="display: none">
    <div id="mess-result-text"></div>
</div>