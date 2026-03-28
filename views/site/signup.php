<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style_general.css">
    <title>Decan</title>
</head>
<body>
<div class="form-container">



<form method="post">
    <h1>Регистрация нового пользователя</h1>
    <h3 class="message"><?= $message ?? ''; ?></h3>
    <div class="form-group">
        <input type="text" required name="lastname" placeholder=" " value="<?= $_POST['lastname'] ?? '' ?>">
        <label>Фамилия</label>
    </div>
    <div class="form-group">
        <input type="text" required name="firstname" placeholder=" " value="<?= $_POST['firstname'] ?? '' ?>">
        <label>Имя</label>
    </div>
    <div class="form-group">
        <input type="text" name="patronymic" placeholder=" " value="<?= $_POST['patronymic'] ?? '' ?>">
        <label>Отчество</label>
    </div>
    <div class="form-group">
        <input type="text" required name="login" placeholder=" " value="<?= $_POST['login'] ?? '' ?>">
        <label>Логин</label>
    </div>
    <div class="form-group">
        <input type="password" required name="password" placeholder=" ">
        <label>Пароль</label>
    </div>
    <div class="form-group">
        <select name="role_id" required>
            <option value="" disabled selected></option>
            <option value="1">Руководитель</option>
            <option value="2">Научный сотрудник</option>
        </select>
        <label>Роль</label>
    </div>
    <div class="form-group">
        <select name="academic_degree_id" required>
            <option value="" disabled selected></option>
            <option value="1">Кандидат наук </option>
            <option value="2">Доктор наук</option>
            <option value="3">Доцент</option>
            <option value="3">Профессор</option>
        </select>
        <label>Ученая степень</label>
    </div>
    <?php if (!empty($errors)): ?>
        <ul class="errors">
            <?php foreach ($errors as $field => $fieldErrors): ?>
                <?php foreach ($fieldErrors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <button>Зарегистрироваться</button>

</form>
</div>
</body>
</html>
