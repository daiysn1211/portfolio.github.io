<?php
session_start();

//ログイン中のセッション情報を全て消す
unset($_SESSION['id']);
unset($_SESSION['name']);

header('Location:login.php'); 
exit();
?>
