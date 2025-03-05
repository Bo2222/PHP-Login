<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "member";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("連接資料庫失敗:" . $conn->connect_error);
}

?>