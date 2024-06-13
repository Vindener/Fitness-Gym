<?php
session_start();
if (!isset($_SESSION['id']) || ($_SESSION['access'] != 2 && $_SESSION['access'] != 3)) {
  echo "<script>alert(\"Доступ заборонений!\");
            location.href='../index.php';
            </script>"; 
} else {
  include("../../include/db_connect.php");
  $sel = mysqli_query($connect, "SELECT * FROM `Products`  GROUP BY product_id ");
  $num_rows = mysqli_num_rows($sel); 
  $row = mysqli_fetch_assoc($sel);
  mysqli_close($connect);
}


function truncateDescription($description, $length = 50) {
    if (strlen($description) > $length) {
        return substr($description, 0, $length) . '...';
    } else {
        return $description;
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
    <link rel="stylesheet" href="../../css/styles.css">
    <script src="../../js/delete.js"></script>
    <title>Адміністрування інтернет-магазина</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>
<body>
  <div class="navbar">
        <a href="../../admin/index.php">Головна</a>
        <a href="../../trainer/admin/index.php">Тренери</a>
        <a href="../../lessons/index.php">Заняття</a>
        <a href="index.php">Інтернет-магазин</a>
        <a href="../../schedule.php">Розклад</a>
        <form action="" method="post" >
            <button type="submit" class="exit_account" name="exit_account">Вихід</button>
        </form>
    </div>

    <div class="container">
        <div class="welcome">
            <h2>Товари</h2>
            <p>Тут можна редагувати та переглядати товари інтернет-магазина фітнес-залу.</p>
        </div>
         
    
    <div class="trainer-card">
<div class="section-links">
            <a href="add.php">Додати товар</a>
            <a href="orders.php">Переглянути замовлення клієнтів</a>
        </div> 
    <div class="spisok-table">
    <table class="admin_table">
      <tr>
        <th width="25px">Індекс</th>
        <th width="125px">Назва</th>
        <th width="300px">Опис</th>
        <th width="125px">Ціна</th>
        <th>Фото</th>
        <th>Перегляд</th>
        <th>Редагування</th>
        <th>Видалення</th>
      </tr>
      <?php
      do {
        $description = truncateDescription($row['description'], 50);
        echo '
                    <tr>
                    <td>' . $row['product_id'] . '</td>
                    <td>' . $row['name'] . '</td>
                    <td>' . $description  . '</td>
                    <td>' . $row['price'] . ' грн.</td>';
        if($row['image']!=null){
          echo'<td><img src="../../images/products/' . $row['image'] . '" width="44px" heigth="44px" ></td>';
        }
        else{
          echo '<td></td>';
        }
        echo'
                    <td><a class="admin-links" href="product.php?id=' . $row['product_id'] . '">Перегляд</a></td>
                    <td><a class="admin-links" href="edit.php?id=' . $row['product_id'] . '">Редагування</a></td>
                    <td><a class="admin-links" href="vendor\delete.php?id=' . $row['product_id'] . '" onclick="return ConfirmDelete()">Видалення</a></td>
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