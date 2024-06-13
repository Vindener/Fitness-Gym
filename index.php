<?php
session_start();
include("include/db_connect.php");

// відгуки
$reviews_query = "
    SELECT 
        reviews.rating, 
        reviews.comment, 
        reviews.created_at, 
        Users.username, 
        Lessons.title 
    FROM reviews
    JOIN Users ON reviews.user_id = Users.user_id
    JOIN Lessons ON reviews.class_id = Lessons.class_id
    ORDER BY reviews.created_at DESC
";
$reviews_result = mysqli_query($connect, $reviews_query);

//для хедера
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
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/gallery.js"></script>
    <title>Основна сторінка фітнес-залу</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>
<body>
    <div class="navbar">
        <?php if ($total_items_in_cart == null): ?>
            <a href="shop/cart.php">Перейти до кошика</a>
        <?php else: ?>
            <a href="shop/cart.php">У кошику: <?php echo $total_items_in_cart; ?> </a>
        <?php endif; ?>
        <a href="index.php">Головна</a>
        <a href="trainer/index.php">Тренери</a>
        <a href="shop/index.php">Інтернет-магазин</a>
        <a href="blog/index.php">Блог</a>
        <a href="schedule.php">Розклад</a>
        <?php if ($user_logged_in): ?>
            <a href="users/index.php">Мій кабінет</a>
            <form action="" method="post" >
                <button type="submit" class="exit_account" name="exit_account">Вихід</button>
            </form>
        <?php else: ?>
            <a href="users/login.php">Увійти</a>
            <a href="users/registration.php">Регістрація</a>
        <?php endif; ?>
    </div>

    <div class="container">
        <div class="welcome">
            <h2>Ласкаво просимо до нашого фітнес-залу "Мрія"!</h2>
            <h3>"Зроби тіло своєї мрії"</h3>
            <p>Тут ви знайдете інформацію про наших тренерів, заняття, розклад, інтернет-магазин та багато іншого.</p>
        </div>       

        <div class="gallery-container">
            <div class="gallery">
                <img src="images/gallery/image1.jpg" alt="Картинка 1">
                <img src="images/gallery/image2.jpg" alt="Картинка 2">
                <img src="images/gallery/image3.jpg" alt="Картинка 3">
            </div>
        </div>

        <div class="section-links">
            <a href="trainer/index.php">Переглянути тренерів та їх заняття</a>
            <a href="shop/index.php">Переглянути спортивні товари</a>
            <a href="blog/index.php">Переглянути блог</a>
        </div>
        <div class="section-links">
            <a href="schedule.php">Переглянути розклад занять</a>
            <?php if ($user_logged_in): ?>
                <a href="shop/orders.php">Переглянути мої замовлення</a>
            <?php endif; ?>
        </div>

        <div class="welcome">
            <h2>Наші рекомендаії щодо тренування:</h2>
        </div>
        <div class="trainer-card">
            <h3>Перший тиждень</h3>
            <div class="section-links">
                <a href="articles/1-week-1.php">Грудь + Трицепс  </a>
                <a href="articles/1-week-2.php">Спина + Бицепс </a>
                <a href="articles/1-week-3.php">Ноги </a>
            </div>

            <h3>Другий тиждень</h3>
            <div class="section-links">
                <a href="articles/2-week-1.php">Плечі + Прес </a>
                <a href="articles/2-week-2.php">Груди + Спина </a>
                <a href="articles/2-week-3.php">Ноги </a>
            </div>

            <h3>Третій тиждень</h3>
            <div class="section-links">
                <a href="articles/3-week-1.php">Груди + Плечі </a>
                <a href="articles/3-week-2.php">Спина + Прес  </a>
                <a href="articles/3-week-3.php">Плечі + Руки </a>
            </div>

            <h3>Четвертий тиждень</h3>
            <div class="section-links">
                <a href="articles/4-week-1.php">Ноги </a>
                <a href="articles/4-week-2.php">Груди + плечі (передня + середня) </a>
                <a href="articles/4-week-3.php">Спина + плечі (Задня дельта) </a>
            </div>
        </div>

        <div class="welcome">
            <h2>Відгуки:</h2>
                <?php
                if (mysqli_num_rows($reviews_result) > 0) {
                    while ($row = mysqli_fetch_assoc($reviews_result)) {
                        echo "<div class='trainer-card'>";
                        echo "<h2>" . htmlspecialchars($row['title']) . ". Оцінка - " . htmlspecialchars($row['rating']) . "/5</h2>";
                        echo "<p><strong>Користувач:</strong> " . htmlspecialchars($row['username']) . "</p>";
                        echo "<p><strong>Коментар:</strong> " . htmlspecialchars($row['comment']) . "</p>";
                        echo "<p><em>Дата:</em> " . htmlspecialchars($row['created_at']) . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Відгуків ще немає.</p>";
                }
                ?>
        </div>  

    </div>
</body>
</html>
