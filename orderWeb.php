<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content = "width=device-width, initial-scale = 1.0">
    <title>選擇預約項目</title>
</head>
<body>
    <?php
        session_start();
        include 'db_connect.php';
        include 'user_info.php';

        if (isset($_SESSION['user_id'])){
            $user_id = $_SESSION['user_id'];
            $greeting = getGreeting($user_id, $conn);

            echo "<h2>歡迎 {$greeting} ，請選擇預約項目</h2>";
            echo "<a href = 'reserveWeb.php?type=VR體驗'>預約體驗VR</a><br>";
            echo "<a href = 'reserveWeb.php?type=治療師諮詢'>預約治療師諮詢</a><br>";
        }
        else{
            echo "請先<a href =  'loginWeb.php'>登入</a>";
        }
    ?>
</body>
</html>