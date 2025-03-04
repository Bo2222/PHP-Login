<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location:loginWeb.php");
    exit();
}

$userId = $_SESSION['user_id'];
include 'db_connect.php';
$sql = "SELECT * FROm member WHERE id = '$userId";
$result = $conn->query($sql);

if($result->num_rows == 1){
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $email = $row['email'];
    $phone = $row['phone'];

    echo "歡迎回來，$username<br>";
    echo "郵箱地址：$email";
    echo "電話號碼：$phone";
}
else{
    echo "無法獲取用戶信息。";
}

$conn->close();
?>