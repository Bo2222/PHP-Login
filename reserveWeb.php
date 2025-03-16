<?php
    session_start();
    include 'db_connect.php';
    include 'user_info.php';

    if (isset($_SESSION['user_id'])){
        $type = $_GET['type'];                      //取得選擇的預約類型
        $user_id = $_SESSION['user_id'];
        $greeting = getGreeting($user_id, $conn);
    }
    else{
        echo "<script>alert('請先登入會員'); window.location.href = 'loginWeb.php';</script>";
    }

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
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name =  "viewport" content = "width = device-width, initial-scale = 1.0">
    <title>
        預約體驗
    </title>
    <?php
        echo "<h2>{$greeting} 您好，歡迎預約 {$typeText}</h2>";
    ?>
    <style>
        nav {
            background-color: #333;
            padding: 10px;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        nav ul li {
            margin-right: 20px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
        }
        .user-greeting {
            color: white;
            margin-right: 20px;
        }
        .dropdown {
        position: relative;
        display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #333;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {
            background-color: #111;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #111;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">首頁</a></li>
            <li><a href="adminWeb.php">管理者系統</a></li>
            <li><a href = "registerWeb.php">註冊會員</a></li>
            <li><a href="loginWeb.php">登入會員</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn">修改資料</a>
                <div class="dropdown-content">
                    <a href="edit_profileWeb.php">修改基本資料</a>
                    <a href="edit_passwordWeb.php">修改密碼</a>
                </div>
            </li>
            <li><a href="logout.php">登出會員</a></li>
            <li><a href="orderWeb.php">預約項目</a></li>
            <li><a href="orderview.php">訂單瀏覽</a></li>
        </ul>
    </nav>
    <?php
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
        echo "<label for = 'notification_method'>通知方式：</label>";
        echo "<select name = 'notification_method' required>";
        echo "<option value = 'email'>Email</option>";
        echo "<option value = 'sms'>簡訊</option>";
        echo "<option value = 'line'>LINE</option>";
        echo "</select>";
        echo "<label for = 'notify_before'>提前幾個小時通知：</label>";
        echo "<select name = 'notify_before' required>";
        echo "option value = '60'>提前一小時</option>";
        echo "option value = '1440'>提前一天</option>";
        echo "option value = '4320'>提前三天</option>";
        echo "option value = '7200'>提前五天</option>";
        echo "</select>";
        echo "<br>";
        echo "<button type = 'submit'>下一步</button>";
        echo "</form>";
    ?>
</body>
</html>