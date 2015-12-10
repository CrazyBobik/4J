<div class="view_type">
    <form action="/admin/block/updateBlock" method="post" class="ajax-form" enctype="multipart/form-data">
        <input type="hidden" name="id" id="block_id" value="{id_value}">
        

        <div class="row">
            <label for="block_side">Сторона</label>
            <select name="side" id="block_side">
				<option value="header" {side_0_value}>header</option>
				<option value="left" {side_1_value}>left</option>
				<option value="center" {side_2_value}>center</option>
				<option value="right" {side_3_value}>right</option>
				<option value="footer" {side_4_value}>footer</option>
			</select>
        </div>
        <div class="row">
            <label for="block_text">Текст</label>
            <textarea id="block_text" name="text"
					  class="text-redactor">{text_value}</textarea>
        </div>
        <div class="row">
            <label for="block_is_text">Использовать текст</label>
            <input type="radio" name="is_text" value="Нет"
				   {is_text_0_value} id="block_is_text_0">
			<label for="block_is_text_0">
				Нет
			</label>
			<input type="radio" name="is_text" value="Да"
				   {is_text_1_value} id="block_is_text_1">
			<label for="block_is_text_1">
				Да
			</label>
			
        </div>

        <div class="row">
            <input type="submit" value="Сохранить">
        </div>
    </form>
</div>