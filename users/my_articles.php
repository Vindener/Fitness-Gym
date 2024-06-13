<?php
session_start();
include("../include/db_connect.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

$articles_query = "SELECT * FROM Blog WHERE user_id = ? ORDER BY Blog.created_at DESC";
$stmt = $connect->prepare($articles_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$articles_result = $stmt->get_result();
$stmt->close();

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
    <title>Мої статті</title>
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
            <a href="index.php">Мій кабінет</a>
            <form action="" method="post" style="display: inline;">
                <button type="submit" class="exit_account" name="exit_account">Вихід</button>
            </form>
        <?php else: ?>
            <a href="../users/login.php">Увійти</a>
            <a href="../users/registration.php">Регістрація</a>
        <?php endif; ?>
    </div>
    <div class="welcome"><h1>Мої статті</h1></div>
    <div class="container">        
        <?php if ($articles_result->num_rows > 0): ?>
            <?php while ($article = $articles_result->fetch_assoc()): ?>
                <div class="article-card">
                    <h2><?php echo htmlspecialchars($article['title']); ?></h2>
                    <?php if (!empty($article['photo'])): ?>
                        <img src="../images/blog/<?php echo htmlspecialchars($article['photo']); ?>" alt="Фотографія статті" class="blog-photo">
                    <?php endif; ?>
                    <p><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
                    <p><em>Опубліковано: <?php echo htmlspecialchars($article['created_at']); ?></em></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Ви ще не публікували жодної статті.</p>
        <?php endif; ?>
    </div>
    </div>
</body>
</html>
