<?php
session_start();
include("../include/db_connect.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

if (isset($_GET['date'])) {
    $current_date = $_GET['date'];
} else {
    $current_date = date('Y-m-d');
}

$previous_date = date('Y-m-d', strtotime($current_date . ' -1 day'));
$next_date = date('Y-m-d', strtotime($current_date . ' +1 day'));

$user_name = '';

$user_query = "SELECT username FROM Users WHERE user_id = $user_id";
$user_result = mysqli_query($connect, $user_query);
if ($user_result) {
    $user_row = mysqli_fetch_assoc($user_result);
    $user_name = $user_row['username'];
}

$schedule_query = "
    SELECT 
        Time.hour as ttime,
        Lessons.title as lessonname
    FROM 
        Registrations
    LEFT JOIN 
        Lessons ON Registrations.class_id = Lessons.class_id
    LEFT JOIN 
        Time ON Lessons.hour_id = Time.time_id
    WHERE 
        Registrations.registration_date = '$current_date' AND Registrations.user_id = $user_id
    ORDER BY 
        Time.hour;
";
$schedule_result = mysqli_query($connect, $schedule_query);
$schedule = [];
while ($row = mysqli_fetch_assoc($schedule_result)) {
    $schedule[$row['ttime']] = $row['lessonname'];
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
    <link rel="stylesheet" href="../css/styles.css">
    <title>Мій розклад  <?php echo htmlspecialchars($user_name); ?></title>
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
            <h1>Мій розклад</h1>
            <h2>Розклад для користувача: <?php echo htmlspecialchars($user_name); ?></h2>
        </div>
    <div class="modal-body">
        <div>
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hours as $hour): ?>
                            <tr>
                                <td><?php echo $hour; ?></td>
                                <td><?php echo isset($schedule[$hour]) ? htmlspecialchars($schedule[$hour]) : 'Вільно'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

</body>
</html>
