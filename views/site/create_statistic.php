<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style_general.css">
    <link rel="stylesheet" href="/css/style_admin_panel.css">
    <link rel="stylesheet" href="/css/style_create-statistic-container.css">
    <title>Формирование отчёта</title>
</head>
<body>
<div id="popup-message" class="popup <?= isset($_SESSION['success_message']) ? 'show success' : '' ?> <?= isset($_SESSION['error_message']) ? 'show error' : '' ?>">
    <?= $_SESSION['success_message'] ?? ($_SESSION['error_message'] ?? '') ?>
</div>
<div class="create-statistic-container">
    <h1>Формирование отчета по количеству защит за период</h1>
    <form method="post" action="<?= app()->route->getUrl('/createStatistic') ?>">
        <input hidden="hidden" name="create_statistic">
        <div class="create-statistic-dates-pickers">
            <div class="form-group">
                <input type="date" id="start_date" name="start_date" required placeholder=" " value="<?= $_SESSION['start_date'] ?? '' ?>">
                <label for="start_date">Начальная дата:</label>
            </div>
            <div class="form-group">
                <input type="date" id="end_date" name="end_date" required placeholder=" " value="<?= $_SESSION['end_date'] ?? '' ?>">
                <label for="end_date">Конечная дата:</label>
            </div>
        </div>

        <button type="submit">Сформировать отчёт</button>
        <table>
            <thead>
            <tr>
                <th colspan="5">Количество защит за этот период</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="5"><h2 style="text-align: center"><?= $dissertation_count ?? $_SESSION['dissertation_count'] ?? '0' ?></h2></td>
            </tr>
            </tbody>
        </table>
    </form>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const popup = document.getElementById('popup-message');
        if (popup && popup.classList.contains('show')) {
            setTimeout(() => {
                popup.classList.remove('show');
                <?php
                unset($_SESSION['success_message']);
                unset($_SESSION['error_message']);
                unset($_SESSION['dissertation_count']);
                unset($_SESSION['start_date']);
                unset($_SESSION['end_date']);
                ?>
            }, 3000);
        }
    });
</script>
</body>
</html>
