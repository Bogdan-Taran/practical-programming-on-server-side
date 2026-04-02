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

    <div id="popup-message" class="popup <?= isset($message) && !isset($error) ? 'show success' : '' ?> <?= isset($error) ? 'show error' : '' ?>">
        <?= $message ?? '' ?>
    </div>

    <form method="post">
        <h1>Авторизация</h1>
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <div class="form-group">
            <input type="text" name="login" placeholder=" " required>
            <label>Логин</label>
        </div>
        <div class="form-group">
            <input type="password" name="password" placeholder=" " required>
            <label>Пароль</label>
        </div>
        <button>Войти</button>
        <p>Ещё нет аккаунта? <a href="<?= app()->route->getUrl('/signup') ?>">Зарегистрироваться</a></p>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const popup = document.getElementById('popup-message');
        if (popup && popup.classList.contains('show')) {
            // Если это сообщение об успехе, скрыть через 3 секунды
            if (popup.classList.contains('success')) {
                setTimeout(() => {
                    popup.classList.remove('show');
                }, 3000);
            }if (popup.classList.contains('error')) {
                setTimeout(() => {
                    popup.classList.remove('show');
                }, 3000);
            }
        }
    });
</script>
</body>
</html>
