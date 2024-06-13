<?php
session_start();
include("../include/db_connect.php");

if (!isset($_SESSION['id'])) {
    header("Location: ../users/login.php");
    exit();
}

$user_id = $_SESSION['id'];

$orders_query = "
    SELECT orders.order_id, orders.total, orders.created_at
    FROM orders
    WHERE orders.user_id = ?
    ORDER BY orders.created_at DESC
";
$stmt = $connect->prepare($orders_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders_result = $stmt->get_result();
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
    <title>Мої замовлення</title>
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
        <a href="index.php">Інтернет-магазин</a>
        <a href="../blog/index.php">Блог</a>
        <a href="../schedule.php">Розклад</a>
        <?php if ($user_logged_in): ?>
            <a href="../users/index.php">Мій кабінет</a>
            <form action="" method="post" style="display: inline;">
                <button type="submit" name="exit_account" class="exit_account">Вихід</button>
            </form>
        <?php else: ?>
            <a href="users/login.php">Увійти</a>
            <a href="users/registration.php">Регістрація</a>
        <?php endif; ?>
    </div>

    <div class="container">
        <div class="welcome">
        <h1>Мої замовлення</h1>
        </div>
        <div class="container">
        <?php
        if ($orders_result->num_rows > 0) {
            while ($order = $orders_result->fetch_assoc()) {
                echo "<div class=\"trainer-card\">";
                echo "<h2>Замовлення №" . htmlspecialchars($order['order_id']) . "</h2>";
                echo "<p><strong>Загальна сума:</strong> " . htmlspecialchars($order['total']) . " грн</p>";
                echo "<p><strong>Дата замовлення:</strong> " . htmlspecialchars($order['created_at']) . "</p>";
                
                // Отримання деталей замовлення
                $order_items_query = "
                    SELECT products.name,products.image, OrderItems.quantity, OrderItems.price
                    FROM OrderItems
                    JOIN products ON OrderItems.product_id = products.product_id
                    WHERE OrderItems.order_id = ?
                ";
                $stmt_items = $connect->prepare($order_items_query);
                if (!$stmt_items) {
                    die("Помилка підготовки запиту для отримання деталей замовлення: " . $connect->error);
                }
                $stmt_items->bind_param("i", $order['order_id']);
                $stmt_items->execute();
                $order_items_result = $stmt_items->get_result();
                $stmt_items->close();

                if ($order_items_result->num_rows > 0) {
                    echo "<table>";
                    echo "<tr><th>Назва товару</th><th>Зображення</th><th>Кількість</th><th>Ціна</th><th>Сума</th></tr>";
                    while ($item = $order_items_result->fetch_assoc()) {
                        $subtotal = $item['quantity'] * $item['price'];
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($item['name']) . "</td>";
                        if($item['image']!=null) {
                            echo "<td><img src='../images/products/". htmlspecialchars($item['image'])."' alt='Фотографія статті' class='blog-photo'></td>";
                        }else{
                            echo "<td></td>";
                        }   
                        echo "<td>" . htmlspecialchars($item['quantity']) . "</td>";                  
                        echo "<td>". htmlspecialchars($item['price']) . " грн</td>";
                        echo "<td>" . htmlspecialchars($subtotal) . " грн</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>Це замовлення не містить товарів.</p>";
                }

                echo "</div>";
            }
        } else {
            echo "<p>У вас немає замовлень.</p>";
        }
        ?>
        </div>
    </div>
</body>
</html>
