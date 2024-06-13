<?php
session_start();
if ($_SESSION['id'] == "") {
    echo 'Доступ заборонений';
    unset($_SESSION['id']);
    header("Location:/index.php");
} else {
    if ($_SESSION['auth'] == "admin") {
    echo "<script>
                location.href='../admin/index.php';
                </script>"; 
    }

    include("../include/db_connect.php"); 

    $id = $_SESSION['id'];
    $sel = mysqli_query($connect, "SELECT * FROM Users WHERE user_id  = '$id'");
    $num_rows = mysqli_num_rows($sel); 
}

if (isset($_POST['bthexit'])) {
    session_destroy();
    echo "<meta http-equiv='refresh' content='0'>";
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Мій особистий кабінет</title>
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
            <form action="" method="post" style="display: inline;">
                <button type="submit" class="exit_account" name="exit_account">Вихід</button>
            </form>
        <?php else: ?>
            <a href="login.php">Увійти</a>
            <a href="registration.php">Регістрація</a>
        <?php endif; ?>
    </div>
    <div class="container">
        <div class="welcome">
            <h2>Особистий кабінет</h2>
        </div>  

        <div class="trainer-card">
        <div class="section-links"> 
            <a href="schedule.php">Мій розклад</a>
            <a href="my_articles.php">Мої статті</a>
            <a href="../blog/add.php">Додати статтю</a>
            <a href="../users/index.php">Мій кабінет </a>
        </div>
         <div class="section-links"> 
            <a href="add_review.php">Написати відгук</a>
            <a href="record.php">Записатися на заняття</a>
        </div>

        <form method="POST">
            <button name="bthexit" type="submit" class="check_cart" id="bthexit">
                Вихід з профіля
            </button>
        </form>
        </div>

        <div class="welcome">
            <h2>Наші рекомендаії щодо тренування:</h2>
        </div>
        <div class="trainer-card">
            <h3>Перший тиждень</h3>
            <div class="section-links">
                <a href="../articles/1-week-1.php">Грудь + Трицепс  </a>
                <a href="../articles/1-week-2.php">Спина + Бицепс </a>
                <a href="../articles/1-week-3.php">Ноги </a>
            </div>

            <h3>Другий тиждень</h3>
            <div class="section-links">
                <a href="../articles/2-week-1.php">Плечі + Прес </a>
                <a href="../articles/2-week-2.php">Груди + Спина </a>
                <a href="../articles/2-week-3.php">Ноги </a>
            </div>

            <h3>Третій тиждень</h3>
            <div class="section-links">
                <a href="../articles/3-week-1.php">Груди + Плечі </a>
                <a href="../articles/3-week-2.php">Спина + Прес  </a>
                <a href="../articles/3-week-3.php">Плечі + Руки </a>
            </div>

            <h3>Четвертий тиждень</h3>
            <div class="section-links">
                <a href="../articles/4-week-1.php">Ноги </a>
                <a href="../articles/4-week-2.php">Груди + плечі (передня + середня) </a>
                <a href="../articles/4-week-3.php">Спина + плечі (Задня дельта) </a>
            </div>
        </div>
    
    </div>
</body>
</html>