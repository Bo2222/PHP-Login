<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("連接資料庫失敗:" . $conn->connect_error);
}

$username = $conn->real_escape_string($_POST['username']);
$password = $conn->real_escape_string($POST['password']);

$sql = "SELECT hashed_password, salt FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if($result->num_rows == 1){
    $row = $result->fetch_assoc();
    $storedHashedPassword = $row['hashed_password'];
    $salt = $row['salt'];

    //使用輸入的密碼和鹽值計算雜湊值
    $hashedLoginPassword = hash('sha256', $password . $salt);

    //比對計算的雜湊值和儲存的雜湊值
    if($hashedLoginPassword === $storedHashedPassword){
        echo "登入成功";
    }
    else{
        echo "登入失敗：密碼錯誤";
        echo '<button onclick="window.location.href=\'loginWeb.php\'">重新登入</button>';
        }
}
    else{
        echo "登入失敗：帳號錯誤";
        echo '<button onclick="window.location.href=\'registerWeb.php\'">前往註冊畫面</button>';
    }
    
$conn->close();
?>
