<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db_connect.php';
include 'user_info.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //從SESSION中獲取預約帳號
    if (isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];

        //使用user_info.php中的函數獲取使用者資訊
        $userInfo = getUserInfo($user_id, $conn);
        //var_dump($userInfo);

        if($userInfo !== null){
            $account = $userInfo['account'];

            //從POST請求中獲取預約資料
            $type = $conn->real_escape_string($_POST['type'] ?? '');
            $name = $conn->real_escape_string($_POST['name'] ?? '');
            $phone = $conn->real_escape_string($_POST['phone'] ?? '');
            $email = $conn->real_escape_string($_POST['email'] ?? '');
            $date = $conn->real_escape_string($_POST['date'] ?? '');
            $time = $conn->real_escape_string($_POST['time'] ?? '');
            $notification_method = $conn->real_escape_string($_POST['notification_method']?? '');
            $notify_before = $conn->real_escape_string($_POST['notify_before']?? '');

            //當下的日期時間
            $created_at = date('Y-m-d H:i:s');

            //將預約的資料存入資料庫appointments資料表
            $stmt = $conn->prepare("INSERT INTO appointments(type, account, name, phone, email, date, time, created_at, status, notification_method, notify_before) VALUES (?, ?, ?, ?, ?, ?, ?, ?, '未完成', ?, ?)");
            $stmt->bind_param("sssssssssi", $type, $account, $name, $phone, $email, $date, $time, $created_at, $notification_method, $notify_before);

            if($stmt->execute()){
                echo "預約成功，3秒後跳轉至預約首頁";
                header("refresh:3;url = orderWeb.php");
            }
            else{
                echo "預約失敗：" . $conn->error;
            }
        }
        else{
            echo "無法獲取使用者資訊。";
        }
    }
    else{
        echo "無法獲取預約帳號。";
    }
}

$conn->close();
?>