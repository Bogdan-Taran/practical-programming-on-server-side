<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style_general.css">
    <link rel="stylesheet" href="/css/style_add_user.css">
    <title>Add user</title>
</head>
<body>
<main class="main-container-admin">
    <div>
        <form id="addUserForm" method="POST" action="/addStudent">
            <h1>Добавить студента</h1>
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

            <div class="student-fields">
                <div class="form-group">
                    <select id="group_id" name="group_id" required>
                        <option value="" disabled selected>Выберите группу</option>
                        <?php foreach ($groups as $group): ?>
                            <option value="<?php echo $group->group_name_id; ?>" <?= (($_POST['group_id'] ?? '') == $group->group_name_id) ? 'selected' : '' ?>><?php echo $group->group_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="group_id">Группа:</label>
                </div>
                <div class="form-group">
                    <select id="specialization_id" name="specialization_id" required>
                        <option value="" disabled selected>Выберите специализацию</option>
                        <?php foreach ($specializations as $specialization): ?>
                            <option value="<?php echo $specialization->specialization_id; ?>" <?= (($_POST['specialization_id'] ?? '') == $specialization->specialization_id) ? 'selected' : '' ?>><?php echo $specialization->specialization_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="specialization_id">Специализация:</label>
                </div>
                <div class="form-group">
                    <select id="scientific_supervisor_id" name="scientific_supervisor_id" required>
                        <option value="" disabled selected>Выберите руководителя</option>
                        <?php foreach ($supervisors as $supervisor): ?>
                            <option value="<?php echo $supervisor->user_id; ?>" <?= (($_POST['scientific_supervisor_id'] ?? '') == $supervisor->user_id) ? 'selected' : '' ?>><?php echo $supervisor->lastname . ' ' . $supervisor->firstname . ' ' . $supervisor->patronymic; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="scientific_supervisor_id">Научный руководитель:</label>
                </div>
            </div>
            <?php if (!empty($errors)): ?>
                <div class="error-container">
                    <p><strong>Ошибки валидации:</strong></p>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <?php if(!empty($error)): ?><li><?php echo htmlspecialchars($error); ?></li><?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <button type="submit">Добавить</button>
        </form>

    </div>
</main>
</body>
</html>
