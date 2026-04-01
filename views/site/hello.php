<?php ?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style_general.css">
    <link rel="stylesheet" href="/css/style_hello.css">
    <link rel="stylesheet" href="/css/style_admin_panel.css">
    <title>Decan</title>
</head>
<body>
<?php
$user = app()->auth::user();
?>

<div class="hello-container">
    <h1>Здравствуйте, <?php echo $user->firstname; ?>, что бы вы хотели сделать:</h1>
    <div class="actions-container">
        <a class="action-item" href="<?= app()->route->getUrl('/search') ?>">Поиск аспирантов по руководителю</a>
        <?php if (app()->auth::user()->role_id === \Model\User::ROLE_ADMIN): ?>
            <a class="action-item" href="<?= app()->route->getUrl('/admin') ?>">Добавить аспирантов/научного руководителя</a>
        <?php endif; ?>
        <a class="action-item" href="<?= app()->route->getUrl('/') ?>">Сформировать отчёт по количеству защит за период</a>
        <a class="action-item" href="<?= app()->route->getUrl('/scientificPublications') ?>">Учёт научных публикаций</a>
        <a class="action-item" href="<?= app()->route->getUrl('/dissertations') ?>">Учёт диссертаций</a>

    </div>


</div>

</body>
</html>
