<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

#conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    dir("連接資料庫失敗: " . $conn->connect_error);
}

$username = $conn->real_escape_string($_POST['username']);
$password = $conn->real_escape_string($_POST['password']);

//生成隨機的鹽值
$salt = bin2hex(random_bytes(16));

//將鹽值和密碼結合，使用雜湊函數計算雜湊值
$hashed_password = hash('sha256', $password . $salt);

$sql = "INSERT INTO users(username, hashed_password, salt) VALUES )'$username', '$hashed_password', '$salt')";

if($conn->query($sql) === TRUE){
    echo "註冊成功<br>";
    echo '<button oneclick = "wondow.location.href=\'loginWeb.php\'">前往登入頁面</button>';
}
else{
    echo "註冊失敗:" . $conn->error;
}

$conn->close();
?>