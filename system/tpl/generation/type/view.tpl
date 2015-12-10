<div class="view_type">
    <form action="/admin/{name}/update{class_name}" method="post" class="ajax-form" enctype="multipart/form-data">
        <input type="hidden" name="id" id="{name}_id" value="{id_value}">
        {seo}

{fields}
        <div class="row">
            <input type="submit" value="Сохранить">
        </div>
    </form>
</div>