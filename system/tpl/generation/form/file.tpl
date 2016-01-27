        <div class="row">
            <label for="{id}" class="row-item">{title}</label>

            <div class="row-item">
                <input type="file" name="{name}" value="{value}" id="{id}">
                <i class="fa fa-close del delete-img" data-name="{name}_old" title="Удалить файл"></i>
                <input id="{name}_old" type="hidden" name="{name}_old" value="{value}">
                <div class="prev-img" data-name="{name}_old">{prevImg{namePrev}}</div>
            </div>
        </div>
