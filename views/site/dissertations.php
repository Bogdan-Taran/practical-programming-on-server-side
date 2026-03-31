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
<div class="dissertations-container">
    <h1>Диссертации</h1>
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
                <td><?= $dissertation->status->dissertation_status_name ?></td>
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
