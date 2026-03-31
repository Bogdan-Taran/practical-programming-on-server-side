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

<div class="search-container">
    <div class="greeting-container">

    </div>
    <form action="/search" method="GET" class="searchbar-search">
        <input type="text" name="search-query" placeholder="Поиск аспирантов по руководителю" value="<?= $searchQuery ?? '' ?>">
        <button type="submit">Поиск</button>
    </form>
    <div class="search-result-container">
        <h2>Результаты поиска:</h2>
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

        <?php elseif (isset($searchQuery)): ?>
            <p>По запросу "<?= $searchQuery ?>" ничего не найдено.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
