<?php
session_start();
unset($_SESSION);
session_destroy();
setcookie("user_id", null, time() - 3600);

// Carrega o template message_template.html
header("Location: message_template.html");
?>