<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style_general.css">
    <link rel="stylesheet" href="/css/style_admin_panel.css">
    <link rel="stylesheet" href="/css/style_dissertations.css">
    <title>Диссертации</title>
</head>
<body>
<div id="popup-message" class="popup <?= isset($message) && !isset($error) ? 'show success' : '' ?> <?= isset($error) && $error ? 'show error' : '' ?>">
    <?= $message ?? '' ?>
</div>
<div id="status-picker" class="status-picker">
        <form method="post" action="<?= app()->route->getUrl('/updateDissertationStatus') ?>">
            <input type="hidden" name="dissertation_id" id="dissertation_id_for_status_change" value="">
            <label for="dissertation_status_id">Статус:</label>
            <select id="dissertation_status_id_picker" name="dissertation_status_id">
                <option value="" disabled selected>Выберите новый статус</option>
                <?php foreach ($statuses as $status): ?>
                    <option value="<?php echo $status->dissertation_status_id; ?>"><?php echo $status->dissertation_status_name; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Сохранить</button>
        </form>

</div>
<div class="dissertations-container">
    <h1>Диссертации</h1>
    <div class="manipulate-container">
        <div class="searchbar-search">
            <form action="/search" method="GET" style="width: 100%; align-self: center">
                <input type="text" name="search-file-query" placeholder="Поиск документов по названию"
                       value="<?= $searchQuery ?? '' ?>">
                <button type="submit">Поиск</button>
            </form>
        </div>
        <a class="add-dissertations-link" href="<?= app()->route->getUrl('/addDissertation') ?>">+ Добавить диссертацию</a>
    </div>

    <table>
        <thead>
        <tr>
            <th>Тема диссертации</th>
            <th>Дата защиты</th>
            <th>Статус</th>
            <th>Студент</th>
            <th>Специальность ВАК</th>
            <th>Загруженные файлы</th>
        </tr>
        </thead>
        <?php if (empty($dissertations)): ?>
        <tbody>
            <tr>
                <td colspan="5">Диссертаций нет</td>
            </tr>
        </tbody>
        <?php else: ?>
        <tbody>
        <?php foreach ($dissertations as $dissertation): ?>
            <tr>
                <td><?= $dissertation->theme ?></td>
                <td><?= date('d.m.Y', strtotime($dissertation->approval_date)) ?></td>
                <td class="change-dissertation-status" data-dissertation-id="<?= $dissertation->dissertation_id ?>" data-current-status-id="<?= $dissertation->status->dissertation_status_id ?>"><?= $dissertation->status->dissertation_status_name ?></td>
                <td><?= $dissertation->student->lastname ?> <?= $dissertation->student->firstname ?></td>
                <td><?= $dissertation->bakSpeciality->bak_speciality_name ?></td>
                <td>
                    <div class="upload-file-form">
                        <form >
                            <input type="file" name="file-upload">
                            <button type="submit">Загрузить</button>
                        </form>
                    </div>

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

    document.addEventListener('DOMContentLoaded', function () {
        const statusPicker = document.getElementById('status-picker');
        const dissertationIdInput = document.getElementById('dissertation_id_for_status_change');
        const statusSelect = document.getElementById('dissertation_status_id_picker');

        document.querySelectorAll('.change-dissertation-status').forEach(cell => {
            cell.addEventListener('click', function (event) {
                event.stopPropagation(); // Prevent event from bubbling up to document click
                const dissertationId = this.dataset.dissertationId;
                const currentStatusId = this.dataset.currentStatusId;

                dissertationIdInput.value = dissertationId;
                statusSelect.value = currentStatusId; // Set current status in picker

                // Position the status picker next to the clicked cell
                const rect = this.getBoundingClientRect();
                statusPicker.style.top = `${rect.top + window.scrollY}px`;
                statusPicker.style.left = `${rect.left + window.scrollX + rect.width + 10}px`; // 10px offset
                statusPicker.classList.add('show');
            });
        });

        // Hide status picker when clicking outside
        document.addEventListener('click', function (event) {
            if (!statusPicker.contains(event.target) && !event.target.classList