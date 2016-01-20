<div class="view_type">
    <form action="/admin/{name}/{action}{class_name}" method="post" class="ajax-form" enctype="multipart/form-data">
        <input type="hidden" name="ajax" value="1">
        <input type="hidden" name="id" id="{name}_id" value="{id_value}">
        {seo}
{tree}

{fields}
        <div class="row">
            <input type="submit" value="Отправить" class="btn btn-green">
        </div>
    </form>
    <div id="mess-result-info" style="display: none">
        <div id="mess-result-text"></div>
    </div>
</div>