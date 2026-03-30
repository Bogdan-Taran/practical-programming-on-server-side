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
    <div class="add-user-container">
        <button class="add-user-button" id="addUserButton">+ Добавить пользователя</button>
    </div>
    <div class="admin-panel-container">
        <h1>Админ-панель: управление пользователями</h1>
        <p>Здесь будут сортировки</p>
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

<?php include 'add_user.php'; ?>

<script>
    const addUserModal = document.getElementById('addUserModal');
    const addUserButton = document.getElementById('addUserButton');
    const closeButton = document.querySelector('.close');

    addUserButton.onclick = () => addUserModal.style.display = 'block';
    closeButton.onclick = () => addUserModal.style.display = 'none';

    window.onclick = (event) => {
        if (event.target === addUserModal) {
            addUserModal.style.display = 'none';
        }
    };
</script>
</body>
</html>
