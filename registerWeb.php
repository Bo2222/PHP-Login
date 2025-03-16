<?php 
session_start(); 

if (isset($_SESSION['user_id'])) {
    echo "<script>alert('您已登入，無需註冊會員。'); window.location.href = 'index.php';</script>";
    exit();
}
?>

<html>
<head>
    <title>註冊會員</title>
<style>
    input {
  min-width: 100px;
  max-width: 300px;
  width: 50%;
}
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
    <h2>註冊會員</h2>
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
    <form action = "register.php" method = "POST">
        <label>使用者名稱：</label>
        <input type = "text" name = "username" required placeholder = "輸入姓名"><br>
        <label>暱稱：</label>
        <input type = "text" name = "nickname" placeholder = "我們該如何稱呼您"><br>
        <label>電話：</label>
        <input type = "text" name = "phone"><br>
        <label>信箱：</label>
        <input type = "email" name = "mail" required><br>
        <label>地址：</label>
        <input type = 'address' name = 'address' required><br>
        <label>LineID:</label>
        <input type = 'text' name = 'lineid' placeholder="選填"><br>
        <label>密碼：</label>
        <input type = "password" name = "password" required placeholder = "至少一個英文字母和一個數字，長度超過5"><br>
        <label>確認密碼：</label>
        <input type = "password" name = "confirm_password" required><br>
        <br>
        <input type = "submit" value = "提交">
    </form>
</body>
</html>
