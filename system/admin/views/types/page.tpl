<div class="view_type">
    <form action="/admin/page/{action}Page" method="post" class="ajax-form" enctype="multipart/form-data">
        <input type="hidden" name="id" id="page_id" value="{id_value}">
        <div class="seo_part">
			<div class="row">
				<label for="seo_title">SEO Титулка</label>
				<input type="text" value="{seo_title_value}" name="seo_title"
					   id="seo_title">
			</div>
			<div class="row">
				<label for="seo_keywords">SEO Ключи</label>
				<textarea name="seo_keywords" id="seo_keywords">{seo_keywords_value}</textarea>
			</div>
			<div class="row">
				<label for="seo_description">SEO Описание</label>
				<textarea name="seo_description" id="seo_description">{seo_description_value}</textarea>
			</div>
		</div>
        <div class="row">
            <label for="tree_title" class="row-item">Титулка в дереве</label>

            <div class="row-item">
                <input class="in in-text" type="text" name="title" value="{tree_title}" id="tree_title">
            </div>
        </div>
        <div class="row">
            <label for="tree_name" class="row-item">Название(name) в дереве</label>

            <div class="row-item">
                <input class="in in-text" type="text" name="name" value="{tree_name}" id="tree_name">
            </div>
        </div>
        <input type="hidden" value="{tree_pid}" name="pid" id="tree_pid">



        <div class="row">
            <input type="submit" value="Отправить" class="btn btn-green">
        </div>
    </form>
</div>