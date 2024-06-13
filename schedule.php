<?php
session_start();
require 'include/db_connect.php'; 

if (isset($_SESSION['id'])&&$_SESSION['auth'] != "admin") {
    header("Location: users/schedule.php");
    exit();
}

if (isset($_GET['date'])) {
    $current_date = $_GET['date'];
} else {
    $current_date = date('Y-m-d');
}

$previous_date = date('Y-m-d', strtotime($current_date . ' -1 day'));
$next_date = date('Y-m-d', strtotime($current_date . ' +1 day'));

$schedule_query = "
    SELECT 
        Time.hour as ttime,
        Lessons.title as lessonname,
        Trainers.name as tname
    FROM 
        Registrations
    LEFT JOIN 
        Lessons ON Registrations.class_id = Lessons.class_id
    LEFT JOIN 
        Time ON Lessons.hour_id = Time.time_id
    LEFT JOIN 
        Trainers ON Lessons.trainer_id = Trainers.trainer_id
    WHERE 
        Registrations.registration_date = '$current_date'
    ORDER BY 
        Time.hour;
";

$schedule_result = mysqli_query($connect, $schedule_query);
if (!$schedule_result) {
    die("Помилка запиту: " . mysqli_error($connect));
}

$schedule = [];
while ($row = mysqli_fetch_assoc($schedule_result)) {
    $schedule[$row['ttime']] = ['title' => $row['lessonname'], 'trainer' => $row['tname']];
}

$time_query = "SELECT hour FROM Time ORDER BY hour";
$time_result = mysqli_query($connect, $time_query);
$hours = [];
while ($row = mysqli_fetch_assoc($time_result)) {
    $hours[] = $row['hour'];
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
    <link rel="stylesheet" href="css/styles.css">
    <title>Розклад фітнес-залу</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>
<body>
    <div class="navbar">
        <a href="index.php">Головна</a>
        <a href="trainer/index.php">Тренери</a>
        <a href="shop/index.php">Інтернет-магазин</a>
        <a href="blog/index.php">Блог</a>
        <a href="schedule.php">Розклад</a>
        <?php if ($user_logged_in): ?>
            <a href="users/index.php">Мій кабінет </a>
            <form action="" method="post" style="display: inline;">
                <button type="submit" name="exit_account" class="exit_account">Вихід</button>
            </form>
        <?php else: ?>
            <a href="users/login.php">Увійти</a>
            <a href="users/registration.php">Регістрація</a>
        <?php endif; ?>
    </div>
    <div class="schedule-container">
        <div class="date-navigation">
            <a href="?date=<?php echo $previous_date; ?>">&#9664; Попередній день</a>
            <span><?php echo date('d F Y', strtotime($current_date)); ?></span>
            <a href="?date=<?php echo $next_date; ?>">Наступний день &#9654;</a>
        </div>
        <table class="schedule-table">
            <thead>
                <tr>
                    <th>Час</th>
                    <th>Заняття</th>
                    <th>Тренер</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hours as $hour): ?>
                    <tr>
                        <td><?php echo $hour; ?></td>
                        <td><?php echo isset($schedule[$hour]['title']) ? htmlspecialchars($schedule[$hour]['title']) : 'Вільно'; ?></td>
                        <td><?php echo isset($schedule[$hour]['trainer']) ? htmlspecialchars($schedule[$hour]['trainer']) : '-'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
