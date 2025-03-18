# PHP-Login
<div>
  <p>依據Ithome鐵人賽此作者所撰寫的文章去做此專案，在這基礎上依據自己執行後遇到的問題去做程式碼修改，再加上自己認為需要新增的功能。</p>
  <a href = "https://ithelp.ithome.com.tw/users/20152215/ironman/6723?page=1">Ithome參考網址</a>
</div>
<br>

# 系統功能
<div>
  <ul>
    <li>註冊</li>
    <li>登入登出</li>
    <li>預約</li>
    <li>取消預約</li>
    <li>預約通知</li>
    <li>修改會員資料</li>
    <li>修改密碼</li>
    <li>管理員查看所有訂單、完成訂單</li>
  </ul>
</div>
<br>

# 使用到的技術
<div>
  <ul>
    <li>real_escape_string()：</li>
    <p>用來防止SQL注入(injection)攻擊，對輸入的字串進行轉義，確保特殊字元不會影響SQL查詢的結構。</p>
    <li>prepare statement 和binding：</li>
    <p>Prepare statement先將sql語句送到MySQL，讓資料庫預編譯，再傳入參數。SQL和使用者輸入是分開處理的，不會因惡意輸入而導致影響。Binding是參數綁定，用?當作佔位符，再用bind_param()將參數綁定進去，以防止SQL注入。</p>
    <li>trim()：</li>
    <p>用來移除字串開頭和結尾的空白字元，防止意外的空白導致驗證失敗。</p>
    <li>session_unset()：</li>
    <p>清除所有 session 資料。</p> 
    <li>session_destroy() ：</li>
    <p>結束session。</p>
    <li>htmlspecialchar()：</li>
    <p>用來轉換部分特殊字元，並防止XSS攻擊「跨站腳本攻擊」。</p>
  </ul>
</div>




