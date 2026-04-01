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
<div id="popup-message" class="popup <?= isset($message) && !isset($error) ? 'show success' : '' ?> <?= isset($error) && $error ? 'show error' : '' ?>">
    <?= $message ?? '' ?>
</div>
<h1><?= $error ?></h1>

<div id="add_scientific_publications_container" class="add_scientific_publications_container" hidden="hidden">
    <form method="post" action="<?= app()->route->getUrl('/addScientificPublication') ?>">
        <h1>Добавить научную публикацию</h1>
        <div class="form-group">
            <input type="text" name="name" required placeholder=" " value="<?= $_POST['name'] ?? '' ?>">
            <label for="name">Название научной публикации:</label>
        </div>

        <div class="form-group">
            <select id="edition_id_add" name="edition_id" required>
                <option value="" disabled selected>Выберите издание</option>
                <?php foreach ($editions as $edition): ?>
                    <option value="<?php echo $edition->edition_id; ?>" <?= (($_POST['edition_id'] ?? '') == $edition->edition_id) ? 'selected' : '' ?>> <?= $edition->edition_name ?> </option>
                <?php endforeach; ?>
            </select>
            <label for="edition_id_add">Издание:</label>
        </div>

        <div class="form-group">
            <input type="date" name="publication_date" required placeholder=" "
                   value="<?= $_POST['publication_date'] ?? '' ?>">
            <label for="publication_date">Дата публикации:</label>
        </div>
        <div class="form-group">
            <select id="index_id_add" name="index_id" required>
                <option value="" disabled selected>Выберите индекс</option>
                <?php foreach ($indexes as $index): ?>
                    <option value="<?php echo $index->index_id; ?>" <?= (($_POST['index_id'] ?? '') == $index->index_id) ? 'selected' : '' ?>> <?= $index->index_name ?> </option>
                <?php endforeach; ?>
            </select>
            <label for="index_id_add">Индекс:</label>
        </div>

        <div class="form-group">
            <select id="student_id_add" name="student_id" required>
                <option value="" disabled selected>Выберите студента</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?php echo $student->student_id; ?>" <?= (($_POST['student_id'] ?? '') == $student->student_id) ? 'selected' : '' ?>><?php echo $student->lastname . ' ' . $student->firstname . ' ' . $student->patronymic; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="student_id_add">Студент:</label>
        </div>

        <button type="submit">Добавить</button>
    </form>
</div>


<div id="change_scientific_publications_container" class="add_scientific_publications_container" hidden="hidden">
    <form method="post" action="<?= app()->route->getUrl('/updateScientificPublication') ?>">
        <h1>Изменить научную публикацию</h1>
        <input type="hidden" name="scientific_publication_id" id="change_scientific_publication_id" value="">
        <div class="form-group">
            <input type="text" name="name" id="change_name" required placeholder="">
            <label for="change_name">Название научной публикации:</label>
        </div>

        <div class="form-group">
            <select id="edition_id_change" name="edition_id" required>
                <option value="" disabled selected>Выберите издание</option>
                <?php foreach ($editions as $edition): ?>
                    <option value="<?php echo $edition->edition_id; ?>"> <?= $edition->edition_name ?> </option>
                <?php endforeach; ?>
            </select>
            <label for="edition_id_change">Издание:</label>
        </div>

        <div class="form-group">
            <input type="date" name="publication_date" id="change_publication_date" required placeholder=" ">
            <label for="change_publication_date">Дата публикации:</label>
        </div>
        <div class="form-group">
            <select id="index_id_change" name="index_id" required>
                <option value="" disabled selected>Выберите индекс</option>
                <?php foreach ($indexes as $index): ?>
                    <option value="<?php echo $index->index_id; ?>"> <?= $index->index_name ?> </option>
                <?php endforeach; ?>
            </select>
            <label for="index_id_change">Индекс:</label>
        </div>

        <div class="form-group">
            <select id="student_id_change" name="student_id" required>
                <option value="" disabled selected>Выберите студента</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?php echo $student->student_id; ?>"><?php echo $student->lastname . ' ' . $student->firstname . ' ' . $student->patronymic; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="student_id_change">Студент:</label>
        </div>

        <button type="submit">Сохранить изменения</button>
    </form>
</div>

