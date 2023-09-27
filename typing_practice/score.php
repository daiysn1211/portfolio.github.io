<?php
session_start();
require('library.php');
$db = dbconnect();

if(!isset($_SESSION['name'])){
  header('Location:/login_out/login.php');
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
    <title>ランキング</title>
    <audio id="loop" autoplay src="bgm/title.mp3"></audio>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
    <script type = "text/javascript" src="js/sub.js"></script>
  </head>
  <body>
    <div id="score_title">
      <h1>スコアランキング</h1>
      <p>!! タイピングキングをめざそう !!</p>
    </div>

    <?php
    $stmt=$db->prepare('select name,score from rank_easy order by score desc limit 5');

    if(!$stmt){
      die($db->error);
    }
    $success = $stmt->execute();

    if(!$success){
      die($db->error);
    }

    $stmt->bind_result($name,$score);
    ?>
    <div id="ranking">
      <h2>やさしい</h2>
      <?php while($stmt->fetch()):?>
        <table border="5" align="center">
          <tr>
            <th width="250px">ニックネーム</th>
            <th width="100px">スコア</th>
          </tr>
          <tr>
            <th><?php echo h($name);?>さん</th>
            <th><?php echo h($score);?>点</th>
          </tr>
        </table>
    <?php endwhile;?>

    <?php
    $stmt=$db->prepare('select name,score from rank_middle order by score desc limit 5');

    if(!$stmt){
      die($db->error);
    }
    $success = $stmt->execute();
    
    if(!$success){
      die($db->error);
    }
    $stmt->bind_result($name,$score);
    ?>
      <h2>ふつう</h2>
      <?php while($stmt->fetch()):?>
        <table border="5" align="center">
          <tr>
            <th width="250px">ニックネーム</th>
            <th width="100px">スコア</th>
          </tr>
          <tr>
            <th><?php echo h($name);?>さん</th>
            <th><?php echo h($score);?>点</th>
          </tr>
        </table>
      <?php endwhile;?>
      <?php
      $stmt=$db->prepare('select name,score from rank_difficult order by score desc limit 5');

      if(!$stmt){
        die($db->error);
      }
      $success = $stmt->execute();
      if(!$success){
        die($db->error);
      }
      $stmt->bind_result($name,$score);
      ?>
        <h2>むずかしい</h2>
        <?php while($stmt->fetch()):?>
          <table border="5" align="center">
            <tr>
              <th width="250px">ニックネーム</th>
              <th width="100px">スコア</th>
            </tr>
            <tr>
              <th><?php echo h($name);?>さん</th>
              <th><?php echo h($score);?>点</th>
            </tr>
          </table>
    <?php endwhile;?>
    </div>
    <input id="post" type="submit" value="もどる" onclick="location.href='title.php'"></input>
  </body>
</html>