<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
    <title>
        我的訂單
    </title>
</head>
<body>
    <?php
    session_start();
    include 'db_connect.php';
    include 'user_info.php';

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        //使用userInfo.php中的函數獲取使用者資訊
        $userInfo = getUserInfo($user_id, $conn);
        $account = $userInfo['account'];

        //檢查篩選狀態
        $filter = "";
        if(isset($_GET['status'])){
            $status = $_GET['status'];
            $filter = "AND status = '$status'";
        }

        //查詢預約資訊
        $sql = "SELECT order_id, type, date, time, name, phone, status FROM appointments WHERE account = '$account' $filter ORDER BY date DESC, time DESC";
        $result = $conn->query($sql);

        echo "<h2>我的訂單</h2>";
        echo "<p><a href = 'orderView.php'>全部</a> |<a href = 'orderView.php?status = 未完成'>未完成</a> | <a href = 'orderView.php?status = 已完成'>已完成</a></p>";

        if ($result->num_rows >0 ){
            while ($row = $result->fetch_assoc()){
                echo "<div>";
                echo "<p>訂單編號：". $row['order_id'] . "</p>";
                echo "<p>預約類型：". $row['type'] . "</p>";
                echo "<p>預約日期：". $row['date'] . "</p>";
                echo "<p>預約時間：". $row['time'] . "</p>";
                echo "<p>預約姓名：". $row['name'] . "</p>";
                echo "<p>預約電話：". $row['phone'] . "</p>";

                if($row['status'] === '未完成'){
                    echo "<form action = 'cancel_reservation.php' method = 'post'>";
                    echo "<input type = 'hidden' name = 'order_id' value = '" . $row['order_id'] . "'>";
                    echo "<button type = 'submit'>取消預約</button>";
                    echo "</form>";
                }

                echo "</div>";
            }
        }
        else{
            echo "<p>沒有任何預約項目</p>";
        }
    }
    else{
        echo "請先<a href = 'loginWeb.php'>登入</a>";
    }
    ?>
</body>
</html>