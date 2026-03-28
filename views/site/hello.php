<?php ?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
$user = app()->auth::user();
?>
<h1>Добро пожаловать, <?= $user->firstname ?>!</h1>

<?php
switch ($user->role_id) {
    case \Model\User::ROLE_ADMIN:
        echo "<p>Вы вошли как <strong>Администратор</strong>. Вам доступны все функции системы.</p>";
        break;
    case \Model\User::ROLE_SUPERVISOR:
        echo "<p>Вы вошли как <strong>Научный руководитель</strong>. Вы можете управлять своими аспирантами.</p>";
        break;
    case \Model\User::ROLE_RESEARCHER:
        echo "<p>Вы вошли как <strong>Научный сотрудник</strong>.</p>";
        break;
}
?>
</body>
</html>
