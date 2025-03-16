<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if($_SERVER["REQUEST_METHOD"] == "POST"){           //確保請求是POST，處理表單提交的數據
    session_start();

    include 'db_connect.php';

    $username = $conn->real_escape_string(trim($_POST['username'] ?? ''));          //使用real_escape_string()避免SQL注入攻擊
    $nickname = $conn->real_escape_string(trim($_POST['nickname'] ?? ''));
    $phone = $conn->real_escape_string(trim($_POST['phone'] ?? ''));
    $mail = $conn->real_escape_string(trim($_POST['mail'] ?? ''));
    $address = $conn->real_escape_string(trim($_POST['address'] ?? ''));
    $lineid = $conn->real_escape_string(trim($_POST['lineid']?? ''));
    $raw_password = $_POST['password'] ?? '';                                 //密碼直接從$_POST獲得，未進行escape，之後要進行加密
    $confirm_password = $_POST['confirm_password'] ?? '';


    $email_parts = explode('@', $mail);                                 //透過explode("@", $mail)取得email的用戶名稱前綴，作為account
    $account = $conn->real_escape_string($email_parts[0]);

    $error_message = "";

    if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){                      //filter_var()確保email格式正確
        $error_message .= "請輸入有效的郵箱地址。<br>";
    }

    if(strlen($raw_password) <= 5 || !preg_match("/^(?=.*[A-Za-z])(?=.*\d).+$/", $raw_password)){         //確保密碼至少5位數，且必須包含字母和數字
        $error_message .= "密碼必須包含至少一個英文字母和一個數字，長度超過5。<br>";
    }

    if($raw_password !== $confirm_password){                            //確保兩次輸入的密碼一樣
        $error_message = "確認密碼是否一致。<br>";
    }

    if(empty($raw_password)){
        $error_message = "密碼不能為空。<br>";
    }

    $account_check_query = "SELECT * FROM member WHERE account = '$account' LIMIT 1";       //查詢資料庫，檢查account是否已經存在
    $result = $conn->query($account_check_query);
    if($result && $result->num_rows > 0){
        $error_message = "帳號已存在，請選擇另一個帳號。<br>";
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

        /*if(empty($raw_password)){
            echo"密碼不能為空值";
            exit;
        }*/

        $salt = bin2hex(random_bytes(16));      //生成16位元的salt，用來提高密碼安全性

        //var_dump($raw_password);
        //var_dump($salt);

        $hashedPassword = hash('sha256', $raw_password . $salt);        //使用sha256雜湊加密密碼

        /*if(empty($hashedPassword)){
            echo "密碼加密失敗";
            exit;
        }*/

        //$sql = "INSERT INTO member (username, nickname, phone, mail, account, hashed_password, salt) VALUES ('$username', '$nickname', '$phone', '$mail', '$account', '$hashedPassword', '$salt')";
        //將用戶的資料儲存到member資料表中
    
        // 清空 session，避免因為先前登入或已登入的 session 影響
        session_unset(); // 清除所有 session 資料
        session_destroy(); // 結束 session

        /*if (session_status() == PHP_SESSION_NONE) {
            echo "Session 清除成功！<br>";
        }
        else{
            echo "繼續debug吧你。<br>";
        }*/
        
        $stmt = $conn->prepare("INSERT INTO member(account, username, nickname, phone, mail, address, lineid, hashed_password, salt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $account, $username, $nickname, $phone, $mail, $address, $lineid, $hashedPassword, $salt);

        if($stmt->execute()){
            echo "註冊成功，您的帳號為" . $account . "<br>";
            echo "將在3秒後跳轉到登入頁面。";
            header("refresh:3;url = loginWeb.php");
            exit();
        }
        else{
            echo "註冊失敗：" . $stmt->error;
        }
    }
    else{
        echo $error_message;
    }

    $conn->close();
}
?>