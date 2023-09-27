<?php
session_start();
require('../library.php');
$db=dbconnect();

if(isset($_GET['action']) && $_GET['action'] === 'rewrite' && isset($_SESSION['form'])){
  $form = $_SESSION['form'];
} else{
$form=[
  'name' =>'',
  'message' =>''
];
}
$error=[];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $form['name']=filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
  if($form['name'] === ''){
    $error['name'] = 'blank';
  }

  $form['message']=filter_input(INPUT_POST,'message',FILTER_SANITIZE_STRING);
  if($form['message'] === ''){
    $error['message'] = 'blank';
  }

  if(empty($error)){
    //name,messageで取得した情報をセッション内に保存する
    $_SESSION['form'] = $form;
    header('Location:inqu_check.php');
    exit();
}
}
?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>TOIECクエスト</title>
    <audio id="loop" autoplay src="../bgm/title.mp3"></audio>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
  </head>
  <body>
    <div id="inquiry-title">
      <h1>問い合わせ</h1>
      <form action="" method="post" enctype="multipart/form-data">
    </div>
        <p style="font-size: 20px;">今後の開発に向けて、ゲームの感想やリクエストを聞かせてください</p>
        <dt>・コメント<span id="required">必須</span></dt>
        <dd>
          <textarea id="content" name="message" cols="50" rows="10" placeholder="感想・リクエストを聞かせてください"></textarea>
          <?php if(isset($error['message'])&& $error['message'] === 'blank'):?>
          <p class="error">*コメントを入力してください</p>
          <?php endif;?>
        </dd>
        <input id="post" type="submit" value="おくる"></input>
      </form>
      <input id="post" type="submit" value="もどる" onclick="location.href='../title.php'"></input>

  </body>

</html>