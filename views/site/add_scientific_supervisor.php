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
    <title>Add user</title>
</head>
<body>
<main class="main-container-admin">
<div>


        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
        <div class="success">
                        <p>Пользователь успешно добавлен!</p>
                   </div>
        <?php endif; ?>

        <form id="addUserForm" method="post" action="/admin/addUser">
            <h2>Добавить студента</h2>
            <div class="form-group">
                <label for="user_role_id">Роль:</label>
                <select id="user_role_id" name="user_role_id" required>
                    <option value="">Выберите роль</option>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?php echo $role->user_role_id; ?>"><?php echo $role->role_name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="login">Логин:</label>
                <input type="text" id="login" name="login" required>
            </div>

            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="firstname">Имя:</label>
                <input type="text" id="firstname" name="firstname" required>
            </div>

            <div class="form-group">
                <label for="lastname">Фамилия:</label>
                <input type="text" id="lastname" name="lastname" required>
            </div>

            <div class="form-group">
                <label for="patronymic">Отчество:</label>
                <input type="text" id="patronymic" name="patronymic" required>
            </div>

            <div id="supervisor-fields" style="display: none;">
                <div class="form-group">
                    <label for="academic_degree_id">Ученая степень:</label>
                    <select id="academic_degree_id" name="academic_degree_id">
                        <option value="">Выберите степень</option>
                        <?php foreach ($academic_degrees as $degree): ?>
                            <option value="<?php echo $degree->academic_degree_id; ?>"><?php echo $degree->academic_degree_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div id="student-fields" style="display: none;">
                <div class="form-group">
                    <label for="group_id">Группа:</label>
                    <select id="group_id" name="group_id">
                        <option value="">Выберите группу</option>
                        <?php foreach ($groups as $group): ?>
                            <option value="<?php echo $group->group_name_id; ?>"><?php echo $group->group_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="specialization_id">Специализация:</label>
                    <select id="specialization_id" name="specialization_id">
                        <option value="">Выберите специализацию</option>
                        <?php foreach ($specializations as $specialization): ?>
                            <option value="<?php echo $specialization->specialization_id; ?>"><?php echo $specialization->specialization_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="scientific_supervisor_id">Научный руководитель:</label>
                    <select id="scientific_supervisor_id" name="scientific_supervisor_id">
                        <option value="">Выберите руководителя</option>
                        <?php foreach ($supervisors as $supervisor): ?>
                            <option value="<?php echo $supervisor->user_id; ?>"><?php echo $supervisor->lastname . ' ' . $supervisor->firstname . ' ' . $supervisor->patronymic; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <button type="submit">Добавить</button>
        </form>

</div>
</main>
</body>
</html>




