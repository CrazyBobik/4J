<div class="view_type">
    <form action="/admin/item/{action}Item/ajax" method="post" class="ajax-form" enctype="multipart/form-data">
        <input type="hidden" name="id" id="item_id" value="{id_value}">
        
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


        <input type="hidden" value="{f_value}" name="item_f" id="item_f">

        <div class="row">
            <input type="submit" value="Отправить" class="btn btn-green">
        </div>
    </form>
    <div id="mess-result-info" style="display: none">
        <div id="mess-result-text"></div>
    </div>
</div>