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
    </style>
</head>
<body>
    <h2>管理員系統</h2>
    <nav>
        <ul>
            <li><a href="index.php">首頁</a></li>
            <?php
                if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == 17){
                    echo "<li><a href = 'adminWeb.php'>管理員系統</a></li>";
                }
            ?>
            <li><a href = "registerWeb.php">註冊會員</a></li>
            <!--<li><a href="loginWeb.php">登入會員</a></li>-->
            <li class="dropdown">
                <a href="#" class="dropbtn">修改資料</a>
                <div class="dropdown-content">
                    <a href="edit_profileWeb.php">修改基本資料</a>
                    <a href="edit_passwordWeb.php">修改密碼</a>
                </div>
            </li>
            <!--<li><a href="logout.php">登出會員</a></li>-->
            <li><a href="orderWeb.php">預約項目</a></li>
            <li><a href="orderview.php">訂單瀏覽</a></li>
            <li style="margin-left:auto;">
            <?php if ($user): ?>
                您好，<?php echo htmlspecialchars($user['username']); ?> | 
                <a href="logout.php">登出</a>
            <?php else: ?>
                <a href="loginWeb.php">登入</a>
            <?php endif; ?>
            </li>
        </ul>
    </nav>
    <?php
    if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == 17){
        $action = isset($_GET['action']) ? $_GET['action'] : 'show_all';
      
        //顯示連結
        //echo '<h2>管理者頁面</h2>';
        echo '<a href = "adminWeb.php?action=show_all">顯示所有預約</a> | ';
        echo '<a href = "adminWeb.php?action=show_today">顯示今天的預約</a>';

        if($action === 'show_today'){
            $current_date = date('Y-m-d');

            $stmt = $conn->prepare("SELECT order_id, type, date, time, name, phone, created_at, status FROM appointments WHERE date = ? ORDER BY time ASC, status DESC");
            $stmt->bind_param('s', $current_date);
            $Stmt->execute();
            $result = $stmt->get_result();
        
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "<div>";
                    echo "<p>訂單編號：" . $row['order_id'] . "</p>";
                    echo "<p>預約類型：" . $row['type'] . "</p>";
                    echo "<p>預約日期：" . $row['date'] . "</p>";
                    echo "<p>預約時間：" . $row['time'] . "</p>";
                    echo "<p>預約姓名：" . $row['name'] . "</p>";
                    echo "<p>預約電話：" . $row['phone'] . "</p>";
                    echo "<p>建立時間：" . $row['created_at'] . "</p>";
                    echo "<p>訂單狀態：" . $row['status'] . "</p>";
                    echo "</div>";

                    if($row['status'] === '未完成'){
                        echo "form action = 'cancel_resevation.php' method = 'post'>";
                        echo "<input type = 'hidden' name = 'order_id' value = '" . $row['order_id'] . "'>";
                        echo "<button type = 'submit'>取消預約</button>";
                        echo "</form>";

                        //添加已完成按鈕
                        echo "<form method = 'post' action = 'mark_completed.php'>";
                        echo "<input type = 'hidden' name = 'order_id' value = '" . $row['order_id'] . "'>";
                        echo "<button type = 'submit'>完成訂單</button>";
                        echo "</form>";
                    }
                    else{
                        echo "<p>已完成訂單，無法執行操作。</p>";
                    }

                echo "</div>";
                echo "<hr>";
                }
            }
            else{
                echo "<p>今天沒有任何預約項目。</p>";
            }
        }
        elseif($action === 'show_all'){
            $stmt = $conn->prepare("SELECT order_id, type, date, time, name, phone, created_at, status FROM appointments ORDER BY date ASC, time ASC");
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "<div>";
                    echo "<p>訂單編號：" . $row['order_id'] . "</p>";
                    echo "<p>預約類型：" . $row['type'] . "</p>";
                    echo "<p>預約日期：" . $row['date'] . "</p>";
                    echo "<p>預約時間：" . $row['time'] . "</p>";
                    echo "<p>預約姓名：" . $row['name'] . "</p>";
                    echo "<p>預約電話：" . $row['phone'] . "</p>";
                    echo "<p>建立時間：" . $row['created_at'] . "</p>";
                    echo "<p>訂單狀態：" . $row['status'] . "</p>";
                    echo "</div>";

                    if($row['status'] === '未完成'){
                        echo "<form action = 'cancel_reservation.php' method = 'post'>";
                        echo "<input type = 'hidden' name = 'order_id' value = '" . $row['order_id'] . "'>";
                        echo "<button type = 'submit'>取消預約</button>";
                        echo "</form>";

                        //添加已完成按鈕
                        echo "<form method = 'post' action = 'mark_completed.php'>";
                        echo "<input type = 'hidden' name = 'order_id' value = '" . $row['order_id'] . "'>";
                        echo "<button type = 'submit'>完成訂單</button>";
                        echo "</form>";
                    }
                    else{
                        echo "<p>已完成訂單，無法執行操作。</p>";
                    }
                    echo "</div>";
                    echo "<hr>";
                }
            }
            else{
                echo "<p>目前沒有任何預約項目。</p>";
            }
        }
    }
    else{
        echo "<script>alert('您不是管理員，無權訪問該頁面。'); window.location.href = 'index.php';</script>";
    }
    $conn->close();
    ?>
</body>
</html>