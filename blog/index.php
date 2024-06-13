<?php
session_start();
include("../include/db_connect.php");

$posts_query = "
    SELECT 
        Blog.title, 
        Blog.content, 
        Blog.photo, 
        Blog.created_at, 
        Users.username 
    FROM Blog
    JOIN Users ON Blog.user_id = Users.user_id
    ORDER BY Blog.created_at DESC
";
$posts_result = mysqli_query($connect, $posts_query);

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
    <link rel="stylesheet" href="../css/styles.css">
    <title>Блог про фітнес та здоровий спосіб життя</title>
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
            <a href="../users/index.php">Мій кабінет</a>
            <form action="" method="post" style="display: inline;">
                <button type="submit" class="exit_account"  name="exit_account">Вихід</button>
            </form>
        <?php else: ?>
            <a href="../users/login.php">Увійти</a>
            <a href="../users/registration.php">Регістрація</a>
        <?php endif; ?>
    </div>
    <div class="welcome">
    <h1>Блог про фітнес та здоровий спосіб життя</h1>
    <?php if ($user_logged_in): ?>
        <div class="blog-button">
            <a href="add.php">Додати cтаттю</a>
        </div>
    <?php else: ?>
            <p><a href="../users/login.php">Увійдіть</a>, щоб публікувати статтю</p>
    <?php endif; ?>
    </div>

    <div class="container">
        <?php
        if (mysqli_num_rows($posts_result) > 0) {
            while ($row = mysqli_fetch_assoc($posts_result)) {
                echo "<div class=\"trainer-card\">";
                echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
                if ($row['photo']) {
                     echo "<img src='../images/blog/" . htmlspecialchars($row['photo']) . "' alt='Зображення статті' class='blog-photo' >";
                }
                echo "<p><strong>Автор:</strong> " . htmlspecialchars($row['username']) . "</p>";
                echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
                echo "<p><em>Дата:</em> " . htmlspecialchars($row['created_at']) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Статей ще немає.</p>";
        }
        ?>
    </div>
    </div>
</body>
</html>
