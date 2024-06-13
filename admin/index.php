<?php
session_start();
if ($_SESSION['auth'] != "admin") {
  echo "<script>alert(\"Доступ заборонений!\");
            location.href='../index.php';
            </script>"; 
} else {
  include("../include/db_connect.php");
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

?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Адміністративна панель</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>
<body>
  <div class="navbar">
        <a href="index.php">Головна</a>
        <a href="../trainer/admin/index.php">Тренери</a>
        <a href="../lessons/index.php">Заняття</a>
        <a href="../shop/admin/index.php">Інтернет-магазин</a>
        <a href="../schedule.php">Розклад</a>
        <form action="" method="post" >
            <button type="submit" class="exit_account" name="exit_account">Вихід</button>
        </form>
    </div>

    <div class="container">
        <div class="welcome">
            <h2>Ласкаво просимо до адміністративної панелі фітнес-залу "Мрія"!</h2>
            <p>Тут ви маєте можливість редагувати вміст сайту.</p>
        </div>

    <div class="trainer-card">

        <div class="section-links">
            <a href="../trainer/admin/index.php">Переглянути та редагувати тренерів</a>
            <a href="../lessons/index.php">Переглянути та редагувати заняття</a>
            <a href="../shop/admin/index.php">Адміністративна панель інтернет-магазин</a>
        </div>   
        <div class="section-links">
            <a href="../trainer/admin/schedule.php">Переглянути заняття тренерів</a>
            <a href="schedule_users.php">Переглянути заняття користувачі</a>
        </div>     
    </div>
    </div>
</body>
</html>