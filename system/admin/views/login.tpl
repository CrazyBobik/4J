<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <script src="/user/js/jquery-2.1.1.min.js"></script>
    <script src="/user/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="/user/js/jquery.form.min.js"></script>
    <script src="/admin/js/ajax.js"></script>

    <link href="/admin/css/login.css" type="text/css" rel="stylesheet">
</head>
<body>
<form class="ajax-form" action="/ajax/admin/login" method="post">
    <div class="logo">Admin 4J</div>
    <div class="container">
        <input type="text" name="name" placeholder="Имя">
        <input type="password" name="pass" placeholder="Пароль">

        <div id="mess-result-info" class="msg-window" style="display: none"></div>
    </div>

    <input type="submit" value="Войти">
</form>
</body>
</html>