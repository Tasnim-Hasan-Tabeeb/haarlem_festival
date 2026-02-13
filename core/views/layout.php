<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Page' ?></title>
</head>
<body>
    <header>
        <h1><?= $title ?? 'My App' ?></h1>
    </header>

    <main>
        <?= $content ?? '' ?>
    </main>

    <footer>
        <p>© 2025 My App</p>
    </footer>
</body>
</html>