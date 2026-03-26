<h2>Регистрация нового пользователя</h2>
<h3><?= $message ?? ''; ?></h3>

<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $field => $fieldErrors): ?>
            <?php foreach ($fieldErrors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post">
    <label>Имя <input type="text" name="name"></label>
    <label>Логин <input type="text" name="login"></label>
    <label>Пароль <input type="password" name="password"></label>
    <button>Зарегистрироваться</button>
</form>
