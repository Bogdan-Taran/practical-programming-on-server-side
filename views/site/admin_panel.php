<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Decan</title>
</head>
<body>
<main>
    <h1>Админ-панель: управление пользователями</h1>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>ФИО</th>
            <th>Логин</th>
            <th>Роль</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user->user_id ?></td>
                <td><?= $user->lastname ?> <?= $user->firstname ?> <?= $user->patronymic ?></td>
                <td><?= $user->login ?></td>
                <td><?= $user->role->role_name ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</main>
</body>
</html>