<?php
session_start(); // 啟動 Session

// 清除所有 Session 變數
$_SESSION = array();

// 如果使用了 Cookies 存儲 Session，則銷毀 Cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 銷毀 Session
session_destroy();

// 跳轉到登入頁面
echo "成功登出，稍等5秒回到首頁。";
header("refresh:5;url = index.php");
exit();
?>