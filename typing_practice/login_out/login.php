<?php
session_start();

require('../library.php');
$email= '';
$password= '';
$error= [];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $email= filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
  $password= filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);

  if($email === '' || $password === ''){
    $error['login'] = 'blank';
  }else{
    $db = dbconnect();
    $stmt = $db->prepare('select id, name , password from members where email =? limit 1');

    if(!$stmt){
      die($db->error);
    }
    $stmt->bind_param('s',$email);
    $success = $stmt->execute();

    if(!$success){
      die($db->error);
    }

    $stmt->bind_result($id,$name,$hash);
    $stmt->fetch();

    if(password_verify($password,$hash)){
      session_regenerate_id();
      $_SESSION['id'] = $id;
      $_SESSION['name'] = $name;
      header('Location:login_complete.php');
      exit();
    }else{
      $error['login'] = 'failed';
    }
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
    <title>ログイン</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
    <script type = "text/javascript" src="../js/sub.js"></script>
  </head>
  <body>
    <div id="inquiry-title">
      <h1>ログイン</h1>
    </div>
    <div id="login_confirm">
      <p>メールアドレスとパスワードを記入してログインしてください</p>
      <p><a href="../make_account/join.php">アカウント作成</a>はこちら</p>
      <form action="" method="post">
        <dl>
          <dt>・メールアドレス</dt>
          <dd>
          <input type="text" id="input_email" name="email" size="35" value="<?php echo h($email)?>"/>
          <?php if(isset($error['login'])&& $error['login'] === 'blank'):?>
            <p class="error">*メールアドレスとパスワードをご記入ください</p>
          <?php endif;?>
          <?php if(isset($error['login'])&& $error['login'] === 'failed') :?>
            <p class="error">*ログインに失敗しました。再入力ください</p>
          <?php endif;?>
          </dd>
          <dt>・パスワード</dt>
          <dd>
            <input type="password" id="input_pass" name="password" size="35"  style="margin-right:110px;" value="<?php echo h($password)?>"/>
          </dd>
        </dl>
        <div>
          <input id="check" type="submit" value="ログインする"/>
        </div>
      </form>
    </div>
  </body>
</html>