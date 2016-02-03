<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <script src="/user/js/jquery-2.1.1.min.js"></script>
    <script src="/user/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="/user/js/jquery.form.min.js"></script>
    <script src="/admin/js/admin-engine.js"></script>
    <script src="/admin/js/admin-menu.js"></script>
    <script src="/admin/js/admin-configs.js"></script>
    <script src="/admin/js/cookie.js"></script>

    <link rel="stylesheet" href="/admin/plugins/font-awesome-4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/admin/plugins/messages/msg.css">

    <link rel="stylesheet" href="/admin/css/style.css">
    <link rel="stylesheet" href="/admin/css/modal.css">
    <link rel="stylesheet" href="/admin/css/form.css">
    <link rel="stylesheet" href="/admin/css/menu.css">
    <link rel="stylesheet" href="/admin/css/colors/{style}.css">


    <script src='/admin/plugins/tinymce/js/tinymce/tinymce.min.js'></script>
    <script src="/admin/plugins/tinymce/js/tinymce/langs/uk.js"></script>
</head>
<body>
<div id="modal">
    <div id="modal-shadow"></div>
    <div id="modal-container">
        <div id="close">
            <i class="fa fa-times fa-2x"></i>
        </div>
        <div class="modal-title"></div>
        <div class="context"></div>
    </div>
</div>

<div id="container">
    <header id="head">
        {header}
    </header>
    <div class="wrapper">
        <div id="main-menu-bg"></div>
        <nav id="main-menu" class="float-left">
            {left}
        </nav>
        <main id="center">
            {center}
        </main>
        <div id="settings">
            {right}
        </div>
        <div class="clear"></div>
    </div>
</div>
<footer id="footer">
    {footer}
</footer>
</body>
</html>