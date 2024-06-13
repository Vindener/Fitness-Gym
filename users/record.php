<?php
session_start();
include("../include/db_connect.php");

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
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
    <title>Запис на тренування</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <script src="../js/loadHour.js"></script>
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
    <h1>Запис на тренування</h1>
    </div>
    <div class="trainer-card">
    <form action="../include/register_record.php" method="post" class="container-login">
        <label for="class_id">Виберіть тренування:</label>
        <select name="class_id" id="class_id" onchange="loadHour()" required>
            <option value="">Виберіть тренування</option>
            <?php
            $query = "SELECT * FROM Lessons";
            $result = mysqli_query($connect, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['class_id'] . '">' . htmlspecialchars($row['title']) . '</option>';
            }
            ?>
        </select>
        <span id="class_hour"></span>
        <br>

        <input type="date" id="registration_date" name="registration_date" required>
        <br>

        <button type="submit" class="check_cart">Записатися</button>
    </form>
    </div>
    </div>

</body>
</html>
