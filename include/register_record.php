<?php
session_start();
  include("db_connect.php");
    $check_query = "SELECT * FROM Registrations WHERE class_id = ".$_POST['class_id']." AND registration_date = '".$_POST['registration_date']."'";
    $result_query = mysqli_query($connect, $check_query);
       
    if($result_query->num_rows==""){
            mysqli_query($connect, "INSERT INTO `Registrations`(`user_id`, `class_id`, `registration_date`) VALUES ('" . $_SESSION["id"] . "','" . $_POST["class_id"] . "','" . $_POST["registration_date"] . "')");
            echo "<script>alert(\"Вітаю вас записано!\");
            location.href='../users/schedule.php';
            </script>"; 
    }else{
        echo "<script>alert(\"На цей час заняття вже зайнято!\");
        location.href='../users/record.php';
        </script>"; 
    }

?>
