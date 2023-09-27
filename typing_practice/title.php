<?php
require('library.php');
$db = dbconnect();

session_start();

if(!isset($_SESSION['name'])){
  header('Location:/typing_practice/login_out/login.php');
  exit;
}

$name = $_SESSION['name'];
?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>タイピングクエスト</title>
    <audio id="loop" autoplay src="bgm/title.mp3"></audio>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
    <script type = "text/javascript" src="js/sub.js"></script>
  </head>
  <body>
    <p id="user">おかえりなさい、<span id="username"><?php echo h($name);?></span>さん</p>
    <div id="wrap" class="wrap">
      <span id="typed" class="typed"></span>タイピングクエスト<span id="untyped"></span>
      <p>~目指せタイピングマスター~</p>
    </div>
      <button id="easy" onclick="location.href='game_level/easy.php'">やさしい</button>
      <button id="middle" onclick="location.href='game_level/middle.php'">ふつう</button>
      <button id="difficult" onclick="location.href='game_level/difficult.php'">むずかしい</button>
    <br>
    <div id="option">
      <a href="inquiry/inquiry.php">問い合わせ</a>
      <a href="score.php">スコアランキング</a>
      <a href="login_out/logout.php">ログアウト</a>
    </div>
  </body>
</html>