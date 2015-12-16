<div class="view_type">
    <form action="/admin/block/updateBlock" method="post" class="ajax-form" enctype="multipart/form-data">
        <input type="hidden" name="id" id="block_id" value="{id_value}">
        

        <div class="row">
            <label class="row-item">Сторона</label>

            <div class="row-item">
				<div class="row-variants">
					<input type="checkbox" name="side[]" value="header" {side_0_value}
					 	   id="block_side_0" class="in-radio">
					<label for="block_side_0">
						header
					</label>
				</div>
				<div class="row-variants">
					<input type="checkbox" name="side[]" value="left" {side_1_value}
					 	   id="block_side_1" class="in-radio">
					<label for="block_side_1">
						left
					</label>
				</div>
				<div class="row-variants">
					<input type="checkbox" name="side[]" value="center" {side_2_value}
					 	   id="block_side_2" class="in-radio">
					<label for="block_side_2">
						center
					</label>
				</div>
				<div class="row-variants">
					<input type="checkbox" name="side[]" value="right" {side_3_value}
					 	   id="block_side_3" class="in-radio">
					<label for="block_side_3">
						right
					</label>
				</div>
				<div class="row-variants">
					<input type="checkbox" name="side[]" value="footer" {side_4_value}
					 	   id="block_side_4" class="in-radio">
					<label for="block_side_4">
						footer
					</label>
				</div>
            </div>
        </div>
        <div class="row">
            <label for="block_text" class="row-item">Текст</label>

            <div class="row-item">
                <textarea class="in in-area" name="block_text" id="block_text">{text_value}</textarea>
            </div>
        </div>
        <label class="row-item">Использовать текст</label>

<div class="row-item">
    
</div>
        <div class="row">
            <input type="submit" value="Отправить" class="btn btn-green">
        </div>
    </form>
</div>