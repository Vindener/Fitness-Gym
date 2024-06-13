<?php
session_start();
include("../include/db_connect.php");

if (isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['remove_from_cart'];
    unset($_SESSION['cart'][$product_id]);
}

if(isset($_POST['check_cart'])){
foreach ($_POST['quantities'] as $product_id => $quantity) {
        if ($quantity == 0) {
            unset($_SESSION['cart'][$product_id]);
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
    }
    header("Location: checkout.php");
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

function truncateDescription($description, $length = 50) {
    if (strlen($description) > $length) {
        return substr($description, 0, $length) . '...';
    } else {
        return $description;
    }
}

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
    <title>Кошик інтернет-магазину фітнес-залу</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/cart.js"></script>
</head>
<body>
    <div class="navbar">
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
    <div class="container">
    <div class="welcome">
    <h1>Кошик</h1>
    </div>
    <div class="trainer-card cart">
        <div class="section-links">
        <a href="index.php">Повернутися до магазину</a>
        </div> 
     <?php
        if (!empty($cart_items)) {
            echo "<form action='' method='post'>";
            echo "<table>";
            echo "<tr><th>Зображення</th><th>Назва</th><th>Опис</th><th>Ціна</th><th>Кількість</th><th>Сума</th><th>Дії</th></tr>";
            $total = 0;
            foreach ($cart_items as $item) {
                $quantity = $_SESSION['cart'][$item['product_id']];
                $subtotal = $item['price'] * $quantity;
                $total += $subtotal;
                $description = truncateDescription($item['description'], 50); // Обрізка опису
                echo "<tr>";
                echo "<td><img src='../images/products/" . htmlspecialchars($item['image']) . "' alt='Зображення товару' class='product-image'></td>";
                echo "<td>" . htmlspecialchars($item['name']) . "</td>";
                echo "<td class='product-description'>" . htmlspecialchars($description) . "</td>";
                echo "<td>" . htmlspecialchars($item['price']) . " грн</td>";
                echo "<td><input type='number' name='quantities[" . $item['product_id'] . "]' value='$quantity' min='0' id='quantity-" . $item['product_id'] . "' oninput='updateSubtotal(" . $item['product_id'] . ", " . $item['price'] . ")'></td>";
                echo "<td class='subtotal' id='subtotal-" . $item['product_id'] . "'>" . htmlspecialchars($subtotal) . " грн</td>";
                echo "<td>";
                echo "<button type='submit' name='remove_from_cart' value='" . $item['product_id'] . "'>Видалити</button>";
                echo "</td>";
                echo "</tr>";
            }
            echo "<tr><td colspan='5'>Загальна сума</td><td id='total'>" . htmlspecialchars($total) . " грн</td><td></td></tr>";
            echo "</table>";
            echo "<button type='submit' name='update_cart'>Оновити кошик</button>";
            echo "</form>";
            echo "<a href='checkout.php'>Оформити замовлення</a>";
        } else {
            echo "<p>Ваш кошик порожній.</p>";
        }
    ?>
    </div>
    </div>
</body>
</html>
