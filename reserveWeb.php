<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name =  "viewport" content = "width = device-width, initial-scale = 1.0">
    <tile>
        預約體驗
    </tile>
</head>
<body>
    <?php
    session_start();
    include 'db_connect.php';
    include 'user_info.php';

    if (isset($_SESSION['user_id'])){
        $type = $_GET['type'];                      //取得選擇的預約類型
        $user_id = $_SESSION['user_id'];
        $greeting = getGreeting($user_id, $conn);

        //獲取會員資料
        $userInfo = getUserInfo($user_id, $conn);

        if ($type === 'VR體驗'){
            $typeText = 'VR體驗';
        }
        elseif($type ==='治療師諮詢'){
            $typeText = '治療師諮詢';
        }
        else{
            echo "無效的預約類型";
            exit();
        }

        echo "<h2>{$greeting} 您好，歡迎預約 {$typeText}</h2>";
        echo "<form action = 'reserve_confirm.php' method = 'post'>";
        echo "<input type = 'hidden' name = 'type' value = '$type'>";

        //
        echo "<label for = 'name'>姓名：</label>";
        echo "<input type = 'text' id = 'name' name = 'name' value = '{$userInfo['username']}' required><br>";
        echo "<label for = 'phone'>電話：</label>";
        echo "<input type = 'text' id = 'phone' name = 'phone' value = '{$userInfo['phone']}' required><br>";
        echo "<label for = 'email'>信箱：</label>";
        echo "<input type = 'text' id = 'email' name = 'email' value = '{$userInfo['mail']}' required><br>";
        
        echo "<label for = 'date'>預約日期：</label>";
        echo "<input type = 'date' id = 'date' name = 'date' required><br>";
        echo "<label for = 'time'>預約時間：</label>";
        echo "<input type = 'time' id = 'time' name = 'time' required><br>";
        echo "<button type = 'submit'>下一步</button>";
        echo "</form>";
        
    }
    else{
        echo "請先<a href = 'loginWeb.php'>登入</a>";
    }
    ?>
</body>
</html>