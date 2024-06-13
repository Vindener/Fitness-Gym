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
    <title>3 тиждень - Груди + Плечі</title>
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
    <h1>3 тиждень тренувань - Груди + Плечі</h1>
    </div>

    <div class="container">
    <div class="trainer-card">
        <p>❖ Груди + Плечі</p>
        <p>❖ Спина + прес  </p>
        <p>❖ Плечі + Руки  </p>
        <hr>
        <h3>❖Перше тренування Груди + Плечі</h3>
        <h3>1) Жим гантелей у нахилі</h3>
        <ul class="lesson-list">
            <li>❖ 4 підходи з 12 повторень </li>
            <li>Вагу потрібно буде підбирати так, щоб останні 2-3 повторення були у натяжку - протягом усіх робочих підходів. </li>
        </ul>

        <video src="../videos/weeks/3-week/1.mp4" preload="auto" controls="controls" class="video"></video>
        <hr>
        <h3>2) Жим штанги у смітті (горизонт)</h3>
        <ul class="lesson-list">
            <li>❖ 4 підходи з 12 повторень </li>
            <li>Вагу потрібно буде підбирати так, щоб останні 2-3 повторення були у натяжку - протягом усіх робочих підходів. </li>
        </ul>

        <video src="../videos/weeks/3-week/2.mp4" preload="auto" controls="controls" class="video"></video>

        <hr>
        <h3>3) Метелик на грудях  </h3>
        <ul class="lesson-list">
            <li>❖ 4 підходи з 14 повторень  </li>
            <li>Вагу потрібно буде підбирати так, щоб останні 2-3 повторення були у натяжку - протягом усіх робочих підходів. </li>
        </ul>

        <video src="../videos/weeks/3-week/3.mp4" preload="auto" controls="controls" class="video"></video>

        <hr>
        <h3>4) Махи у тренажері   </h3>
        <ul class="lesson-list">
            <li>❖ 4 підходи з 14 повторень  </li>
            <li>Вагу потрібно буде підбирати так, щоб останні 2-3 повторення були у натяжку - протягом усіх робочих підходів. </li>
        </ul>

        <video src="../videos/weeks/3-week/4.mp4" preload="auto" controls="controls" class="video"></video>

        <hr>
        <h3>5) Махи задню дельту</h3>
        <ul class="lesson-list">
            <li>❖ 4 підходи з 14 повторень  </li>
            <li>Вагу потрібно буде підбирати так, щоб останні 2-3 повторення були у натяжку - протягом усіх робочих підходів. </li>
        </ul>

        <video src="../videos/weeks/3-week/5.mp4" preload="auto" controls="controls" class="video"></video>

        <hr>
        <div class="section-links">
        <a href="2-week-1.php">Минулий тиждень</a>
        <a href="../index.php">Повернутися на головну</a>
        <a href="3-week-2.php">Наступне заняття</a>
        </div>
    </div>
    </div>
</body>
</html>
