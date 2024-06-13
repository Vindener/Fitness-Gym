<?php
session_start();
include("../include/db_connect.php");

if (!isset($_SESSION['id'])) {
    header("Location: ../users/login.php");
    exit();
}

if (isset($_POST['create_article'])) {
    $user_id = $_SESSION['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $photo = '';

    if (!empty($_FILES['photo']['name'])) {
        $target_dir = "../images/blog/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    }

    $stmt = $connect->prepare("INSERT INTO Blog (user_id, title, content, photo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $title, $content, $photo);
    if ($stmt->execute()) {
        echo "<script>alert(\"Стаття успішно додана!\");
            location.href='index.php';
            </script>"; 
    } else {
        echo "<script>alert(\"Помилка при додаванні статті!\");
            </script>"; 
    }
    $stmt->close();
}

// для хедера
$user_logged_in = isset($_SESSION['id']);
if($user_logged_in == true){
    $user_name = $_SESSION['name'];
}

if (isset($_POST['exit_account'])) {
    session_destroy();
    echo "<meta http-equiv='refresh' content='0'>";
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$total_items_in_cart = array_sum($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Додати статтю</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>
<body>
    <div class="navbar">
        <?php if ($total_items_in_cart == null): ?>
            <a href="../shop/cart.php">Перейти до кошика</a>
        <?php else: ?>
            <a href="../shop/cart.php">У кошику: <?php echo $total_items_in_cart; ?> </a>
        <?php endif; ?>
        <a href="../index.php">Головна</a>
        <a href="../trainer/index.php">Тренери</a>
        <a href="../shop/index.php">Інтернет-магазин</a>
        <a href="../blog/index.php">Блог</a>
        <a href="../schedule.php">Розклад</a>
        <?php if ($user_logged_in): ?>
            <a href="../users/index.php">Мій кабінет </a>
            <form action="" method="post" style="display: inline;">
                <button type="submit" name="exit_account" class="exit_account">Вихід</button>
            </form>
        <?php else: ?>
            <a href="../users/login.php">Увійти</a>
            <a href="../users/registration.php">Регістрація</a>
        <?php endif; ?>
    </div>
    <div class="welcome">
    <h1>Додати статтю</h1>
    </div>
        <div class="container">
            <div class="trainer-card">
                <form action="" method="post" enctype="multipart/form-data">
                <label for="title">Назва:</label>
                <input type="text" name="title" id="title" required>
                <br><br>
                <label for="content">Контент:</label>
                <textarea name="content" id="content" rows="10" cols="50" required></textarea>
                <br><br>
                <label for="photo">Фотографія:</label>
                <input type="file" name="photo" id="photo" accept="image/*">
                <br><br>
                <button type="submit" name="create_article">Створити статтю</button>
            </form>
            </div>
        </div>
    </div>
</body>
</html>
