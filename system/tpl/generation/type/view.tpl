<div class="view_type">{formFile}
    <form action="/admin/{name}/{action}{class_name}/ajax" method="post" class="ajax-form" enctype="multipart/form-data">
        <input type="hidden" name="id" id="{name}_id" value="{id_value}">
        {seo}
{tree}

{fields}
        <div class="row">
            <input type="submit" value="Отправить" class="btn btn-green">
        </div>
    </form>
    <div id="mess-result-info" class="msg-window" style="display: none"></div>
</div>