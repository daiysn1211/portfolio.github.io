<?php
session_start();
require('../library.php');

if(isset($_GET['action']) && $_GET['action'] === 'rewrite' && isset($_SESSION['form'])){
  $form = $_SESSION['form'];
}else{
  $form=[
    'name' =>'',
    'email' =>'',
    'password' =>''
  ];
}

$error=[];

//formが送信され、内容を確認
if($_SERVER['REQUEST_METHOD'] === 'POST'){

  $form['name']=filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);

  if($form['name'] === ''){
    $error['name'] = 'blank';
  }

  $form['email']=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);

  if($form['email'] === ''){
    $error['email'] = 'blank';
  }else{
    $db = dbconnect();
    $stmt = $db->prepare('select count(*) from members where email=?');

    if(!$stmt){
      die($db->error);
    }

    $stmt->bind_param('s',$form['email']);
    $success=$stmt->execute();

    if(!$success){
      die($db->error);
    }

    $stmt->bind_result($cnt);
    $stmt->fetch();

    if($cnt >0){
      $error['email'] = 'duplicate';
    }
  }

  $form['password']=filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);

  if($form['password'] === ''){
    $error['password'] = 'blank';
  } else if(strlen($form['password'])<4){
    $error['password']='length';
  }

  //エラーがなければ、check.phpに飛ぶようにできる
  if(empty($error)){
      //name,email,passwordで取得した情報をセッション内に保存する
      $_SESSION['form'] = $form;
      header('Location:check.php');
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
    <title>アカウント作成</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
    <script type = "text/javascript" src="../js/sub.js"></script>
  </head>
  <body>
    <div id="inquiry-title">
      <h1>アカウント作成</h1>
    </div>
    <div id="announce">
      <p>ゲームプレーにはアカウント登録がひつようです</p>
      <p><a href="../login_out/login.php">ログイン</a>はこちら</p>
    </div>
    <div id="join">
      <form action="" method="post" enctype="multipart/form-data">
        <dl>
          <dt>・ニックネーム<span id="required">必須</span></dt>
          <dd>
            <input type="text" id="nickname" name="name" size="35" value="<?php echo h($form['name'])?>"/>
            <?php if(isset($error['name']) && $error['name']==='blank'):?>
              <p class="error">* ニックネームを入力してください</p>
            <?php endif;?>
          </dd>
          <dt>・メールアドレス<span id="required">必須</span></dt>
          <dd>
            <input type="text" id="join_email" name="email" size="35" value="<?php echo h($form['email'])?>"/>
            <?php if(isset($error['email']) && $error['email'] ==='blank'):?>
              <p class="error">*メールアドレスを入力してください</p>
            <?php endif;?>
          </dd>
            <?php if(isset($error['email'])&& $error['email'] === 'duplicate'):?>
              <p class="error">* 指定されたメールアドレスはすでに登録されています</p>
            <?php endif; ?>
          <dt>・パスワード<span id="required">必須</span></dt>
          <dd>
          <input type="password" id="join_pass" name="password" size="35" value="<?php echo h($form['password'])?>"/>
            <?php if(isset($error['password'])&& $error['password'] ==='blank'):?>
              <p class="error">*パスワードを入力してください</p>
            <?php endif;?>
            <br>
              <button id="btn_passview">ひょうじ</button>
            <?php if(isset($error['password'])&& $error['password'] === 'length'):?>
              <p class="error">*パスワードは4文字以上で入力してください</p>
            <?php endif;?>
          </dd>
        </dl>
      </div>
      <input id="check" type="submit" value="ないようかくにん">
    </form>
  </body>
</html>