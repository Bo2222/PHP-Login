<?php session_start(); ?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員資料修改</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<h2>會員資料修改</h2>
<form id="profileForm">
    <label>使用者名稱：</label>
    <input type="text" name="username" value="<?php echo $_SESSION['username']; ?>" required><br>

    <label>暱稱：</label>
    <input type="text" name="nickname" value="<?php echo $_SESSION['nickname']; ?>" ><br>

    <label>電話：</label>
    <input type="text" name="phone" value="<?php echo $_SESSION['phone']; ?>"><br>

    <label>信箱：</label>
    <input type="text" name="mail" value="<?php echo $_SESSION['mail']; ?>" ><br>

    <label>地址：</label>
    <textarea name="address"><?php echo $_SESSION['address']; ?></textarea><br>

    <h3>變更密碼（選填）</h3>
    <label>舊密碼：</label>
    <input type="password" name="old_password"><br>

    <label>新密碼：</label>
    <input type="password" name="new_password"><br>

    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); ?>">

    <button type="submit">更新資料</button>
</form>

<div id="message"></div>

<script>
$(document).ready(function() {
    $("#profileForm").submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: "update_profile.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                $("#message").text(response.message);
                if (response.status === "success") {
                    $("#message").css("color", "green");
                } else {
                    $("#message").css("color", "red");
                }
            },
            error: function() {
                $("#message").text("請求失敗").css("color", "red");
            }
        });
    });
});
</script>

</body>
</html>