<?php
  require_once'../../../include/db_connect.php';
  $trainer_id  = $_GET['id'];

  mysqli_query($connect,"DELETE FROM Trainers WHERE `trainer_id` = '$trainer_id'");
  header('Location: ../index.php');

 ?>