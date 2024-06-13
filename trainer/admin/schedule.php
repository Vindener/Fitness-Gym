<?php
session_start();
include("../../include/db_connect.php");

$trainers_query = "SELECT trainer_id, name FROM Trainers";
$trainers_result = mysqli_query($connect, $trainers_query);

if (isset($_GET['date'])) {
    $current_date = $_GET['date'];
} else {
    $current_date = date('Y-m-d');
}

$previous_date = date('Y-m-d', strtotime($current_date . ' -1 day'));
$next_date = date('Y-m-d', strtotime($current_date . ' +1 day'));

$trainer_name = '';

$schedule = [];
if (isset($_POST['trainer_id']) || isset($_GET['trainer_id'])) {
    $trainer_id = isset($_POST['trainer_id']) ? $_POST['trainer_id'] : $_GET['trainer_id'];
    
    // Отримання імені тренера
    $trainer_query = "SELECT name FROM Trainers WHERE trainer_id = $trainer_id";
    $trainer_result = mysqli_query($connect, $trainer_query);
    if ($trainer_result) {
        $trainer_row = mysqli_fetch_assoc($trainer_result);
        $trainer_name = $trainer_row['name'];
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
            Registrations.registration_date = '$current_date' AND Lessons.trainer_id = $trainer_id
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Розклад тренерів</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body>
    <div class="navbar">
        <a href="../../admin/index.php">Головна</a>
        <a href="index.php">Тренери </a>
        <a href="../../lessons/index.php">Заняття</a>
        <a href="../../shop/index.php">Інтернет-магазин </a>
        <a href="../../schedule.php">Розклад</a>
        <form action="" method="post" >
            <button type="submit" class="exit_account" name="exit_account">Вихід</button>
        </form>
    </div>
    <div class="container">
        <div class="welcome">
            <h1>Вибір тренера</h1>
            <p>Тут можно подивитися розклад занять для конкретного тренера.</p>
    </div>

    <div class="modal-body">
        <div>
            <h1>Вибір тренера</h1>
            <form action="" method="post">
                <label for="trainer_id"><b>Виберіть тренера:</b></label>
                <select name="trainer_id" id="trainer_id" required>
                    <option value="">Виберіть тренера</option>
                    <?php
                    while ($row = mysqli_fetch_assoc($trainers_result)) {
                        echo '<option value="' . $row['trainer_id'] . '">' . htmlspecialchars($row['name']) . '</option>';
                    }
                    ?>
                </select>
                <button type="submit" class="registerbtn">Показати розклад</button>
            </form>
            <hr />
            
            <?php if (isset($trainer_id)): ?>
                <h2>Розклад для тренера: <?php echo htmlspecialchars($trainer_name); ?></h2>
                <div class="schedule-container">
                    <div class="date-navigation">
                        <a href="?date=<?php echo $previous_date; ?>&trainer_id=<?php echo $trainer_id; ?>">&#9664; Попередній день</a>
                        <span><?php echo date('d F Y', strtotime($current_date)); ?></span>
                        <a href="?date=<?php echo $next_date; ?>&trainer_id=<?php echo $trainer_id; ?>">Наступний день &#9654;</a>
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
