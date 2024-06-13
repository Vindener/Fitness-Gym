<?php
session_start();
if ($_SESSION['auth'] != "admin") {
  echo "<script>alert(\"Доступ заборонений!\");
            location.href='../index.php';
            </script>"; 
} else {
  include("../../include/db_connect.php");
  $sel = mysqli_query($connect, "SELECT * FROM `Trainers`  GROUP BY trainer_id");
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
    <link rel="stylesheet" href="../../css/styles.css">
    <script src="../../js/delete.js"></script>
    <title>Адміністрування - тренерів</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
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
            <h2>Тренери</h2>
            <p>Тут можна редагувати та переглядати тренерів фітнес-залу.</p>
        </div>
         
    
    <div class="trainer-card">
<div class="section-links">
            <a href="add.php">Додати тренера</a>
            <a href="schedule.php">Переглянути заняття тренерів</a>
        </div> 
    <div class="spisok-table">
    <table class="admin_table">
      <tr>
        <th width="25px">Індекс</th>
        <th width="125px">ПІБ</th>
        <th width="300px">БІО</th>
        <th>Фото</th>
        <th>Перегляд</th>
        <th>Редагування</th>
        <th>Видалення</th>
      </tr>
      <?php
      do {
        echo '
                    <tr>
                    <td>' . $row['trainer_id'] . '</td>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row['bio'] . '</td>';
        if($row['photo']!=null){
          echo'<td><img src="../../images/trainer/' . $row['photo'] . '" width="44px" heigth="44px" ></td>';
        }
        else{
          echo '<td></td>';
        }
        echo'
                    <td><a class="admin-links" href="../trainer.php?id=' . $row['trainer_id'] . '">Перегляд</a></td>
                    <td><a class="admin-links" href="edit.php?id=' . $row['trainer_id'] . '">Редагування</a></td>
                    <td><a class="admin-links" href="vendor\delete.php?id=' . $row['trainer_id'] . '" onclick="return ConfirmDelete()">Видалення</a></td>
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