<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php';

if($_SERVER['REQUEST_METHOD'] ==='POST' && isset($_POST['order_id'])){
    $order_id = $_POST['order_id'];

    //更新訂單狀態為已完成
    $stmt = $conn->prepare("UPDATE appointments SET status = '已完成' WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    if($stmt->execute()){
        echo "訂單狀態更新成功。<br>";
        header("refresh:3;url = adminWeb.php");         //重新導回管理員頁面
        exit();
    }
    else{
        echo "訂但狀態更新失敗。<br>";
        header("refresh:3;url = adminWeb.php");         //重新導回管理員頁面
        exit();
    }

    $conn->close();
}
?>