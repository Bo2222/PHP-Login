<?php
function sendEmail($to, $subject, $message) {
    mail($to, $subject, $message);
}

function sendSMS($phone, $message) {
    // 簡訊 API 介接
}

function sendLine($line_id, $message) {
    // LINE API 介接
}
?>