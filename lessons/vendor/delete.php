<?php
  require_once'../../include/db_connect.php';
  $class_id  = $_GET['id'];

  mysqli_query($connect,"DELETE FROM Lessons WHERE `class_id` = '$class_id'");
  header('Location: ../index.php');

 ?>