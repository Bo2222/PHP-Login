<?php
session_start();
include 'db_connect.php';
include 'user_info.php';

$user = null;
if (isset($_SESSION['user_id'])){
    $user = getUserInfo((int)$_SESSION['user_id'], $conn);
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>管理員頁面</title>
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
            color: white;
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
        .container {
            width: 80%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .filter-links a {
            margin-right: 15px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        .order-box {
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        }
        .btn-group {
            margin-top: 10px;
        }
        .btn {
            padding: 8px 12px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-right: 10px;
        }
        .btn-cancel {
            background-color: red;
            color: white;
        }
        .btn-complete {
            background-color: blue;
            color: white;
        }
        .complete{
            color: green;
            font-weight: bold;
        }
        .none_reservations{
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>管理員系統</h2>
    <nav>
        <ul>
            <li><a href = "index.php">首頁</a></li>
            <?php
                if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == 17){
                    echo "<li><a href = 'adminWeb.php'>管理員系統</a></li>";
                }
            ?>
            <li><a href = "registerWeb.php">註冊會員</a></li>
            <!--<li><a href="loginWeb.php">登入會員</a></li>-->
            <li class = "dropdown">
                <a href = "#" class="dropbtn">修改資料</a>
                <div class = "dropdown-content">
                    <a href = "edit_profileWeb.php">修改基本資料</a>
                    <a href = "edit_passwordWeb.php">修改密碼</a>
                </div>
            </li>
            <!--<li><a href="logout.php">登出會員</a></li>-->
            <li><a href = "orderWeb.php">預約項目</a></li>
            <li><a href = "orderview.php">訂單瀏覽</a></li>
            <li style = "margin-left:auto;">
            <?php if ($user): ?>
                您好，<?php echo htmlspecialchars($user['username']); ?> | 
                <a href = "logout.php">登出</a>
            <?php else: ?>
                <a href = "loginWeb.php">登入</a>
            <?php endif; ?>
            </li>
        </ul>
    </nav>
    <div class = "container">
    <?php
    if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == 17){
        $action = isset($_GET['action']) ? $_GET['action'] : 'show_all';?>
    <h2>全部訂單</h2>
        <!--顯示連結-->
    <p class = "filter-links">
        <a href = "adminWeb.php?action=show_all">顯示所有預約</a> |  
        <a href = "adminWeb.php?action=show_today">顯示今天的預約</a>
    </p>
        
    <?php
        if($action === 'show_today'){
            $current_date = date('Y-m-d');

            $stmt = $conn->prepare("SELECT order_id, type, date, time, name, phone, created_at, status FROM appointments WHERE date = ? ORDER BY time ASC, status DESC");
            $stmt->bind_param('s', $current_date);
            $stmt->execute();
            $result = $stmt->get_result();
        
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
    ?>
                    <div class="order-box">
                    <p>訂單編號：<?php echo $row['order_id']; ?></p>
                    <p>預約類型：<?php echo $row['type']; ?></p>
                    <p>預約日期：<?php echo $row['date']; ?></p>
                    <p>預約時間：<?php echo $row['time']; ?></p>
                    <p>預約姓名：<?php echo $row['name']; ?></p>
                    <p>預約電話：<?php echo $row['phone']; ?></p>
                    <p>建立時間：<?php echo $row['created_at']; ?></p>
                    <p>訂單狀態：<?php echo $row['status']; ?></p>
    
    <?php           if($row['status'] === '未完成'){   ?>
                    <div class="btn-group">
                        <!-- 取消預約按鈕 -->
                        <form action = "cancel_reservation.php" method = "post" style = "display:inline;">
                            <input type = "hidden" name = "order_id" value = "<?php echo $row['order_id']; ?>">
                            <button type = "submit" class = "btn btn-cancel">取消預約</button>
                        </form>

                        <!-- 已完成按鈕 -->
                        <form action = "mark_completed.php" method = "post" style = "display:inline;">
                            <input type = "hidden" name = "order_id" value = "<?php echo $row['order_id']; ?>">
                            <button type = "submit" class = "btn btn-complete">完成訂單</button>
                        </form>
                    </div>
    <?php
                    }
                    else{
    ?>
                        <p class = "complete"><strong>已完成訂單，無法執行操作。</strong></p>
     
    <?php            }  ?>
                
    <?php
                }
            }
            else{   
    ?>
                <p class = "none_reservations"><strong>今天沒有任何預約項目。</strong></p>
                </div>
    <?php
            }
        }
        elseif($action === 'show_all'){
            $stmt = $conn->prepare("SELECT order_id, type, date, time, name, phone, created_at, status FROM appointments ORDER BY date ASC, time ASC");
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
    ?>
                    <div class="order-box">
                    <p>訂單編號：<?php echo $row['order_id']; ?></p>
                    <p>預約類型：<?php echo $row['type']; ?></p>
                    <p>預約日期：<?php echo $row['date']; ?></p>
                    <p>預約時間：<?php echo $row['time']; ?></p>
                    <p>預約姓名：<?php echo $row['name']; ?></p>
                    <p>預約電話：<?php echo $row['phone']; ?></p>
                    <p>建立時間：<?php echo $row['created_at']; ?></p>
                    <p>訂單狀態：<?php echo $row['status']; ?></p>
   
    <?php           if($row['status'] === '未完成'){   ?>
                     <div class="btn-group">
                        <!-- 取消預約按鈕 -->
                        <form action = "cancel_reservation.php" method = "post" style = "display:inline;">
                            <input type = "hidden" name = "order_id" value = "<?php echo $row['order_id']; ?>">
                            <button type = "submit" class = "btn btn-cancel">取消預約</button>
                        </form>

                        <!-- 已完成按鈕 -->
                        <form action = "mark_completed.php" method = "post" style = "display:inline;">
                            <input type = "hidden" name = "order_id" value = "<?php echo $row['order_id']; ?>">
                            <button type = "submit" class = "btn btn-complete">完成訂單</button>
                        </form>
                    </div>
    <?php
                    }
                    else{
    ?>
                        <p class = "complete"><strong>已完成訂單，無法執行操作。</strong></p>

    <?php            }  ?>
                    </div>
    <?php
                }
            }
            else{
    ?>
                <p class = "none_reservations"><strong>今天沒有任何預約項目。</strong></p>
            </div>
    <?php
            }
        }
    }
    else{
        echo "<script>alert('您不是管理員，無權訪問該頁面。'); window.location.href = 'index.php';</script>";
    }
    $conn->close();
    ?>
</div>
</body>
</html>