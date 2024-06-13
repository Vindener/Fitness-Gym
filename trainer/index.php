<?php
session_start();
include("../include/db_connect.php");

$trainers_query = "SELECT * FROM Trainers";
$trainers_result = mysqli_query($connect, $trainers_query);

$trainers = [];
while ($row = mysqli_fetch_assoc($trainers_result)) {
    $trainers[] = $row;
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

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$total_items_in_cart = array_sum($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Тренери та їх заняття</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>
<body>
    <div class="navbar">
         <?php if ($total_items_in_cart == null): ?>
            <a href="../shop/cart.php">Перейти до кошика</a>
        <?php else: ?>
            <a href="../shop/cart.php">У кошику: <?php echo $total_items_in_cart; ?> </a>
        <?php endif; ?>
        <a href="../index.php">Головна</a>
        <a href="../trainer/index.php">Тренери</a>
        <a href="../shop/index.php">Інтернет-магазин</a>
        <a href="../blog/index.php">Блог</a>
        <a href="../schedule.php">Розклад</a>
        <?php if ($user_logged_in): ?>
            <a href="../users/index.php">Мій кабінет</a>
            <form action="" method="post" style="display: inline;">
                <button type="submit" name="exit_account"class="exit_account" name="exit_account">Вихід</button>
            </form>
        <?php else: ?>
            <a href="../users/login.php">Увійти</a>
            <a href="../users/registration.php">Регістрація</a>
        <?php endif; ?>
    </div>
    <div class="container">
    <div class="welcome">
        <h1>Тренери та їх заняття</h1>
        <?php if ($user_logged_in): ?>
        <div class="blog-button">
            <a href="../users/record.php">Записатися на заняттяю</a>
        </div>
    <?php else: ?>
            <p><a href="../users/login.php">Увійдіть</a>, щоб записатися на заняття</p>
    <?php endif; ?>
    </div>
        <?php foreach ($trainers as $trainer): ?>
            <div class="trainer-card">
                <div class="trainer-card-header">
                <?php if ($trainer['photo']): ?>
                    <img class="trainer-card-img" src="../images/trainer/<?php echo htmlspecialchars($trainer['photo']); ?>" alt="<?php echo htmlspecialchars($trainer['name']); ?>">
                <?php endif; ?>
                <h2><a href="trainer.php?id=<?php echo $trainer['trainer_id']; ?>"><?php echo htmlspecialchars($trainer['name']); ?></a></h2>
                
                </div>
                <p>Опис тренера: <?php echo nl2br(htmlspecialchars($trainer['bio'])); ?></p>

                <h3>Заняття:</h3>
                <ul class="lesson-list">
                    <?php
                    $trainer_id = $trainer['trainer_id'];
                    $lessons_query = "
                        SELECT Lessons.title, Time.hour
                        FROM Lessons
                        JOIN Time ON Lessons.hour_id = Time.time_id
                        WHERE Lessons.trainer_id = $trainer_id
                    ";
                    $lessons_result = mysqli_query($connect, $lessons_query);

                    if (mysqli_num_rows($lessons_result) > 0) {
                        while ($lesson = mysqli_fetch_assoc($lessons_result)) {
                            echo "<li><strong>" . htmlspecialchars($lesson['title']) . ":</strong> " . htmlspecialchars($lesson['hour']) . "</li>";
                        }
                    } else {
                        echo "<li>Цей тренер ще не має запланованих занять.</li>";
                    }
                    ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
