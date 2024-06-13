<?php
session_start();
include("../../include/db_connect.php");

if (!isset($_SESSION['id']) || ($_SESSION['access'] != 2 && $_SESSION['access'] != 3)) {
    echo "<script>alert(\"Доступ заборонений!\");
            location.href='../index.php';
            </script>"; 
}

if (isset($_POST['add_product'])) {
    mysqli_query($connect, "INSERT INTO `Products`(`name`, `description`,`price`) VALUES ('" . $_POST["name"] . "','" . $_POST["description"] . "','" . $_POST["price"] . "')");

        $id_user_img = mysqli_insert_id($connect);
        if (isset($_FILES['myFile'])) {
          $myFile = $_FILES['myFile'];
          include("vendor/upload_image.php");
        }   
        echo "<script>alert(\"Товар успішно додано!\");
            location.href='index.php';
            </script>"; 
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/styles.css">
    <title>Додати товар</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>
<body>

    <div class="navbar">
        <a href="../../admin/index.php">Головна</a>
        <a href="../../trainer/admin/index.php">Тренери</a>
        <a href="../../lessons/index.php">Заняття</a>
        <a href="index.php">Інтернет-магазин</a>
        <a href="../../schedule.php">Розклад</a>
        <form action="" method="post" >
            <button type="submit" class="exit_account" name="exit_account">Вихід</button>
        </form>
    </div>

     <div class="container">
        <div class="welcome">
            <h2>Створення товару </h2>
            <p>Тут можна створити новий товар інтернет-магазина.</p>
        </div>
    <div class="trainer-card">
    <form action="" method="post" enctype="multipart/form-data" class="container-login">
        <label for="name">Назва товару:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="description">Опис:</label>
        <textarea name="description" id="description" rows="4" cols="50" required></textarea>
        <br>
        <label for="price">Ціна:</label>
        <input type="number" step="0.01" name="price" id="price" required>
        <br>
        <label for="image">Зображення:</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
             <input type="file" name="myFile" id="imageInput" accept="image/*" />
        <br>
        <button type="submit" name="add_product" class="check_cart">Додати товар</button>
    </form>
     </div>
</body>
</html>
