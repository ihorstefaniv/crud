<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Помилка!</title>
</head>
<body>

<h1>Виникла помилка</h1>
<p><b>Код помилки:</b> <?= $errno ?></p>
<p><b>Текст помилки:</b> <?= $errstr ?></p>
<p><b>Файл, в якому виникла помилка:</b> <?= $errfile ?></p>
<p><b>Рядок, в якому виникла помилка:</b> <?= $errline ?></p>

</body>
</html>