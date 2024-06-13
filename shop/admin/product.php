<?php
session_start();
include("../../include/db_connect.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$product_id = $_GET['id'];

$product_query = "
    SELECT name, description, price, image
    FROM products
    WHERE product_id = ?
";
$stmt = $connect->prepare($product_query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product_result = $stmt->get_result();
$product = $product_result->fetch_assoc();
$stmt->close();

if (!$product) {
    header("Location: shop.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/styles.css">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
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

    <div class="welcome">
    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
    <?php if ($product['image']): ?>
            <img class="trainer-card-img" src="../../images/products/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($trainer['name']); ?>">
        <?php endif; ?>
    </div>
   
    <div class="container">
        <div class="trainer-card">
            <p></p><strong>Опис: </strong><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            <p><strong>Ціна: </strong> <?php echo htmlspecialchars($product['price']); ?> грн.</p>
            <a href="index.php" class="check_cart">Повернутися до магазину</a>
        </div>
    </div>
</body>
</html>
