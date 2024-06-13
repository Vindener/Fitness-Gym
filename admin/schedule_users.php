<?php
session_start();
if ($_SESSION['auth'] != "admin") {
  echo "<script>alert(\"Доступ заборонений!\");
            location.href='../index.php';
            </script>"; 
}
include("../include/db_connect.php");

$users_query = "SELECT user_id, username FROM Users";
$users_result = mysqli_query($connect, $users_query);

if (isset($_GET['date'])) {
    $current_date = $_GET['date'];
} else {
    $current_date = date('Y-m-d');
}

$previous_date = date('Y-m-d', strtotime($current_date . ' -1 day'));
$next_date = date('Y-m-d', strtotime($current_date . ' +1 day'));

$user_name = '';

$schedule = [];
if (isset($_POST['user_id']) || isset($_GET['user_id'])) {
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : $_GET['user_id'];
    
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
    while ($row = mysqli_fetch_assoc($schedule_result)) {
        $schedule[$row['ttime']] = $row['lessonname'];
    }

    $time_query = "SELECT hour FROM Time ORDER BY hour";
    $time_result = mysqli_query($connect, $time_query);
    $hours = [];
    while ($row = mysqli_fetch_assoc($time_result)) {
        $hours[] = $row['hour'];
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Розклад користувачів</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>
<body>
   <div class="navbar">
        <a href="index.php">Головна</a>
        <a href="../trainer/admin/index.php">Тренери</a>
        <a href="../lessons/index.php">Заняття</a>
        <a href="../shop/admin/index.php">Інтернет-магазин</a>
        <a href="../schedule.php">Розклад</a>
        <form action="" method="post" >
            <button type="submit" class="exit_account" name="exit_account">Вихід</button>
        </form>
    </div>

    <div class="container">
        <div class="welcome">
            <h1>Вибір користувача</h1>
            <p>Тут можно подивитися розклад занять для конкретного користувача.</p>
    </div>

    <div class="modal-body">
        <div>
            <form action="" method="post">
                <label for="user_id"><b>Виберіть користувача:</b></label>
                <select name="user_id" id="user_id" required>
                    <option value="">Виберіть користувача</option>
                    <?php
                    while ($row = mysqli_fetch_assoc($users_result)) {
                        echo '<option value="' . $row['user_id'] . '">' . htmlspecialchars($row['username']) . '</option>';
                    }
                    ?>
                </select>
                <button type="submit" class="check_cart">Показати розклад</button>
            </form>
            <hr />
            
            <?php if (isset($user_id)): ?>
                <h2>Розклад для користувача: <?php echo htmlspecialchars($user_name); ?></h2>
                <div class="schedule-container">
                    <div class="date-navigation">
                        <a href="?date=<?php echo $previous_date; ?>&user_id=<?php echo $user_id; ?>">&#9664; Попередній день</a>
                        <span><?php echo date('d F Y', strtotime($current_date)); ?></span>
                        <a href="?date=<?php echo $next_date; ?>&user_id=<?php echo $user_id; ?>">Наступний день &#9654;</a>
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
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
