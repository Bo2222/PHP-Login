<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){           //確保請求是POST，處理表單提交的數據
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "member";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn->connect_error){
        dir("連接資料庫失敗: " . $conn->connect_error);
    }

    $username = $conn->real_escape_string($_POST['username']);
    $nickname = $conn->real_escape_string($_POST['nickname']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $mail = $conn->real_escape_string($_POST['mail']);
    $raw_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];


    $email_parts = explode('@', $mail);
    $account = $conn->real_escape_string($email_parts[0]);

    $error_message = "";

    if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
    $error_message .= "請輸入有效的郵箱地址。<br>";
    }

    if(strlen($raw_password) <= 5 || !preg_match("/^?=.[A-Za-z])(?=.*\d)", $raw_password)){
    $error_message .= "密碼必須包含至少一個英文字母和一個數字，長度超過5。<br>";
    }

    if($raw_password !== $confirm_password){
    $error_message = "確認密碼是否一致。<br>";
    }

    $account_check_query = "SELECT * FROM member WHERE account = '$account' LIMIT 1";
    $result = $conn->query($account_check_query);
    if($result && $result->num_rows > 0){
        $error_message = "帳號已存在，請選擇另一個帳號。<br>";
    }

    if(!empty($error_message)){
        echo '<button onclick = "goBack()">返回修改</button><br>';

        echo '<script>
            function go Back(){
               window.history.back();
        }   
        </script>';
    }

    if(empty($error_message)){
        $salt = random_bytes(16);

        $hashedPassword = hash('sha256', $raw_password . $salt);

        $sql = "INSERT INTO member (username, nickname, phone, mail, account, hashed_password, salt) VALUES ('$username', '$nickname', '$phone', '$mail', '$account', '$hashed_paassword', '$salt'";

        if($conn->query($sql) === TRUE){
            echo "註冊成功，您的帳號為" . $account;
            echo '<button onclick = "window.location.href = \'loginWeb.php\'">錢網登入頁面</button>';
        }
        else{
            echo "註冊失敗：" . $conn->error;
        }
    }
    else{
        echo $error_message;
    }

    $conn->close();
}
?>