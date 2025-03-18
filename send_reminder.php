<?php
include 'db_connect.php';
include 'notification_functions.php';

$current_time = date('Y-m-d H:i:s');
$stmt = $conn->prepare("SELECT a.*, m.mail, m.lineid FROM appointmemts a JOIN member m ON a.account = m.account WHERE TIMESTAMP(a.date, a.time) <= DATE_ADD('$current_time', INTERVAL a.notify_before MINUTE) AND a.status = '未完成'");
$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()){
    $message = "提醒您，您的預約將於{$row['date']}{$row['time']}進行。";
    
    switch($row['notification_method']){
        case 'email':
            sendEmail($row['mail'], "預約提醒", $message);
            break;
        case 'sms':
            sendSMS($row['phone'], $message);
            break;
        case 'LINE':
            sendLine($row['lineid'], $message);
            break;
    }
}

$conn->close();

?>