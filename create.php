// Масиви для результатів
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Показуємо масив $_FILES для преподського звіту
    echo '<h2>Дані масиву $_FILES:</h2>';
    echo '<pre>';
    var_dump($_FILES);
    echo '</pre>';
    echo '<hr>';

    // 2. Перевіряємо, чи взагалі файл дійшов до сервера без помилок
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        
        $file = $_FILES['avatar'];
        
        // Отримуємо розширення файлу (jpg або png)
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // Створюємо просте англійське ім'я, щоб Windows не тупив через кирилицю та пробіли
        $newFileName = 'avatar_' . time() . '.' . $extension;

        // Побудова правильного шляху для Windows через DIRECTORY_SEPARATOR
        $uploadDir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
        $destination = $uploadDir . $newFileName;

        // 3. Перевірка розміру (робимо запас до 5 МБ для великих скриншотів)
        if ($file['size'] > 5 * 1024 * 1024) {
            $errors[] = 'Файл завеликий! Максимум 5 МБ.';
        }

        // 4. Перевірка розширення
        if (!in_array($extension, ['jpg', 'jpeg', 'png'], true)) {
            $errors[] = 'Дозволено завантажувати лише файли з розширенням JPG, JPEG або PNG.';
        }

        // 5. Якщо помилок немає — фізично переміщуємо файл із тимчасової папки в uploads
        if (empty($errors)) {
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $success = 'Зображення успішно завантажено в папку uploads!';
            } else {
                $errors[] = 'Помилка системи: PHP не зміг записати файл на диск. Перевір папку uploads.';
            }
        }

    } else {
        $errors[] = 'Файл не вибрано або сталася помилка при передачі на сервер. Код: ' . ($_FILES['avatar']['error'] ?? 'немає');
    }
}

// Виводимо червоні помилки, якщо вони є
foreach ($errors as $error) {
    echo '<p style="color:red; font-weight:bold; font-size:18px;">❌ ' . htmlspecialchars($error) . '</p>';
}

// Виводимо зелений успіх, якщо все пройшло
if ($success !== '') {
    echo '<p style="color:green; font-weight:bold; font-size:18px;">✅ ' . htmlspecialchars($success) . '</p>';
}

echo '<p style="margin-top:30px;"><a href="index.php">⬅️ Повернутися назад до форми</a></p>';
?>