<?php
session_start();
include("../include/db_connect.php");

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }
}

$total_items_in_cart = array_sum($_SESSION['cart']);

$products_query = "SELECT * FROM products ORDER BY created_at DESC";
$products_result = mysqli_query($connect, $products_query);

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
    <title>Інтернет-магазин фітнес-залу</title>
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
            <a href="../users/index.php">Мій кабінет</a>
            <form action="" method="post" style="display: inline;">
                <button type="submit" name="exit_account" class="exit_account" >Вихід</button>
            </form>
        <?php else: ?>
            <a href="../users/login.php">Увійти</a>
            <a href="../users/registration.php">Регістрація</a>
        <?php endif; ?>
    </div>
    <div class="welcome">
    <h1>Інтернет-магазин спортивних товарів фітнес-залу</h1>
    </div>
    <div class="container">
    <?php
    if (mysqli_num_rows($products_result) > 0) {
        while ($row = mysqli_fetch_assoc($products_result)) {
            echo "<div class=\"trainer-card\">";
            echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
            echo "<p>" . nl2br(htmlspecialchars($row['description'])) . "</p>";
            echo "<p><strong>Ціна:</strong> " . htmlspecialchars($row['price']) . " грн</p>";
            if ($row['image']) {
                echo "<img src='../images/products/" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "' style='max-width:200px;'>";
            }
            echo "<p><em>Дата додавання:</em> " . htmlspecialchars($row['created_at']) . "</p>";
            echo "<form action='' method='post'>";
            echo "<input type='hidden' name='product_id' value='" . $row['product_id'] . "'>";
            echo "<button type='submit' name='add_to_cart'>Додати до кошика</button>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "<div class=\"trainer-card\"><p>Товарів ще немає.</p></div>";
    }
    ?>
    </div>
</body>
</html>
