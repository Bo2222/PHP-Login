<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if($_SERVER["REQUEST_METHOD"] == "POST"){           //確保請求是POST，處理表單提交的數據
    session_start();

    include 'db_connect.php';

    $account = $conn->real_escape_string($_POST['account'] ?? '');
    $password = $conn->real_escape_string($_POST['password'] ?? '');

    $sql = "SELECT * FROM member WHERE account = '$account'";
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
                header("refresh:3;url = member.php");
                //refresh:5;url = index.php
                //Location:member.php
                exit();
        }
        else{
            echo "密碼錯誤，請重新嘗試。";
            header("refresh:3;url = loginWeb.php");
            exit();
            }
    }
        else{
            echo "帳號不存在，請註冊帳號。";
            header("refresh:3;url = registerWeb.php");
            exit();
        }
        
    $conn->close();
}
?>
