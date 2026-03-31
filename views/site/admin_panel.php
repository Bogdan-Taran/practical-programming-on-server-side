<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style_general.css">
    <link rel="stylesheet" href="/css/style_admin_panel.css">
    <title>Decan</title>
</head>
<body>
<main class="main-container-admin">
    <div id="popup-message" class="popup <?= isset($message) && !isset($error) ? 'show success' : '' ?> <?= isset($error) && $error ? 'show error' : '' ?>">
        <?= $message ?? '' ?>
    </div>
    <div class="add-user-container">
<!--        <button class="add-user-button" id="addUserButton">+ Добавить пользователя</button>-->
        <a class="add-user-link" href="<?= app()->route->getUrl('/addScientificSupervisor') ?>">+ Добавить научрука</a>
        <a class="add-user-link" href="<?= app()->route->getUrl('/addStudent') ?>">+ Добавить студента</a>
    </div>
    <div class="admin-panel-container">
        <h1>Админ-панель: управление пользователями</h1>
        <p>Здесь будут сортировки (возможно)</p>
        <table>
            <thead>
            <tr>
                <th>ФИО</th>
                <th>Логин</th>
                <th>Роль</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user->lastname ?> <?= $user->firstname ?> <?= $user->patronymic ?></td>
                    <td><?= $user->login ?></td>
                    <td><?= $user->role->role_name ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>


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
