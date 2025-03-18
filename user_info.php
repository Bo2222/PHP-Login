<?php
function getGreeting($user_id, $conn){
    $stmt = $conn->prepare("SELECT * FROM member WHERE id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1){
        $row = $result->fetch_assoc();
        return !empty($row['nickname']) ? $row['nickname'] : $row['username'];
    }
    else{
        return "無法獲取使用者資訊";
    }
}

function getUserInfo($user_id, $conn){
    $stmt = $conn->prepare("SELECT * FROM member WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt = $stmt->get_result();

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // 綁定參數（"i" 表示整數)
    $stmt->bind_param("i", $user_id);

    // 執行 SQL
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    // 取得結果
    $result = $stmt->get_result();

    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        return $row;        //返回完整的會員資訊
    }
    else{
        return null;        //如果找不到會員資訊，返回null或適當的錯誤處理
    }
    $conn->close();
}
?>