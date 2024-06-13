<?php
session_start();
if ($_SESSION['id'] == "") {
    include("../include/db_connect.php"); 
if (isset($_POST['bthsubmit'])) {
    $login = $_POST["login"];
    $pass = md5($_POST['pass'] . "fitnes");

    $result = mysqli_query($connect, "SELECT * FROM `Users` WHERE `username`='$login' AND `password`='$pass'");

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

       $_SESSION['name']  = $row['name'];
        $_SESSION['id']  = $row['user_id'];
        $_SESSION['access']  = $row['access'];

        if ($row["access"] == 1) {
            $_SESSION['auth']  = 'user';
            header("Location: index.php");
        }
        if ($row["access"] == 2) {
            $_SESSION['auth']  = 'admin';
            header("Location: ../admin/index.php");
        }
        if ($row["access"] == 3) {
            $_SESSION['auth']  = 'admin';
            header("Location: ../shop/admin/index.php");
        }
    } else {
        echo '<script>alert("Ви допустили помилку при введені даних!");</script>';
    }
}
if (isset($_POST['bthregistr'])) {
    header("Location: registration.php");
}
} else {
    echo "<script>alert('Ви вже війшли!');
     location.href='../index.php';</script>";
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
    <title>Вхід в особистий кабінет</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="../css/styles.css">
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
            <a href="index.php">Мій кабінет</a>
            <form action="" method="post" style="display: inline;">
                <button type="submit" class="exit_account"  name="exit_account">Вихід</button>
            </form>
        <?php else: ?>
            <a href="../users/login.php">Увійти</a>
            <a href="../users/registration.php">Регістрація</a>
        <?php endif; ?>
    </div>
    <div class="container">
        <div class="welcome">
            <h2>Вхід в особистий кабінет:</h2>
        </div>
        <div  class="trainer-card">
                <form method="POST">
                    <div class="container-login">
                        <label for="uname"><b>Логін</b></label>
                        <input type="text" placeholder="" name="login" autocomplete="off" />
                        <label for="psw"><b>Пароль</b></label>
                        <input type="password" placeholder="" name="pass" autocomplete="off" />
                        
                        <button name="bthsubmit" type="submit" class="check_cart">
                            Увійти
                        </button>
                    
                    </form>
                    <button type="submit" name="bthregistr" class="check_cart" id="bthregistr">
                            Регістрація
                    </button>
                    </div>
        </div>
        </div>
    
</body>
</html>