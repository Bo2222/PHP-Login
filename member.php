<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db_connect.php';

if(!isset($_SESSION['user_id'])){
    header("Location:loginWeb.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM member WHERE id = '$user_id'";
$result = $conn->query($sql);

if($result->num_rows == 1){
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $email = $row['mail'];
    $phone = $row['phone'];

    echo "歡迎回來，$username<br>";
    echo "郵箱地址：$email<br>";
    echo "電話號碼：$phone<br>";

    header("refresh:3;url = index.php");
}
else{
    echo "無法獲取用戶信息。";
}

$conn->close();
?>