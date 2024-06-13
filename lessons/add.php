<?php
session_start();

if ($_SESSION['auth'] != "admin") {
  echo "<script>alert(\"Доступ заборонений!\");
            location.href='../index.php';
            </script>"; 
} else {
  include("../include/db_connect.php");
  if (isset($_POST['add_lesson'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $trainer_id = $_POST['trainer_id'];
    $hour_id = $_POST['hour_id'];

    $stmt = $connect->prepare("INSERT INTO Lessons (title, description, trainer_id, hour_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $title, $description, $trainer_id, $hour_id);
    if ($stmt->execute()) {
        echo "<script>alert(\"Заняття успішно додано!\");
            location.href='index.php';
            </script>"; 
    } else {
        echo "<script>alert(\"Помилка при додаванні заняття: " . $stmt->error."\");
            </script>"; 
    }
    $stmt->close();
    }

    $trainers_query = "SELECT trainer_id, name FROM Trainers";
    $trainers_result = mysqli_query($connect, $trainers_query);

    $time_query = "SELECT time_id, hour FROM Time";
    $time_result = mysqli_query($connect, $time_query);

    $lessons_query = "
        SELECT Lessons.title, Lessons.description, Trainers.name AS trainer_name, Time.hour
        FROM Lessons
        JOIN Trainers ON Lessons.trainer_id = Trainers.trainer_id
        JOIN Time ON Lessons.hour_id = Time.time_id
    ";
    $lessons_result = mysqli_query($connect, $lessons_query);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Створення заняття</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
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

    <div class="container">
        <div class="welcome">
            <h2>Створення Заняття </h2>
            <p>Тут можна створити нове заняття фітнес-залу.</p>
        </div>
    <div class="trainer-card">

    <div class="modal-body">
        <form action="" method="post" class="container-login">
        <label for="title">Назва заняття:</label>
        <input type="text" name="title" id="title" required>
        <br>
        <label for="description">Опис:</label>
        <textarea name="description" id="description" rows="4" cols="50" required></textarea>
        <br>
        <label for="trainer_id">Тренер:</label>
        <select name="trainer_id" id="trainer_id" required>
            <?php while ($trainer = mysqli_fetch_assoc($trainers_result)): ?>
                <option value="<?php echo $trainer['trainer_id']; ?>"><?php echo htmlspecialchars($trainer['name']); ?></option>
            <?php endwhile; ?>
        </select>
        <br>
        <label for="hour_id">Час заняття:</label>
        <select name="hour_id" id="hour_id" required>
            <?php while ($time = mysqli_fetch_assoc($time_result)): ?>
                <option value="<?php echo $time['time_id']; ?>"><?php echo htmlspecialchars($time['hour']); ?></option>
            <?php endwhile; ?>
        </select>
        <br>
        <button type="submit" name="add_lesson" class="check_cart">Додати заняття</button>
    </form>
    </div>
</body>
</html>