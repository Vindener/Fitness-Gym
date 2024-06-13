<?php
session_start();
include("../include/db_connect.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

if (isset($_POST['submit_review'])) {
    $class_id = $_POST['class_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $stmt = $connect->prepare("INSERT INTO reviews (user_id, class_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $user_id, $class_id, $rating, $comment);
    if ($stmt->execute()) {
        echo "<script>alert(\"Відгук успішно додано.\");
            location.href='../index.php';
            </script>"; 
    } else {
        echo "<script>alert(\"Помилка при додаванні відгуку!\");
            location.href='../index.php';
            </script>"; 
    }
    $stmt->close();
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
    <title>Додати відгук</title>
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
                <button type="submit" class="exit_account"  name="exit_account">Вихід</button>
            </form>
        <?php else: ?>
            <a href="login.php">Увійти</a>
            <a href="registration.php">Регістрація</a>
        <?php endif; ?>
    </div>
    <div class="container">
        <div class="welcome">
        <h1>Додати відгук</h1>
        </div>
        <div class="trainer-card">
    <form action="" method="post">
    <div class="container-login">        
        <label for="class_id">Виберіть заняття:</label>
        <select name="class_id" id="class_id" required>
            <option value="">Виберіть заняття</option>
            <?php
            $query = "SELECT * FROM Lessons";
            $result = mysqli_query($connect, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['class_id'] . '">' . htmlspecialchars($row['title']) . '</option>';
            }
            ?>
        </select>
        <br>

        <label for="rating">Оцініть заняття:</label>
        <select name="rating" id="rating" required>
            <option value="">Оберіть оцінку</option>
            <option value="1">1 - Погано</option>
            <option value="2">2 - Незадовільно</option>
            <option value="3">3 - Задовільно</option>
            <option value="4">4 - Добре</option>
            <option value="5">5 - Відмінно</option>
        </select>
        <br>

        <label for="comment">Коментар:</label>
        <textarea name="comment" id="comment" rows="4" cols="50" placeholder="Ваш коментар"></textarea>
        <br>

        <button type="submit" name="submit_review" class="check_cart" >Додати відгук</button>
    </div>
    </form>
    </div>
    </div>
</body>
</html>
