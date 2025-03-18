<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db_connect.php';

$user_id = $_SESSION['user_id'];

if($_SERVER["REQUEST_METHOD"] == "POST"){           //確保請求是POST，處理表單提交的數據
    // 準備更新欄位
    /*$fields = [];
    $params = [];
    $types = '';

    $allowed_fields = ['username', 'nickname', 'phone', 'mail', 'address'];

    foreach ($allowed_fields as $field) {
        if (!empty($_POST[$field])) {
            $fields[] = "$field = ?";
            $params[] = trim($_POST[$field]);
            $types .= 's';
        }
    }*/

    
    
    $username = $conn->real_escape_string(trim($_POST['username'] ?? ''));          //使用real_escape_string()避免SQL注入攻擊
    $nickname = $conn->real_escape_string(trim($_POST['nickname'] ?? ''));
    $phone = $conn->real_escape_string(trim($_POST['phone'] ?? ''));
    $mail = $conn->real_escape_string(trim($_POST['mail'] ?? ''));
    $address = $conn->real_escape_string(trim($_POST['address'] ?? ''));
    $lineid = $conn->real_escape_string(trim($_POST['lineid']?? ''));

    

    $error_message = "";

    /*if (!isset($_SESSION['csrf_token']) || $csrf_token !== $_SESSION['csrf_token']) {
        $error_message = "CSRF 驗證失敗。<br>";
    }

    if (empty($fields)) {
        $error_message = "沒有提供任何更新內容。<br>";
    }*/

    if (empty($_POST['username'])) {
        $error_message = "使用者名稱不能為空。";
    }

    if(empty($_POST['nickname'])){
        $error_message = "暱稱不能為空。<br>";
    }

    if(empty($_POST['phone'])){
        $error_message = "電話不能為空。<br>";
    }

    if (!empty($_POST['mail']) && !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        $error_message = "Email 格式錯誤。<br>";
    }

    if(empty($_POST['address'])){
        $error_message = "地址不能為空。<br>";
    }
    

    // 構建 SQL 查詢
    /*$sql = "UPDATE member SET " . implode(", ", $fields) . " WHERE id = ?";
    $params[] = $user_id;
    $types .= 'i';

    // 執行 SQL 更新
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    if (!$stmt->execute()) {
        $error_message = "資料更新失敗。<br>";
    }
    else{
        echo "更新成功。<br>";
    }*/

    $account_check_query = "SELECT * FROM member WHERE username = '$username' LIMIT 1";       //查詢資料庫，檢查account是否已經存在
    $result = $conn->query($account_check_query);
    if($result && $result->num_rows > 0){
        $error_message = "使用者名稱已存在，請選擇另一個。<br>";
    }

    if(!empty($error_message)){                                         //若有錯誤就顯示返回按鈕，透過javascript返回上一頁
        echo '<button onclick = "goBack()">返回修改</button><br>';

        echo '<script>
            function goBack(){
               window.history.back();
        }   
        </script>';
    }

    if(empty($error_message)){
        $stmt = $conn-> prepare("UPDATE member SET username = ?, nickname = ?, phone = ?, mail = ?, address = ? lineid = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $username, $nickname, $phone, $mail, $address, $lineid, $user_id);

        if($stmt->execute()){
            echo "更新成功。將為您跳轉到首頁。<br>";
            header("refresh:3;url = index.php");
            exit();
        }
        else{
            echo "更新失敗。<br>";
        }
    }
    else{
        echo $error_message;
    }   
    $conn->close();
}


?>