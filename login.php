<?php
session_start();

include 'db_connect.php';

$email = $conn->real_escape_string($_POST['email']);
$password = $conn->real_escape_string($POST['password']);

$sql = "SELECT * FROM member WHERE email = 'email'";
$result = $conn->query($sql);

if($result->num_rows == 1){
    $row = $result->fetch_assoc();

    //使用輸入的密碼和鹽值計算雜湊值
    $hashedPassword = hash('sha256', $password . $row['salt']);

    //比對計算的雜湊值和儲存的雜湊值
    if($hashedPassword === $row['hashed_password']){
            $welcomeMeassage =  "登入成功，歡迎回來。";
            $welcomeMeassage .= !empty($row['nickname']) ? $row['nickname'] : $row['username'];
            echo $welcomeMeassage;
            $_SESSION['user_id'] = $row['id'];
            header("Location:member.php");
            exit();
    }
    else{
        echo "密碼錯誤，請重新嘗試。";
        }
}
    else{
        echo "帳號不存在，請註冊帳號。";
    }
    
$conn->close();
?>
