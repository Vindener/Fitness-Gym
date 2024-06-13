<?php
session_start();
include("../../include/db_connect.php");

if (!isset($_SESSION['id']) || ($_SESSION['access'] != 2 && $_SESSION['access'] != 3)) {
    echo "<script>alert(\"Доступ заборонений!\");
            location.href='index.php';
            </script>"; 
}

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

if (isset($_POST['update_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $product['image']; 

    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../../images/products/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = basename($_FILES["image"]["name"]);
        } 
    }

    $stmt = $connect->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE product_id = ?");
    $stmt->bind_param("ssdsi", $name, $description, $price, $image, $product_id);
    if ($stmt->execute()) {
        echo "Товар успішно оновлено.";
    } else {
        echo "Помилка при оновленні товару: " . $stmt->error;
    }
    $stmt->close();

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/styles.css">
    <title>Редагувати товар</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>
<body>
    <<div class="navbar">
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
        <div class="welcome">
            <h2>Редагування товару - <?php echo htmlspecialchars($product['name']); ?></h2>
        </div>
    <div class="trainer-card">
    <form action="" method="post" enctype="multipart/form-data" class="container-login">
        <label for="name">Назва товару:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        <br>
        <label for="description">Опис:</label>
        <textarea name="description" id="description" rows="4" cols="50" required><?php echo htmlspecialchars($product['description']); ?></textarea>
        <br>
        <label for="price">Ціна:</label>
        <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" step="0.01" required>
        <br>
        <label for="image">Фотографія:</label>
        <?php if (!empty($product['image'])): ?>
            <img src="../../images/products/<?php echo htmlspecialchars($product['image']); ?>" alt="Фотографія товару" class="product-image">
            <br>
        <?php endif; ?>
        <input type="file" name="image" id="image" accept="image/*">
        <br>
        <button type="submit" name="update_product" class="check_cart">Оновити товар</button>
    </form>
    </div></div>
</body>
</html>
