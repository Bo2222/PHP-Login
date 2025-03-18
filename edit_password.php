<?php
session_start();
include "db_connect.php";

$user_id = $_SESSION['user_id'];

if($_SERVER["REQUEST_METHOD"] == "POST"){  
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';

    $error_message = "";

    if (!empty($_POST['old_password'])) {
       
        // 取得目前密碼與 salt
        $stmt = $conn->prepare("SELECT hashed_password, salt FROM member WHERE id = '$user_id'");
        //$stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($hashed_password, $salt);
        $stmt->fetch();
        $stmt->close();

        // 驗證舊密碼
        if (hash('sha256', $old_password . $salt) !== $hashed_password) {
            $error_message = "舊密碼錯誤。<br>";
        }
        //驗證新密碼和舊密碼是否相同
        if($old_password === $new_password){
            $error_message = "新密碼不能與舊密碼一致。<br>";
        }
        //驗證新密碼欄位是否為空
        if(empty($new_password)){
            $error_message = "新密碼欄位不能為空。<br>";
        }
    }       
    else{
        $error_message = "舊密碼欄位不能為空。<br>";
    }                                

    if(empty($error_message)){
        if(!empty($new_password) && !empty($old_password)){
            // 生成新 salt & 密碼雜湊
            $new_salt = bin2hex(random_bytes(16));
            $new_hashed_password = hash('sha256', $new_password . $new_salt);
    
            // 更新新密碼與 salt
            $stmt = $conn->prepare("UPDATE member SET hashed_password = ?, salt = ? WHERE id = ?");
            $stmt->bind_param("ssi", $new_hashed_password, $new_salt, $user_id);
            if ($stmt->execute()) {
                echo "密碼更新成功，將為您跳轉回首頁。<br>";
                header("refresh:3;url = index.php");
            }
            //else{
                //echo "密碼更新失敗。<br>";
            //}
        }
    }
    else{
        echo $error_message;
        echo '<button onclick = "goBack()">返回修改</button><br>';              //若有錯誤就顯示返回按鈕，透過javascript返回上一頁

        echo '<script>
            function goBack(){
               window.history.back();
        }   
        </script>';
    }
    $conn->close();
}
?>
