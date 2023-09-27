<?php
session_start();
require('../library.php');

//直接check.phpにアクセスするとindex.phpで内容入力していないので、エラー表記になるときがある
//その時のためにcheckにアクセスしないようにindexからアクセスする
if(isset($_SESSION['form'])){
//index.phpで取得したセッション情報を受け取る
	$form = $_SESSION['form'];
} else {
	header('Location:join.php');
	exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
	//dbファンクションをlibraryにて作成
$db = dbconnect();

//パスワードはdbに直接保存してしまうとリスクがあるので、$passwordに文字列として格納できるように実装する
$password = password_hash($form['password'],PASSWORD_DEFAULT);
$stmt = $db->prepare('insert into members (name,email,password) VALUES(?,?,?)');
if(!$stmt){
	die($db->error);
}

$stmt->bind_param('sss',$form['name'],$form['email'],$password);
$success = $stmt->execute();
if(!$success){
	die($db->error);
}
//ユーザー情報の重複をしてはいけないので、ここでsession情報を消す
unset($_SESSION['form']);

//登録完了画面へ飛ばす
header('Location:complete.php');
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
	<div id="confirm">
		<p>記入した内容を確認して、「とうろく」ボタンをクリックしてください</p>
		<form action="" method="post">
			<dl>
				<dt>ニックネーム</dt>
				<dd><?php echo h($form['name']); ?></dd>
				<dt>メールアドレス</dt>
				<dd><?php echo h($form['email']); ?></dd>
				<dt>パスワード</dt>
				<dd>【表示されません】</dd>
			</dl>
			<div id="rewrite">
					<a href="join.php?action=rewrite">&laquo;&nbsp;書き直す</a> | <input id="resister" type="submit" value="とうろく" />
			</div>
		</form>
	</div>
</body>
</html>
