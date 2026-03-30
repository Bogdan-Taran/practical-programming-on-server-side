<div id="addUserModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Добавить пользователя</h2>

        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

<!--        --><?php //if ($success): ?>
<!--            <div class="success">-->
<!--                <p>Пользователь успешно добавлен!</p>-->
<!--            </div>-->
<!--        --><?php //endif; ?>

        <form id="addUserForm" method="post" action="/admin/addUser">
            <div class="form-group">
                <label for="role_id">Роль:</label>
                <select id="role_id" name="role_id" required>
                    <option value="">Выберите роль</option>
                    <?php foreach ($users_roles as $role): ?>
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
</div>

<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
    }
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<script>
    document.getElementById('role_id').addEventListener('change', function () {
        var supervisorFields = document.getElementById('supervisor-fields');
        var studentFields = document.getElementById('student-fields');
        if (this.value == 1) { // Научный руководитель
            supervisorFields.style.display = 'block';
            studentFields.style.display = 'none';
        } else if (this.value == 2) { // Аспирант
            supervisorFields.style.display = 'none';
            studentFields.style.display = 'block';
        } else {
            supervisorFields.style.display = 'none';
            studentFields.style.display = 'none';
        }
    });
</script>
