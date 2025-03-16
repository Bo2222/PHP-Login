<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php';

if($_SERVER['REQUEST_METHOD'] ==='POST' && isset($_POST['order_id'])){
    $order_id = $_POST['order_id'];

    //更新訂單狀態為已完成
    $updateQuery = "UPDATE appointments SET status = '已完成' WHERE order_id = $order_id";
    mysqli_query($conn, $updateQuery);

    //重新導回管理員頁面
    header("Location: adminWeb.php");
    exit();
}
?>