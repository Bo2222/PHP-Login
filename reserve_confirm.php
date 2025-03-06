<?php
session_start();
include 'db_connect.php';
include 'user_info.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //從SESSION中獲取預約帳號
    if (isset($_SESSION['user_id'])){
        $user_id = $_SESSSION['user_id'];

        //使用getUserInfo中的函數獲取使用者資訊
        $userInfo = getUserInfo($user_id, $conn);

        if($userInfo !== null){
            $account = $userInfo['account'];

            //從POST請求中獲取預約資料
            $type = $_POST['type'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $date = $_POST['date'];
            $time = $_POST['time'];

            //
            $created_at = date('Y-m-d H:i:s');

            //
            $stmt = $conn->prepare("INSERT INTO appointments(type, account, name, phone, email, date, time, created_at, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $type, $account, $name, $phone, $email, $date, $time, $datetime, $created_at, $status);

            if($stmt->execute()){
                echo "預約成功，5秒後跳轉至預約首頁";
                header("refresh:5;url = orderWeb.php");
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