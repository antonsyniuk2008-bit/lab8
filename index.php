<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Лабораторна робота №8</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 50px;">
    <h1>Завантаження аватара користувача</h1>

    <!-- enctype="multipart/form-data" — це найголовніше, щоб файл передавався -->
    <form action="create.php" method="POST" enctype="multipart/form-data">
        <p>
            <label for="avatar">Виберіть зображення (JPG або PNG):</label><br><br>
            <input type="file" id="avatar" name="avatar" accept="image/png, image/jpeg" required>
        </p>
        <button type="submit" style="padding: 10px 20px; cursor: pointer;">Завантажити файл на сервер</button>
    </form>
</body>
</html>