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
    <link rel="stylesheet" href="/css/style_search.css">
    <title>Искать аспирантов</title>
</head>
<body>
<div class="search-container">

    <div class="searchbar-search">
        <form action="/search" method="GET" style="width: 100%; align-self: center">
            <input type="text" name="search-query" placeholder="Поиск аспирантов по руководителю"
                   value="<?= $searchQuery ?? '' ?>">
            <button type="submit">Поиск</button>
        </form>
    </div>
    <div class="search-result-container">
        <?php if (!empty($supervisor)): ?>
            <h2>Результаты поиска для научного руководителя
                "<?= $supervisor->lastname ?> <?= $supervisor->firstname ?> <?= $supervisor->patronymic ?>":</h2>
            <?php if (!empty($students)): ?>
                <table>
                    <thead>
                    <tr>
                        <th>ФИО</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= $student->lastname ?> <?= $student->firstname ?> <?= $student->patronymic ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>По запросу "<?= $searchQuery ?>" для данного руководителя ничего не найдено.</p>
            <?php endif; ?>
        <?php elseif (isset($searchQuery) && $searchQuery !== ''): ?>
            <p>По запросу "<?= $searchQuery ?>" ничего не найдено.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
