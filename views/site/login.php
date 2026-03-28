<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style_general.css">
    <link rel="stylesheet" href="/css/style_login.css">
    <title>Авторизация</title>
</head>
<body>
<div class="form-container">



    <?php if (!app()->auth::check()): ?>
        <form method="post">
            <h1>Авторизация</h1>
            <div class="form-group">
                <input type="text" name="login" placeholder=" ">
                <label>Логин</label>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder=" ">
                <label>Пароль</label>
            </div>
            <button>Войти</button>
            <h3 class="message"><?= $message ?? ''; ?></h3>
            <p>Ещё нет аккаунта? <a href="<?= app()->route->getUrl('/signup') ?>">Зарегистрироваться</a></p>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
