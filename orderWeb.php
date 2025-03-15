<?php
         session_start();
         include 'db_connect.php';
         include 'user_info.php';
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content = "width=device-width, initial-scale = 1.0">
    <title>選擇預約項目</title>
    <?php
         if (isset($_SESSION['user_id'])){
             $user_id = $_SESSION['user_id'];
             $greeting = getGreeting($user_id, $conn);
 
             echo "<h2>歡迎 {$greeting} ，請選擇預約項目</h2>";
         }
         else{
            echo "<script>alert('請先登入會員'); window.location.href = 'loginWeb.php';</script>";
         }
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
            <a href = 'reserveWeb.php?type=VR體驗'>預約體驗VR</a><br>
            <a href = 'reserveWeb.php?type=治療師諮詢'>預約治療師諮詢</a><br>
</body>
</html>