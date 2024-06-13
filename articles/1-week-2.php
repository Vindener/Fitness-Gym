<?php
session_start();

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
    <title>1 тиждень - Спина + Біцепс </title>
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
    <h1>1 тиждень тренувань - Спина + Біцепс </h1>
    </div>

    <div class="container">
    <div class="trainer-card">
        <p>❖ Грудь + Трицепс </p>
        <p>❖ Спина + Бицепс </p>
        <p>❖ Ноги </p>
        <hr>
        <h3>❖Інше тренування: ❖ Спина + Біцепс</h3>
        <h3>1) Тяга верхнього блоку</h3>
        <ul class="lesson-list">
            <li> ❖ 4 підходи 15\12\10\10 повторень </li>
            <li>Вагу додаємо поступово – прислухаємось до організму</li>
            <li>Вагу потрібно буде підбирати так, щоб останні 2-3 повторення були у натяжку - протягом усіх робочих підходів. </li>
        </ul>

        <video src="../videos/weeks/1-week/6.mp4" preload="auto" controls="controls" class="video"></video>
        <hr>
        <h3>2) Тяга нижнього блоку (широким хватом)</h3>
        <ul class="lesson-list">
            <li>❖ 4 підходи 15\12\10\10 повторень </li>
            <li>Вагу додаємо поступово – прислухаємось до організму</li>
            <li>Вагу потрібно буде підбирати так, щоб останні 2-3 повторення були у натяжку - протягом усіх робочих підходів. </li>
        </ul>

        <video src="../videos/weeks/1-week/7.mp4" preload="auto" controls="controls" class="video"></video>

        <hr>
        <h3>3) Тяга верх.Хаммера </h3>
        <ul class="lesson-list">
            <li> ❖ 4 підходи з 12 повторень  </li>
            <li>Вагу додаємо поступово – прислухаємось до організму</li>
            <li>Вагу потрібно буде підбирати так, щоб останні 2-3 повторення були у натяжку - протягом усіх робочих підходів. </li>
        </ul>

        <video src="../videos/weeks/1-week/8.mp4" preload="auto" controls="controls" class="video"></video>

        <hr>
        <h3> 4) Тяга гантелі у нахилі </h3>
        <ul class="lesson-list">
            li> ❖ 4 підходи з 12 повторень  </li>
            <li>Вагу додаємо поступово – прислухаємось до організму</li>
            <li>Вагу потрібно буде підбирати так, щоб останні 2-3 повторення були у натяжку - протягом усіх робочих підходів. </li>
        </ul>

        <video src="../videos/weeks/1-week/9.mp4" preload="auto" controls="controls" class="video"></video>

        <hr>
        <h3>М'язи біцепса </h3>
        <h3>1) управа 21 на біцепс</h3>
        <ul class="lesson-list">
            <li> ❖ з нижньої точки до половини корпусу (7раз)</li>
            <li>  ❖ з половини корпусу вгору (7раз) </li>
            <li> ❖ і робота на повну амплітуду ( 7раз )   </li>
            <li>Вагу потрібно буде підбирати так, щоб останні 2-3 повторення були у натяжку - протягом усіх робочих підходів. </li>
        </ul>

        <video src="../videos/weeks/1-week/10.mp4" preload="auto" controls="controls" class="video"></video>
        <hr>
        <div class="section-links">
        <a href="1-week-1.php">Минуле заняття</a>
        <a href="../index.php">Повернутися на головну</a>
        <a href="1-week-3.php">Наступне заняття</a>
        </div>
    </div>
    </div>
</body>
</html>
