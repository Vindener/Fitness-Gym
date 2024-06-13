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
    <title>1 тиждень - Груди + Трицеп</title>
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
    <h1>1 тиждень тренувань - Груди + Трицеп</h1>
    </div>

    <div class="container">
    <div class="trainer-card">
        <p>❖ Грудь + Трицепс </p>
        <p>❖ Спина + Бицепс </p>
        <p>❖ Ноги </p>
        <hr>
        <h3>❖Перше тренування: ❖ Груди + Трицепс</h3>
        <ul class="lesson-list">
            <li>Розминка з порожнім грифом (штанга) 12 повторень</li>
            <li>❖ 4 підходи 12\12\10\10 повторень</li>
            <li>Вагу додаємо поступово – прислухаємось до організму</li>
            <li>Вагу потрібно буде підбирати так, щоб останні 2-3 повторення були у натяжку - протягом усіх робочих підходів. </li>
        </ul>

        <video src="../videos/weeks/1-week/1.mp4" preload="auto" controls="controls" class="video"></video>
        <hr>
        <h3>2)Жим у хамері на похилій лаві. </h3>
        <ul class="lesson-list">
            <li>❖ 4 підходи 12\12\10\10 повторень </li>
            <li>Вагу додаємо поступово – прислухаємось до організму</li>
            <li>Вагу потрібно буде підбирати так, щоб останні 2-3 повторення були у натяжку - протягом усіх робочих підходів. </li>
        </ul>

        <video src="../videos/weeks/1-week/2.mp4" preload="auto" controls="controls" class="video"></video>

        <hr>
        <h3>3) Зведення рук у тренажері (метелик) </h3>
        <ul class="lesson-list">
            <li>❖ 4 підходи 14\14\12\12 повторень </li>
            <li>Вагу потрібно буде підбирати так, щоб останні 2-3 повторення були у натяжку - протягом усіх робочих підходів. </li>
        </ul>

        <video src="../videos/weeks/1-week/3.mp4" preload="auto" controls="controls" class="video"></video>

        <hr>
        <h3>4) Віджимання від підлоги </h3>
        <ul class="lesson-list">
            <li>❖ 4 підходи з 10 повторень  </li>
            <li>Робота з власною вагою </li>
        </ul>

        <video src="../videos/weeks/1-week/4.mp4" preload="auto" controls="controls" class="video"></video>

        <hr>
        <h3>М'язи трицепса </h3>
        <ul class="lesson-list">
            <li>1) Розгинання рук у кросовері  </li>
            <li> ❖ 4 підходи по 12 повторень на шкірний бік </li>
            <li> Вага невелика максимальна концентрація (4-7кг)   </li>
        </ul>

        <video src="../videos/weeks/1-week/5.mp4" preload="auto" controls="controls" class="video"></video>
        <hr>
        <div class="section-links">
        <a href="../index.php">Повернутися на головну</a>
        <a href="1-week-2.php">Наступне заняття</a>
        </div>
    </div>
    </div>
</body>
</html>
