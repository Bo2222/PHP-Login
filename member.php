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

$userId = $_SESSION['user_id'];

$sql = "SELECT * FROM member WHERE id = '$userId'";
$result = $conn->query($sql);

if($result->num_rows == 1){
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $email = $row['mail'];
    $phone = $row['phone'];

    echo "歡迎回來，$username<br>";
    echo "郵箱地址：$email<br>";
    echo "電話號碼：$phone<br>";

    header("refresh:5;url = index.php");
}
else{
    echo "無法獲取用戶信息。";
}

$conn->close();
?>