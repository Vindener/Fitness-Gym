<?php
  $connect = mysqli_connect('localhost','root','','fitness_gym');
  if(!$connect){
    die("Підключення відсутнє:"  . mysqli_connect_error());
  }
 ?>
