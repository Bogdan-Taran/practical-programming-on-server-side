<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style_general.css">
    <link rel="stylesheet" href="/css/style_scientific_publications.css">
    <title>Научные публикации</title>
</head>
<body>
<div class="add_scientific_publications_container" hidden="hidden">
    <form method="post" action="<?= app()->route->getUrl('/addScientificPublication') ?>">
        <h1>Добавить научную публикацию</h1>
        <div class="form-group">
            <input type="text" name="name" required placeholder=" " value="<?= $_POST['name'] ?? '' ?>">
            <label for="name">Название научной публикации:</label>
        </div>

        <div class="form-group">
            <select id="edition_id" name="edition_id" required>
                <option value="" disabled selected>Выберите издание</option>
                <?php foreach ($editions as $edition): ?>
                    <option value="<?php echo $edition->edition_id; ?>"> <?= $edition->edition_name ?> </option>
                <?php endforeach; ?>
            </select>
            <label for="edition_id">Издание:</label>
        </div>

        <div class="form-group">
            <input type="date" name="publication_date" required placeholder=" "
                   value="<?= $_POST['publication_date'] ?? '' ?>">
            <label for="publication_date">Дата публикации:</label>
        </div>
        <div class="form-group">
            <select id="index_id" name="index_id" required>
                <option value="" disabled selected>Выберите индекс</option>
                <?php foreach ($indexes as $index): ?>
                    <option value="<?php echo $index->index_id; ?>"> <?= $index->index_name ?> </option>
                <?php endforeach; ?>
            </select>
            <label for="edition_id">Индекс:</label>
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

        <button type="submit">Добавить</button>
    </form>
</div>


<div class="scientific-publications-container">
    <h1>Научные публикации</h1>
    <a class="add-dissertations-link" href="<?= app()->route->getUrl('/addDissertation') ?>">+ Добавить диссертацию</a>
    <table>
        <thead>
        <tr>
            <th>Тема диссертации</th>
            <th>Дата защиты</th>
            <th>Статус</th>
            <th>Студент</th>
            <th>Специальность ВАК</th>
        </tr>
        </thead>
        <?php if (!empty($dissertations)): ?>
            <tbody>
            <?php foreach ($dissertations as $dissertation): ?>
                <tr>
                    <td><?= $dissertation->theme ?></td>
                    <td><?= date('d.m.Y', strtotime($dissertation->approval_date)) ?></td>
                    <td class="change-dissertation-status" data-dissertation-id="<?= $dissertation->dissertation_id ?>" data-current-status-id="<?= $dissertation->status->dissertation_status_id ?>"><?= $dissertation->status->dissertation_status_name ?></td>
                    <td><?= $dissertation->student->lastname ?> <?= $dissertation->student->firstname ?></td>
                    <td><?= $dissertation->bakSpeciality->bak_speciality_name ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        <?php else: ?>
            <tbody>
            <tr>
                <td colspan="5">Диссертаций нет</td>
            </tr>
            </tbody>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
