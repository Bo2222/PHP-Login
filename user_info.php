<?php
function getGreeting($user_id, $conn){
    $sql = "SELECT * FROM member WHERE id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1){
        $row = $result->fetch_assoc();
        return !empty($row['nickname']) ? $row['nickname'] : $row['username'];
    }
    else{
        return "無法獲取使用者資訊";
    }
}

function getUserInfo($user_id, $conn){
    $sql = "SELECT * FROM member WHERE id = '$user_id'";
    $result = $conn->query($sql);

    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        return $row;        //返回完整的會員資訊
    }
    else{
        return null;        //如果找不到會員資訊，返回null或適當的錯誤處理
    }
}
?>