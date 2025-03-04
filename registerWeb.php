<html>
<head>
    <title>註冊會員</title>
</head>
<body>
    <h2>註冊會員</h2>
    <form action = "register.php" method = "POST">
        <label>使用者名稱：</label>
        <input type = "text" name = "name1" required placeholder = "輸入姓名"><br>
        <label>暱稱：</label>
        <input type = "text" name = "name2" placeholder = "我們該如何稱呼您"><br>
        <label>電話：</label>
        <input type = "text" name = "phone"><br>
        <label>信箱：</label>
        <input type = "email" name = "mail" required><br>
        <label>密碼：</label>
        <input type = "password" name = "password" required placeholder = "至少一個英文字母和一個數字，長度超過5"><br>
        <label>確認密碼：</label>
        <input type = "password" name = "confirm_password" required><br>

        <input type = "submit" value = "提交">
    </form>
</body>
</html>