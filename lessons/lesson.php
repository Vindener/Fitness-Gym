<?php
session_start();
include("../include/db_connect.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$class_id = $_GET['id'];

$query = "SELECT * FROM Lessons WHERE class_id  = ?";
$stmt = $connect->prepare($query);
$stmt->bind_param("i", $class_id);
$stmt->execute();
$result = $stmt->get_result();
$lesson = $result->fetch_assoc();
$stmt->close();

$lessons_query = "
    SELECT Lessons.class_id, Lessons.title, Lessons.description, Trainers.name AS trainer_name, Time.hour
    FROM Lessons
    JOIN Trainers ON Lessons.trainer_id = Trainers.trainer_id
    JOIN Time ON Lessons.hour_id = Time.time_id
    WHERE Lessons.class_id = ?
";
$stmt = $connect->prepare($lessons_query);
$stmt->bind_param("i", $class_id);
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
    <title><?php echo htmlspecialchars($lesson['title']); ?></title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="navbar">
        <a href="../admin/index.php">Головна</a>
        <a href="../trainer/index.php">Тренери </a>
        <a href="index.php">Заняття</a>
        <a href="../shop/index.php">Інтернет-магазин </a>
        <a href="../schedule.php">Розклад</a>
        <form action="" method="post" >
            <button type="submit" class="exit_account" name="exit_account">Вихід</button>
        </form>
    </div>

    <div class="welcome">
    <h1><?php echo htmlspecialchars($lesson['title']); ?></h1>
    </div>
    <div class="container">
    <div class="trainer-card">
        <ul class="lesson-list">
            <li><strong>Опис:</strong> <?php echo nl2br(htmlspecialchars($lesson['description'])); ?></li>
            <?php
            if ($lessons_result->num_rows > 0) {
                while ($lesson = $lessons_result->fetch_assoc()) {
                    echo "<li><strong>На котру:</strong> " . htmlspecialchars($lesson['hour']) . " годину.</li>";
                    echo "<li><strong>Тренер:</strong> " . htmlspecialchars($lesson['trainer_name']) . "</li>";
                }
            } else {
                echo "<li>Цей тренер ще не має запланованих занять.</li>";
            }
            ?>
        </ul>
        <div class="section-links">
        <a href="index.php">Повернутися до списку</a>
        </div>
    </div>
    </div>
</body>
</html>
