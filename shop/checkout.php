<?php
session_start();
include("../include/db_connect.php");

if (!isset($_SESSION['id'])) {
    header("Location: ../users/login.php");
    exit();
}

$cart_items = [];
if (!empty($_SESSION['cart'])) {
    $product_ids = array_keys($_SESSION['cart']);
    $product_ids_str = implode(',', $product_ids);
    $products_query = "SELECT * FROM products WHERE product_id IN ($product_ids_str)";
    $products_result = mysqli_query($connect, $products_query);

    while ($row = mysqli_fetch_assoc($products_result)) {
        $cart_items[] = $row;
    }
}

if (isset($_POST['checkout'])) {
    $user_id = $_SESSION['id'];
    $total_price = $_POST['total_price'];

    $stmt = $connect->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
    $stmt->bind_param("id", $user_id, $total_price);
    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;
        $stmt->close();

     $stmt = $connect->prepare("INSERT INTO OrderItems (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
     foreach ($cart_items as $item) {
        $product_id = $item['product_id'];
        $quantity = $_SESSION['cart'][$product_id];
        $price = $item['price'];
        $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
        if (!$stmt->execute()) {
            die("Помилка виконання запиту для вставки елемента замовлення: " . $stmt->error);
        }
    }
    $stmt->close();
    unset($_SESSION['cart']);
    echo "<script>alert(\"Ваше замовлення успішно оформлено!\");
            location.href='orders.php';
            </script>"; 
    } else {
        $stmt->close();
        echo "<script>alert(\"Помилка при оформленні замовлення.\");
            location.href='orders.php';
            </script>"; 
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Оформлення замовлення</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>
<body>
    <div class="navbar">
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
    <div class="container">
    <div class="welcome">
        <h1>Оформлення замовлення</h1>
    </div>
        <div class="trainer-card cart">
        <?php
        if (!empty($cart_items)) {
            $total = 0;
            echo "<table>";
            echo "<tr><th>Назва</th><th>Ціна</th><th>Кількість</th><th>Сума</th></tr>";
            foreach ($cart_items as $item) {
                $quantity = $_SESSION['cart'][$item['product_id']];
                $subtotal = $item['price'] * $quantity;
                $total += $subtotal;
                echo "<tr>";
                echo "<td>" . htmlspecialchars($item['name']) . "</td>";
                echo "<td>" . htmlspecialchars($item['price']) . " грн</td>";
                echo "<td>" . htmlspecialchars($quantity) . "</td>";
                echo "<td>" . htmlspecialchars($subtotal) . " грн</td>";
                echo "</tr>";
            }
            echo "<tr><td colspan='3'>Загальна сума</td><td>" . htmlspecialchars($total) . " грн</td></tr>";
            echo "</table>";
            echo "<form action='' method='post'>";
            echo "<input type='hidden' name='total_price' value='$total'>";
            echo "<button type='submit' name='checkout' class='check_cart'>Оформити замовлення</button>";
            echo "</form>";
        } else {
            echo "<p>Ваш кошик порожній.</p>";
        }
        ?>
        </div>
    </div>
</body>
</html>
