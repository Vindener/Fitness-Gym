<?php
include("db_connect.php");

if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
    
    // Отримання години для обраного заняття
    $query = "
        SELECT Time.hour 
        FROM Lessons
        LEFT JOIN Time ON Lessons.hour_id = Time.time_id
        WHERE Lessons.class_id = $class_id
    ";
    $result = mysqli_query($connect, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo "на ".htmlspecialchars($row['hour'])." годину.";
    } else {
        echo "Невідомо";
    }
}
?>