<div id="delete_scientific_publications_container" class="add_scientific_publications_container" hidden="hidden">
    <form method="post" action="<?= app()->route->getUrl('/deleteScientificPublication') ?>">
        <h1>Удалить научную публикацию</h1>
        <input type="hidden" name="scientific_publication_id" id="delete_scientific_publication_id" value="">
        <p>Вы уверены, что хотите удалить эту научную публикацию?</p>
        <button type="submit">Удалить</button>
        <button type="button" id="cancel_delete_scientific_publication">Отмена</button>
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
            <th>Действия</th>
        </tr>
        </thead>
        <?php if (empty($scientific_publications)): ?>
            <tbody>
            <tr>
                <td colspan="6">Нет научных публикаций</td>
            </tr>
            </tbody>
        <?php else: ?>
            <tbody>
            <?php foreach ($scientific_publications as $scientific_publication): ?>
                <tr class="scientific-publication-row"
                    data-scientific-publication-id="<?= $scientific_publication->scientific_publication_id ?>"
                    data-name="<?= $scientific_publication->name ?>"
                    data-edition-id="<?= $scientific_publication->edition_id ?>"
                    data-publication-date="<?= $scientific_publication->publication_date ?>"
                    data-index-id="<?= $scientific_publication->index_id ?>"
                    data-student-id="<?= $scientific_publication->student_id ?>"
                >
                    <td><?= $scientific_publication->name ?></td>
                    <td><?= $scientific_publication->edition->edition_name ?></td>
                    <td><?= date('d.m.Y', strtotime($scientific_publication->publication_date)) ?></td>
                    <td><?= $scientific_publication->student->lastname ?> <?= $scientific_publication->student->firstname ?></td>
                    <td><?= $scientific_publication->index->index_name ?></td>
                    <td>
                        <button class="edit-scientific-publication-button">Изменить</button>
                        <button class="delete-scientific-publication-button">Удалить</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        <?php endif; ?>
    </table>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const popup = document.getElementById('popup-message');
        // if (popup && popup.classList.contains('show')) {
        //     if (popup.classList.contains('success')) {
        //         setTimeout(() => {
        //             popup.classList.remove('show');
        //         }, 3000);
        //     }
        //     if (popup.classList.contains('error')) {
        //         setTimeout(() => {
        //             popup.classList.remove('show');
        //         }, 3000);
        //     }
        // }

        const addScntPubCont = document.getElementById('add_scientific_publications_container');
        const toggleAddScntPubFormButton = document.getElementById('toggle_add_scientific_publication_form');
        const changeScntPubCont = document.getElementById('change_scientific_publications_container');
        const deleteScntPubCont = document.getElementById('delete_scientific_publications_container');
        const cancelDeleteButton = document.getElementById('cancel_delete_scientific_publication');


        toggleAddScntPubFormButton.addEventListener('click', function() {
            if (addScntPubCont.hidden) {
                addScntPubCont.hidden = false;
                changeScntPubCont.hidden = true; // Hide change form if add form is shown
                deleteScntPubCont.hidden = true; // Hide delete form if add form is shown
            } else {
                addScntPubCont.hidden = true;
            }
        });

        //клик снаружи
        document.addEventListener('click', function(event) {
            if (!addScntPubCont.contains(event.target) && !toggleAddScntPubFormButton.contains(event.target) && !addScntPubCont.hidden) {
                addScntPubCont.hidden = true;
            }
            if (!changeScntPubCont.contains(event.target) && !event.target.classList.contains('edit-scientific-publication-button') && !changeScntPubCont.hidden) {
                changeScntPubCont.hidden = true;
            }
            if (!deleteScntPubCont.contains(event.target) && !event.target.classList.contains('delete-scientific-publication-button') && !deleteScntPubCont.hidden) {
                deleteScntPubCont.hidden = true;
            }
        });

        document.querySelectorAll('.edit-scientific-publication-button').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('.scientific-publication-row');
                const scientificPublicationId = row.dataset.scientificPublicationId;
                const name = row.dataset.name;
                const editionId = row.dataset.editionId;
                const publicationDate = row.dataset.publicationDate;
                const indexId = row.dataset.indexId;
                const studentId = row.dataset.studentId;

                document.getElementById('change_scientific_publication_id').value = scientificPublicationId;
                document.getElementById('change_name').value = name;
                document.getElementById('edition_id_change').value = editionId;
                document.getElementById('change_publication_date').value = publicationDate;
                document.getElementById('index_id_change').value = indexId;
                document.getElementById('student_id_change').value = studentId;

                changeScntPubCont.hidden = false;
                addScntPubCont.hidden = true; // Hide add form if change form is shown
                deleteScntPubCont.hidden = true; // Hide delete form if change form is shown

                // Scroll to the form or position it if needed
                changeScntPubCont.scrollIntoView({ behavior: 'smooth', block: 'center' });
            });
        });

        document.querySelectorAll('.delete-scientific-publication-button').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('.scientific-publication-row');
                const scientificPublicationId = row.dataset.scientificPublicationId;

                document.getElementById('delete_scientific_publication_id').value = scientificPublicationId;

                deleteScntPubCont.hidden = false;
                addScntPubCont.hidden = true; // Hide add form if delete form is shown
                changeScntPubCont.hidden = true; // Hide change form if delete form is shown

                deleteScntPubCont.scrollIntoView({ behavior: 'smooth', block: 'center' });
            });
        });

        cancelDeleteButton.addEventListener('click', function() {
            deleteScntPubCont.hidden = true;
        });
    });
</script>
</body>
</html>
