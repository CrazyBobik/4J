<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <script src="/user/js/jquery-2.1.1.min.js" type="text/javascript"></script>
    <script src="/user/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
    <script src="/user/js/jquery.form.min.js" type="text/javascript"></script>
    <script src="/admin/js/admin-engine.js" type="text/javascript"></script>

    <link href="/admin/css/style.css" type="text/css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="" width="200px" height="100px">
        </div>

        <form class="ajax-form" action="/ajax/admin/login" method="post">
            <input type="text" name="name" placeholder="Имя">
            <input type="password" name="pass" placeholder="Пароль">

            <input type="submit" value="Войти">
        </form>

        <div id="mess-result-info" class="msg-window" style="display: none"></div>
    </div>
</body>
</html>