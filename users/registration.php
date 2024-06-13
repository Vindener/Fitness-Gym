<?php
session_start();
include("../include/db_connect.php"); 
if ($_SESSION['id'] == "") {
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
    <title>Регістрація</title>
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
            <a href="login.php">Увійти</a>
            <a href="registration.php">Регістрація</a>
        <?php endif; ?>
    </div>
    <div class="container">
        <div class="welcome">
            <h2>Регістрація особистого кабінету:</h2>
        </div>
    <div  class="trainer-card">
            <?php
            if (isset($_POST['bthregistr'])) {

                $error = 0;

                $result = mysqli_query($connect, "SELECT * FROM Users");
                $row = mysqli_fetch_array($result);

                $password = md5($_POST['pass'] . "fitnes");
                mysqli_query($connect, "INSERT INTO `Users` (`user_id`, `username`, `password`, `email`, `name`) 
        VALUES (NULL, '" . $_POST["login"] . "', '" . $password . "', '" . $_POST["email"] . "','" . $_POST["name"] . "')");

                    //Вхід після регістрації
                    $login = $_POST["login"];

                    $result = mysqli_query($connect, "SELECT * FROM `Users` WHERE `username`='$login' AND `password`='$password'");

                    $row = mysqli_fetch_array($result);

                    $_SESSION['name']  = $row['name'];
                    $_SESSION['id']  = $row['user_id'];
                    $_SESSION['auth']  = 'user';

                    echo "<script>
                            location.href='index.php';
                            </script>
                    ";
                }  
            ?>
    <div class="modal-body">
        <form action="" method="post" class="container-login">
            <label for="name"><b>ПІБ</b></label>
            <input type="text" placeholder="ПІБ" name="name" required autocomplete="off" />

            <label for="email"><b>Електронна пошта</b></label>
            <input type="text" placeholder="Електронна пошта" name="email" required autocomplete="off" />

            <label for="login"><b>Логін</b></label>
            <input type="text" placeholder="Логін" name="login" required autocomplete="off"  />

            <label for="pass"><b>Пароль</b></label>
            <input type="password" placeholder="Пароль" name="pass" required autocomplete="off"  />
            <hr />

            <button type="submit" class="check_cart" id="bthregistr" name="bthregistr">
                Регістрація
            </button>
            <br>
            <p>Вже маєте обліковий запис? <a href="login.php">Увійти в акаунт</a>.</p>
        </form>
    </div>
    </div>
</body>
</html>