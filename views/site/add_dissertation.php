<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style_general.css">
    <link rel="stylesheet" href="/css/style_add_dissertation.css">
    <title>Добавить диссертацию</title>
</head>
<body>
<div class="add-dissertation-container">


    <?php if (!empty($message)): ?>
        <div class="success">
            <p><?php echo $message; ?></p>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= app()->route->getUrl('/addDissertation') ?>">
        <h1>Добавить диссертацию</h1>

        <div class="form-group">
            <input type="text" name="theme" required placeholder=" " value="<?= $_POST['theme'] ?? '' ?>">
            <label for="theme">Тема диссертации:</label>
        </div>

        <div class="form-group">
            <input type="date" name="approval_date" required placeholder=" " value="<?= $_POST['approval_date'] ?? '' ?>">
            <label for="approval_date">Дата защиты:</label>
        </div>

        <div class="form-group">
            <select id="dissertation_status_id" name="dissertation_status_id" required>
                <option value="" disabled selected>Выберите статус</option>
                <?php foreach ($statuses as $status): ?>
                    <option value="<?php echo $status->dissertation_status_id; ?>" ><?php echo $status->dissertation_status_name; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="dissertation_status_id">Статус:</label>
        </div>

        <div class="form-group">
            <select id="bak_speciality_id" name="bak_speciality_id" required>
                <option value="" disabled selected>Выберите специальность ВАК</option>
                <?php foreach ($bak_specialities as $bak_speciality): ?>
                    <option value="<?php echo $bak_speciality->bak_speciality_id; ?>" <?= (($_POST['bak_speciality_id'] ?? '') == $bak_speciality->bak_speciality_id) ? 'selected' : '' ?>><?php echo $bak_speciality->bak_speciality_name; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="bak_speciality_id">Специальность ВАК:</label>
        </div>

        <div class="form-group">
            <select id="student_id" name="student_id" required>
                <option value="" disabled selected>Выберите студента</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?php echo $student->student_id; ?>" <?= (($_POST['student_id'] ?? '') == $student->student_id) ? 'selected' : '' ?>><?php echo $student->lastname . ' ' . $student->firstname . ' ' . $student->patronymic; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="student_id">Студент:</label>
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

</body>
</html>
