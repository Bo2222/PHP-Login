<html>
<head>
    <title>網站導航</title>
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
    </style>
</head>
<body>
    <h2>網頁導覽</h2>
    <!--<ul>
        <li><a href="loginWeb.php">登入會員</a></li>
        <li><a href="registerWeb.php">註冊會員</a></li>
        <li><a href="orderWeb.php">預約項目</a></li>
        <li><a href="orderView.php">訂單瀏覽</a></li>
    </ul>-->
    <nav>
        <ul>
            <li><a href="index.php">首頁</a></li>
            <li><a href="loginWeb.php">登入會員</a></li>
            <li><a href="logout.php">登出會員</a></li>
            <li><a href="orderWeb.php">預約項目</a></li>
            <li><a href="orderview.php">訂單瀏覽</a></li>
        </ul>
    </nav>
</body>
</html>