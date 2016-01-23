<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <script src="/user/js/jquery-2.1.1.min.js" type="text/javascript"></script>
    <script src="/user/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
    <script src="/user/js/jquery.form.min.js" type="text/javascript"></script>
    <script src="/admin/js/admin-engine.js" type="text/javascript"></script>
    <script src="/admin/js/admin-menu.js" type="text/javascript"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="/admin/css/style.css">
    <link rel="stylesheet" href="/admin/css/modal.css">
    <link rel="stylesheet" href="/admin/css/form.css">
    <link rel="stylesheet" href="/admin/css/menu.css">
    <link rel="stylesheet" href="/admin/css/colors/blue.css">
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
        <a href="/admin" class="logo float-left">
            <div class="logo-mini">
                <b>A</b>4J
            </div>

            <div class="logo-lg">
                <b>Admin</b>4J
            </div>
        </a>

        <div class="head-bar">
            <div class="main-menu-toggle float-left">
                <i class="fa fa-bars"></i>
            </div>

            <div class="side-bar float-right">
                <div class="side-bar-item dropdown-hover">
                    <img class="user-logo" src="" alt="">
                    Admin
                </div>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="/admin/exit">
                        <i class="fa fa-sign-out float-right"></i>
                        Exit
                    </a>
                </div>

                <div class="side-bar-item toggle-config">
                    <i class="fa fa-cog"></i>
                </div>
            </div>
        </div>
        <!-- {header} -->
    </header>
    <nav id="main-menu">
        {left}
    </nav>
    <main id="center">
        {center}
    </main>
    <div id="settings">
        {right}
    </div>
</div>
<footer id="footer">
    {footer}
</footer>
</body>
</html>