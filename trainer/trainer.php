<?php
session_start();
include("../include/db_connect.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$trainer_id = $_GET['id'];

$trainer_query = "SELECT * FROM Trainers WHERE trainer_id = ?";
$stmt = $connect->prepare($trainer_query);
$stmt->bind_param("i", $trainer_id);
$stmt->execute();
$trainer_result = $stmt->get_result();
$trainer = $trainer_result->fetch_assoc();
$stmt->close();

$lessons_query = "
    SELECT Lessons.class_id, Lessons.title, Lessons.description, Trainers.name AS trainer_name, Time.hour
    FROM Lessons
    JOIN Trainers ON Lessons.trainer_id = Trainers.trainer_id
    JOIN Time ON Lessons.hour_id = Time.time_id
    WHERE Lessons.class_id = ?
";
$stmt = $connect->prepare($lessons_query);
$stmt->bind_param("i", $trainer_id);
$stmt->execute();
$lessons_result = $stmt->get_result();
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
    <title><?php echo htmlspecialchars($trainer['name']); ?></title>
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
            <a href="../users/index.php">Мій кабінет </a>
            <form action="" method="post" style="display: inline;">
                <button type="submit" name="exit_account" class="exit_account">Вихід</button>
            </form>
        <?php else: ?>
            <a href="../users/login.php">Увійти</a>
            <a href="../users/registration.php">Регістрація</a>
        <?php endif; ?>
    </div>
    <div class="welcome">
    <h1><?php echo htmlspecialchars($trainer['name']); ?></h1>
    <?php if ($trainer['photo']): ?>
            <img class="trainer-card-img" src="../images/trainer/<?php echo htmlspecialchars($trainer['photo']); ?>" alt="<?php echo htmlspecialchars($trainer['name']); ?>">
        <?php endif; ?>
    </div>
    <div class="container">
    <div class="trainer-card">
        <p>Опис тренера: <?php echo nl2br(htmlspecialchars($trainer['bio'])); ?></p>
        <h3>Заняття:</h3>
        <ul class="lesson-list">
            <?php
            if ($lessons_result->num_rows > 0) {
                while ($lesson = $lessons_result->fetch_assoc()) {
                    echo "<li><strong>" . htmlspecialchars($lesson['title']) . ":</strong> " . htmlspecialchars($lesson['hour']) . "</li>";
                }
            } else {
                echo "<li>Цей тренер ще не має запланованих занять.</li>";
            }
            ?>
        </ul>
        <div class="section-links">
        <a href="index.php">Повернутися до списку тренерів</a>
        </div>
    </div>
    </div>
</body>
</html>
