<?php
session_start();

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>アカウント作成</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
    <script type = "text/javascript" src="../js/sub.js"></script>
  </head>
  <body>
    <div id="inquiry-title">
      <h1>アカウント登録</h1>
    </div>
    <div id="complete">
      <p>とうろくかんりょうしました</p>
      <input id="btn_login" type="submit" value="ログイン" onclick="location.href='/typing_practice/login_out/login.php'">
    </div>
  </body> 
</html>
