<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style_general.css">
    <link rel="stylesheet" href="/css/style_admin_panel.css">
    <link rel="stylesheet" href="/css/style_scientific_publications.css">
    <title>Научные публикации</title>
</head>
<body>

<div id="add_scientific_publications_container" class="add_scientific_publications_container" hidden="hidden">
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

        <button id="add_scientific_publications_button" type="submit">Добавить</button>
    </form>
</div>


<div class="scientific-publications-container">
    <h1>Научные публикации</h1>
    <button id="toggle_add_scientific_publication_form" class="add-scientific-publication-button">+ Добавить научную публикацию</button>
    <table>
        <thead>
        <tr>
            <th>Название публикации</th>
            <th>Издание</th>
            <th>Дата публикации</th>
            <th>Студент</th>
            <th>Индекс</th>
        </tr>
        </thead>
        <?php if (empty($scientific_publications)): ?>
            <tbody>
            <tr>
                <td colspan="5">Нет научных публикаций</td>
            </tr>
            </tbody>
        <?php else: ?>
            <tbody>
            <?php foreach ($scientific_publications as $scientific_publication): ?>
                <tr>
                    <td><?= $scientific_publication->name ?></td>
                    <td><?= $scientific_publication->edition->edition_name ?></td>
                    <td><?= date('d.m.Y', strtotime($scientific_publication->publication_date)) ?></td>
                    <td><?= $scientific_publication->student->lastname ?> <?= $scientific_publication->student->firstname ?></td>
                    <td><?= $scientific_publication->index->index_name ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        <?php endif; ?>
    </table>
</div>
<script>
    const addScntPubCont = document.getElementById('add_scientific_publications_container');
    const toggleAddScntPubFormButton = document.getElementById('toggle_add_scientific_publication_form');

    toggleAddScntPubFormButton.addEventListener('click', function() {
        if (addScntPubCont.hidden) {
            addScntPubCont.hidden = false;
        } else {
            addScntPubCont.hidden = true;
        }
    });

    document.addEventListener('click', function(event) {
        if (!addScntPubCont.contains(event.target) && !toggleAddScntPubFormButton.contains(event.target) && !addScntPubCont.hidden) {
            addScntPubCont.hidden = true;
        }
    });
</script>
</body>
</html>
