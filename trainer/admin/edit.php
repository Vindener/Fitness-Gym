<?php
session_start();
if ($_SESSION['auth'] != "admin") {
  echo "<script>alert(\"Доступ заборонений!\");
            location.href='../index.php';
            </script>"; 
} 

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

include("../../include/db_connect.php");
$trainer_id = $_GET['id'];

$trainer_query = "
    SELECT name, bio, photo
    FROM Trainers
    WHERE trainer_id = ?
";
$stmt = $connect->prepare($trainer_query);
$stmt->bind_param("i", $trainer_id);
$stmt->execute();
$trainer_result = $stmt->get_result();
$trainer = $trainer_result->fetch_assoc();
$stmt->close();

if (isset($_POST['update_trainer'])) {
    $name = $_POST['name'];
    $bio = $_POST['bio'];
    $photo = $trainer['photo']; 

    if (!empty($_FILES['photo']['name'])) {
        $target_dir = "../../images/trainer/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $photo = basename($_FILES["photo"]["name"]);
        } 
    }

    $stmt = $connect->prepare("UPDATE Trainers SET name = ?, bio = ?, photo = ? WHERE trainer_id = ?");
    $stmt->bind_param("sssi", $name, $bio, $photo, $trainer_id);
    if ($stmt->execute()) {
        $stmt->close();
         echo "<script>alert(\"Тренер успішно оновлено!\");
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
    <link rel="stylesheet" href="../../css/styles.css">
    <title>Редагування тренера - <?php echo htmlspecialchars($lesson['name']); ?></title>
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

    <div class="welcome">
        <h1>Редагувати тренера <?php echo htmlspecialchars($lesson['name']); ?></h1>
    </div>
    <div class="container">
    <div class="trainer-card">
    <form action="" method="post" enctype="multipart/form-data" class="container-login">
        <label for="name">ПІБ тренера:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($trainer['name']); ?>" required>
        <br><br>
        <label for="bio">Біографія:</label>
        <textarea name="bio" id="bio" rows="4" cols="50" required><?php echo htmlspecialchars($trainer['bio']); ?></textarea>
        <br><br>
        <label for="photo">Фотографія:</label>
        <?php if (!empty($trainer['photo'])): ?>
            <img src="../../images/trainer/<?php echo htmlspecialchars($trainer['photo']); ?>" alt="Фотографія тренера" class="trainer-photo">
            <br>
        <?php endif; ?>
        <input type="file" name="photo" id="photo" accept="image/*">
        <br><br>
        <button type="submit" name="update_trainer" class="check_cart">Оновити тренера</button>
    </form>
    </div>
    </div>
</body>
</html>
