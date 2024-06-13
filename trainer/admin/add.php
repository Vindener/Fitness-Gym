<?php
session_start();
include("../../include/db_connect.php"); 

if (isset($_POST['create_trainer'])) {
    mysqli_query($connect, "INSERT INTO `Trainers`(`name`, `bio`) VALUES ('" . $_POST["name"] . "','" . $_POST["bio"] . "')");

    $id_user_img = mysqli_insert_id($connect);
    if (isset($_FILES['myFile'])) {
        $myFile = $_FILES['myFile'];
        include("vendor/upload_image.php");
    }
    echo "<script>alert(\"Тренера успішно додано!\");
            location.href='index.php';
            </script>"; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/styles.css">
    <title>Створення трейнера</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>
<body>
    <div class="navbar">
        <a href="../../admin/index.php">Головна</a>
        <a href="index.php">Тренери </a>
        <a href="../../lessons/index.php">Заняття</a>
        <a href="../../shop/index.php">Інтернет-магазин </a>
        <a href="../../schedule.php">Розклад</a>
        <form action="" method="post" >
            <button type="submit" class="exit_account" name="exit_account">Вихід</button>
        </form>
    </div>

    <div class="container">
        <div class="welcome">
            <h2>Створення Тренера </h2>
            <p>Тут можна створити нового тренера фітнес-залу.</p>
        </div>
    <div class="trainer-card">

    <div class="modal-body">
        <div  class="container-login">
            Створення трейнера 
            <form action="" method="post" class="container-login" enctype="multipart/form-data" >
                <label for="name"><b>ПІБ трейнера</b></label>
                <input type="text" placeholder="ПІБ трейнера" name="name" required />

                <label for="email"><b>Біографія</b></label>
                <input type="text" placeholder="Біографія" name="bio" required />
                <button type="submit" class="check_cart" name="create_trainer">Створити</button>

                <hr />


                <div >
            <h1>Фото трейнера</h1>
             <div id="preview"></div>
          <br>
          <label>Оберiть файл для основного зображення:</label>
          <div>
            <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
             <input type="file" name="myFile" id="imageInput" accept="image/*" />
          </div>
          <br>
        </form>
        </div>

    </div>
    

    <script>
    // Скрипт для створення превью
    document.getElementById('imageInput').addEventListener('change', function(event) {
    var file = event.target.files[0];
    var reader = new FileReader();

    reader.onload = function(e) {
        var imgElement = document.createElement('img');
        imgElement.src = e.target.result;
        imgElement.style.maxWidth = '300px'; 
        imgElement.style.maxHeight = '300px';

        var preview = document.getElementById('preview');
        preview.innerHTML = ''; 
        preview.appendChild(imgElement); 
    };

        reader.readAsDataURL(file);
    });

    </script>
</body>
</html>