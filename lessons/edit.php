<?php
session_start();
include("../include/db_connect.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}
$class_id = $_GET['id'];

$lesson_query = "
    SELECT Lessons.title, Lessons.description, Lessons.trainer_id, Lessons.hour_id
    FROM Lessons
    WHERE Lessons.class_id = ?
";
$stmt = $connect->prepare($lesson_query);
$stmt->bind_param("i", $class_id);
$stmt->execute();
$lesson_result = $stmt->get_result();
$lesson = $lesson_result->fetch_assoc();
$stmt->close();

$trainers_query = "SELECT trainer_id, name FROM Trainers";
$trainers_result = mysqli_query($connect, $trainers_query);

$time_query = "SELECT time_id, hour FROM Time";
$time_result = mysqli_query($connect, $time_query);

if (isset($_POST['update_lesson'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $trainer_id = $_POST['trainer_id'];
    $hour_id = $_POST['hour_id'];

    $stmt = $connect->prepare("UPDATE Lessons SET title = ?, description = ?, trainer_id = ?, hour_id = ? WHERE class_id = ?");
    $stmt->bind_param("ssiii", $title, $description, $trainer_id, $hour_id, $class_id);
    if ($stmt->execute()) {
        $stmt->close();
         echo "<script>alert(\"Заняття успішно оновлено!\");
            location.href='index.php';
            </script>"; 
    } else {
        echo "<script>alert(\"Помилка при додаванні заняття: " . $stmt->error."\");
            </script>"; 
    }
    $stmt->close();

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
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редагування заняття - <?php echo htmlspecialchars($lesson['title']); ?></title>
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
        <h1>Редагувати заняття <?php echo htmlspecialchars($lesson['title']); ?></h1>
    </div>
    <div class="container">
    <div class="trainer-card">
    <form action="" method="post"  class="container-login">
        <label for="title">Назва заняття:</label>
        <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($lesson['title']); ?>" required>
        <br>
        <label for="description">Опис:</label>
        <textarea name="description" id="description" rows="4" cols="50" required><?php echo htmlspecialchars($lesson['description']); ?></textarea>
        <br>
        <label for="trainer_id">Тренер:</label>
        <select name="trainer_id" id="trainer_id" required>
            <?php while ($trainer = mysqli_fetch_assoc($trainers_result)): ?>
                <option value="<?php echo $trainer['trainer_id']; ?>" <?php if ($trainer['trainer_id'] == $lesson['trainer_id']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($trainer['name']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <br>
        <label for="hour_id">Час заняття:</label>
        <select name="hour_id" id="hour_id" required>
            <?php while ($time = mysqli_fetch_assoc($time_result)): ?>
                <option value="<?php echo $time['time_id']; ?>" <?php if ($time['time_id'] == $lesson['hour_id']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($time['hour']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <br>
        <button type="submit" name="update_lesson" class="check_cart">Оновити заняття</button>
    </form>
    </div>
    </div>
</body>
</html>
