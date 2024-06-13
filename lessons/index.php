<?php
session_start();
if ($_SESSION['auth'] != "admin") {
  echo "<script>alert(\"Доступ заборонений!\");
            location.href='../index.php';
            </script>"; 
} else {
  include("../include/db_connect.php");
  $sel = mysqli_query($connect, "SELECT Lessons.class_id, Lessons.title, Lessons.description, Trainers.name AS trainer_name, Time.hour
    FROM Lessons
    JOIN Trainers ON Lessons.trainer_id = Trainers.trainer_id
    JOIN Time ON Lessons.hour_id = Time.time_id");
  $num_rows = mysqli_num_rows($sel);
  $row = mysqli_fetch_assoc($sel);
  mysqli_close($connect);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/delete.js"></script>
    <title>Адміністрування - занять</title>
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
            <h2>Заняття</h2>
            <p>Тут можна редагувати та переглядати заняття фітнес-залу.</p>
        </div>
         
    
    <div class="trainer-card">
<div class="section-links">
            <a href="add.php">Додати заняття</a>
        </div> 
    <div class="spisok-table">
    <table class="admin_table">
      <tr>
        <th width="25px">Індекс</th>
        <th width="125px">Назва</th>
        <th width="300px">Опис</th>
        <th width="300px">Тренер</th>
        <th width="300px">На котру</th>
        <th>Перегляд</th>
        <th>Редагування</th>
        <th>Видалення</th>
      </tr>
      <?php
      do {

        echo '
                    <tr>
                    <td>' . $row['class_id'] . '</td>
                    <td>' . $row['title'] . '</td>
                    <td>' . $row['description'] . '</td>
                    <td>' . $row['trainer_name'] . '</td>
                    <td>' . $row['hour'] . ' годину</td>
                    <td><a class="admin-links" href="lesson.php?id=' . $row['class_id'] . '">Перегляд</a></td>
                    <td><a class="admin-links" href="edit.php?id=' . $row['class_id'] . '">Редагування</a></td>
                    <td><a class="admin-links" href="vendor\delete.php?id=' . $row['class_id'] . '" onclick="return ConfirmDelete()">Видалення</a></td>
                    </tr>
                    ';
      } while ($row = mysqli_fetch_assoc($sel));
      ?>
    </table>
  </div>
  </div>
  </div>
</body>
</html>