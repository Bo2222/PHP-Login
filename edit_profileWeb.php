
<?php 
session_start(); 

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('請先登入會員'); window.location.href = 'loginWeb.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員資料修改</title>
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

    <h2>會員資料修改</h2>
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
    <form action = "edit_profile.php" method = "POST" id="profileForm">
        <label>使用者名稱：</label>
        <input type="text" name="username"><br>

        <label>暱稱：</label>
        <input type="text" name="nickname"><br>

        <label>電話：</label>
        <input type="text" name="phone"><br>

        <label>信箱：</label>
        <input type="text" name="mail"><br>

        <label>地址：</label>
        <textarea name="address"></textarea><br>

        <!--<input type="hidden" name="csrf_token" value="<?php //echo $_SESSION['csrf_token'] = bin2hex(random_bytes(16)); ?>">-->
        <br>

        <button type="submit">更新資料</button>
    </form>

    <div id="message"></div>

<script>
/*$(document).ready(function() {
    $("#profileForm").submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: "edit_profile.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "text",       //告訴AJAX以字串處理
            success: function(response) {
                $("#message").text(response.message);
                if (response.status === "success") {
                    $("#message").css("color", "green");
                } else {
                    $("#message").css("color", "red");
                }
            },
            error: function() {
                $("#message").text("請求失敗").css("color", "red");
            }
        });
    });
});*/
</script>

</body>
</html>