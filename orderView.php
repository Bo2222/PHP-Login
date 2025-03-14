<?php
    session_start();
    include 'db_connect.php';
    include 'user_info.php';
?>

<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
    <title>
        我的訂單
    </title>
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
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        //使用userInfo.php中的函數獲取使用者資訊
        $userInfo = getUserInfo($user_id, $conn);
        $account = $userInfo['account'];

        //檢查篩選狀態
        $filter = "";
        if(isset($_GET['status'])){
            $status = $_GET['status'];
            $filter = "AND status = '$status'";
        }

        //查詢預約資訊
        $sql = "SELECT order_id, type, date, time, name, phone, status FROM appointments WHERE account = '$account' $filter ORDER BY date DESC, time DESC";
        $result = $conn->query($sql);

        echo "<h2>我的訂單</h2>";
        echo "<p><a href = 'orderView.php'>全部</a> |<a href = 'orderView.php?status = 未完成'>未完成</a> | <a href = 'orderView.php?status = 已完成'>已完成</a></p>";

        if ($result->num_rows >0 ){
            while ($row = $result->fetch_assoc()){
                echo "<div>";
                echo "<p>訂單編號：". $row['order_id'] . "</p>";
                echo "<p>預約類型：". $row['type'] . "</p>";
                echo "<p>預約日期：". $row['date'] . "</p>";
                echo "<p>預約時間：". $row['time'] . "</p>";
                echo "<p>預約姓名：". $row['name'] . "</p>";
                echo "<p>預約電話：". $row['phone'] . "</p>";

                if($row['status'] === '未完成'){
                    echo "<form action = 'cancel_reservation.php' method = 'post'>";
                    echo "<input type = 'hidden' name = 'order_id' value = '" . $row['order_id'] . "'>";
                    echo "<button type = 'submit'>取消預約</button>";
                    echo "</form>";
                }

                echo "</div>";
            }
        }
        else{
            echo "<p>沒有任何預約項目</p>";
        }
    }
    else{
        echo "<script>alert('請先登入會員'); window.location.href = 'loginWeb.php';</script>";
    }
    ?>
</body>
</html>