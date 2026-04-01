<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style_add_user.css">
    <link rel="stylesheet" href="/css/style_general.css">
    <link rel="stylesheet" href="/css/style_admin_panel.css">
    <title>Добавить научного руководителя</title>
</head>
<body>
<main class="main-container-admin">
<div>
<!--    <div id="popup-message" class="popup --><?php //= isset($message) && !isset($error) ? 'show success' : '' ?><!-- --><?php //= isset($error) && $error ? 'show error' : '' ?><!--">-->
<!--        --><?php //= $message ?? '' ?>
<!--    </div>-->

        <form id="addSupervisorForm" method="post" action="/addScientificSupervisor">
            <h1>Добавить научного руководителя</h1>

            <div class="form-group">
                <input type="text" name="login" required placeholder=" " value="<?= $_POST['login'] ?? '' ?>">
                <label for="login">Логин:</label>
            </div>

            <div class="form-group">
                <input type="password" name="password" required placeholder=" ">
                <label for="password">Пароль:</label>
            </div>

            <div class="form-group">
                <input type="text" name="firstname" required placeholder=" " value="<?= $_POST['firstname'] ?? '' ?>">
                <label for="firstname">Имя:</label>
            </div>

            <div class="form-group">
                <input type="text" name="lastname" required placeholder=" " value="<?= $_POST['lastname'] ?? '' ?>">
                <label for="lastname">Фамилия:</label>
            </div>

            <div class="form-group">
                <input type="text" name="patronymic" required placeholder=" " value="<?= $_POST['patronymic'] ?? '' ?>">
                <label for="patronymic">Отчество:</label>
            </div>

            <div class="form-group">
                <select id="academic_degree_id" name="academic_degree_id" required>
                    <option value="" disabled selected>Выберите степень</option>
                    <?php foreach ($academic_degrees as $degree): ?>
                        <option value="<?php echo $degree->academic_degree_id; ?>" <?= (($_POST['academic_degree_id'] ?? '') == $degree->academic_degree_id) ? 'selected' : '' ?>><?php echo $degree->academic_degree_name; ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="academic_degree_id">Ученая степень:</label>
            </div>

            <button type="submit">Добавить</button>
        </form>

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
