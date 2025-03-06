<?php
session_start();
include 'db_connect.php';

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['order_id'])){
    $order_id = $_POST['order_id'];

    $sql = "DELETE FROM appointments WHERE order_id = '$order_id'";
    
    if($conn->query($sql) === TRUE){
        echo "訂單已成功取消。";
    }
    else{
        echo "取消訂單失敗：" . $conn->error;
    }
}

echo "<br>";
echo "<br>";
echo "<a href = 'orderView.php'>
        <button>查看我的預約訂單</button>
    </a>";

$conn->close();
?>