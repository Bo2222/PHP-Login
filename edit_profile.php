<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){           //確保請求是POST，處理表單提交的數據
    session_start();
    include 'db_connect.php';

    if (!isset($_SESSION['user_id'])) {
        die("請先登入");
        header("Location:loginWeb.php");
        exit();
    }

    // 準備更新欄位
    $fields = [];
    $params = [];
    $types = '';

    $allowed_fields = ['username', 'nickname', 'phone', 'mail', 'address'];

    foreach ($allowed_fields as $field) {
        if (!empty($_POST[$field])) {
            $fields[] = "$field = ?";
            $params[] = trim($_POST[$field]);
            $types .= 's';
        }
    }

    $error_message = "";

    if (empty($fields)) {
        $error_message = "沒有提供任何更新內容。<br>";
    }

    if (empty($_POST['username'])) {
        $error_message = "使用者名稱不能為空。";
    }
    if (!empty($_POST['mail']) && !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        $error_message = "Email 格式錯誤。<br>";
    }

    if($oldpassword === $newpassword){
        $error_message = "新密碼不能與舊密碼一致。<br>";
    }

    // 構建 SQL 查詢
    $sql = "UPDATE member SET " . implode(", ", $fields) . " WHERE id = ?";
    $params[] = $user_id;
    $types .= 'i';

    // 執行 SQL 更新
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    if (!$stmt->execute()) {
        $error_message = "資料更新失敗。<br>";
    }
    else{
        echo json_encode(["status" => "success", "message" => "更新成功"]);
    }
    if (!empty($_POST['new_password'])) {
        $old_password = $_POST['old_password'] ?? '';
        $new_password = $_POST['new_password'];
    
        // 取得目前密碼與 salt
        $stmt = $conn->prepare("SELECT password, salt FROM member WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($hashed_password, $salt);
        $stmt->fetch();
        $stmt->close();
    
        // 驗證舊密碼
        if (hash('sha256', $old_password . $salt) !== $hashed_password) {
            $error_message = "舊密碼錯誤";
        }
    
        // 生成新 salt & 密碼雜湊
        $new_salt = bin2hex(random_bytes(16));
        $new_hashed_password = hash('sha256', $new_password . $new_salt);
    
        // 更新新密碼與 salt
        $stmt = $conn->prepare("UPDATE member SET password = ?, salt = ? WHERE id = ?");
        $stmt->bind_param("ssi", $new_hashed_password, $new_salt, $user_id);
        if (!$stmt->execute()) {
            $error_message = "密碼更新失敗";
        }
        else{
            echo "密碼更新成功。<br>";
        }
    }
}
else{
    echo $error_message;
}
?>