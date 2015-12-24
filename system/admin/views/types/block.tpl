<div class="view_type">
    <form action="/admin/block/{action}Block" method="post" class="ajax-form" enctype="multipart/form-data">
        <input type="hidden" name="id" id="block_id" value="{id_value}">
        
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
            <label for="block_side" class="row-item">Сторона</label>

            <div class="row-item">
                <select class="in in-select" name="block_side" id="block_side">
					<option value="header" {side_0_value}>header</option>
					<option value="left" {side_1_value}>left</option>
					<option value="center" {side_2_value}>center</option>
					<option value="right" {side_3_value}>right</option>
					<option value="footer" {side_4_value}>footer</option>
                </select>
            </div>
        </div>
        <div class="row">
            <label for="block_text" class="row-item">Текст</label>

            <div class="row-item">
                <textarea class="in in-area" name="block_text" id="block_text">{text_value}</textarea>
            </div>
        </div>
        <div class="row">
            <label class="row-item">Использовать текст</label>

            <div class="row-item">
				<div class="row-variants">
					<input type="radio" name="block_is_text" value="Да" {is_text_0_value}
						   id="block_is_text_0" class="in-radio">
					<label for="block_is_text_0">
						Да
					</label>
				</div>
				<div class="row-variants">
					<input type="radio" name="block_is_text" value="Нет" {is_text_1_value}
						   id="block_is_text_1" class="in-radio">
					<label for="block_is_text_1">
						Нет
					</label>
				</div>
            </div>
        </div>

        <div class="row">
            <input type="submit" value="Отправить" class="btn btn-green">
        </div>
    </form>
</div>