<?php
session_start();
include("../../include/db_connect.php");

if ($_SESSION['auth'] != "admin") {
  echo "<script>alert(\"Доступ заборонений!\");
            location.href='../index.php';
            </script>"; 
}

$users_query = "SELECT user_id, username FROM Users";
$users_result = mysqli_query($connect, $users_query);

$where_clause = "";
if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $where_clause = "WHERE orders.user_id = " . intval($user_id);
}

$orders_query = "
    SELECT orders.order_id, orders.total, orders.created_at, Users.username
    FROM orders
    JOIN Users ON orders.user_id = Users.user_id
    $where_clause
    ORDER BY orders.created_at DESC
";
$orders_result = mysqli_query($connect, $orders_query);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/styles.css">
    <title>Керування замовленнями</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>
<body>
    <div class="navbar">
        <a href="../../admin/index.php">Головна</a>
        <a href="../../trainer/admin/index.php">Тренери</a>
        <a href="../../lessons/index.php">Заняття</a>
        <a href="index.php">Інтернет-магазин</a>
        <a href="../../schedule.php">Розклад</a>
        <form action="" method="post" >
            <button type="submit" class="exit_account" name="exit_account">Вихід</button>
        </form>
    </div>

    <div class="container">
        <h1>Керування замовленнями</h1>
        <form action="" method="get" class="filter-form">
            <label for="user_id">Фільтрувати за користувачем:</label>
            <select name="user_id" id="user_id">
                <option value="">Всі користувачі</option>
                <?php while ($user = mysqli_fetch_assoc($users_result)): ?>
                    <option value="<?php echo $user['user_id']; ?>" <?php if (isset($user_id) && $user_id == $user['user_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($user['username']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit" style="cursor:pointer;">Фільтрувати</button>
        </form>

        <?php if (mysqli_num_rows($orders_result) > 0): ?>
            <?php while ($order = mysqli_fetch_assoc($orders_result)): ?>
                <div class="order-card">
                    <h2>Замовлення №<?php echo htmlspecialchars($order['order_id']); ?></h2>
                    <p><strong>Користувач:</strong> <?php echo htmlspecialchars($order['username']); ?></p>
                    <p><strong>Загальна сума:</strong> <?php echo htmlspecialchars($order['total']); ?> грн</p>
                    <p><strong>Дата замовлення:</strong> <?php echo htmlspecialchars($order['created_at']); ?></p>
                    <h3>Деталі замовлення:</h3>
                    <ul>
                        <?php
                        $order_id = $order['order_id'];
                        $order_items_query = "
                            SELECT products.name, products.image, OrderItems.quantity, OrderItems.price
                            FROM OrderItems
                            JOIN products ON OrderItems.product_id = products.product_id
                            WHERE OrderItems.order_id = ?
                        ";
                        $stmt_items = $connect->prepare($order_items_query);
                        $stmt_items->bind_param("i", $order_id);
                        $stmt_items->execute();
                        $order_items_result = $stmt_items->get_result();
                        $stmt_items->close();

                        while ($item = $order_items_result->fetch_assoc()) {
                            echo "<li class='product-details'>";
                            echo "<img src='../../images/products/" . htmlspecialchars($item['image']) . "' alt='Зображення товару' class='product-image' style='max-width: 50px; max-height: 50px; margin-right: 10px;'>";
                            echo htmlspecialchars($item['name']) . " - " . htmlspecialchars($item['quantity']) . " x " . htmlspecialchars($item['price']) . " грн";
                            echo "</li>";
                        }
                        ?>
                    </ul>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Замовлень не знайдено.</p>
        <?php endif; ?>
    </div>
</body>
</html>
