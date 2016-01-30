    <form class="ajax-form" action="/admin/choicefile/fileUpload" method="post" enctype="multipart/form-data">
        <input id="upload-new-file" type="file" name="file" style="display: none"
               onchange="$(this).closest('form').submit();">
    </form>