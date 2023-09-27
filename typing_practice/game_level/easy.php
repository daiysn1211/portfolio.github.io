<?php
session_start();

if(isset($_SESSION['name'])){
  }else{
    header('Location:../login_out/login.php');
    exit;
  }

require('../library.php');
$db = dbconnect();


//javascriptからのscoreを受け取る
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $score = $_POST["score"];
    echo "受け取った変数の値は：" . $score;
    $name = $_SESSION['name'];
    echo "受け取った変数の値は：" . $name;


  if($score !== 0){
      $form['score']=filter_input(INPUT_POST,'score',FILTER_SANITIZE_NUMBER_INT);

      if($form['score'] === ''){
        $error['score'] = 'blank';
      }

      $stmt = $db->prepare('insert into rank_easy (name,score) VALUES(?,?)');

      if(!$stmt){
          die($db->error);
      }

      $stmt->bind_param('si',$name,$form['score']);

      $success = $stmt->execute();
      if(!$success){
          die($db->error);
      }
  }
};
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
      <title>タイピングゲーム</title>
      <meta charset="UTF-8">
      <meta name="description" content="タイピング上達を目的としたタイピングゲームです。">
      <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="../style.css">
      <audio id="loop" autoplay src="../bgm/battle.mp3"></audio>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
    </head>
    <body>
      <p id="count" class="count">60</p>
      <div id="wrap" class="wrap">
        <span id="untypedJapanese"></span><br>
        <span id="typed" class="typed"></span>
        <span id="untyped"></span>
      </div>
      <button id="escape" onclick="location.href='../title.php'">にげる</button>
      <script type = "text/javascript" src="../js/main.js"></script>
    </body>
    <div id="score"></div>
    <script>
      //やさしいモード
      const textLists = [
      "remon",
      "onngaku",
      "takoyaki",
      "koinobori",
      "rippukuri-mu",
      "dakimakura",
      "puroyakyuusennshu",
      "kyari-ke-su",
      "renntaka-",
      "amenochihare",
      "eigakannshou",
      "goroumaru",
      "kyasshuka-do",
      "kannkokuryokou",
      "daitouryou",
      "uedhinngudoresu",
      "ninnnikumasimasi",
      "sapporora-menn",
      "aohigeojisann",
      "tennshokukatudou",
      "renntogennsatuei",
      "ke-kinyuutou",
      "hyakutennmanntenn",
      "memori-ka-do"
      ]

      const textListsJapanese = [
      "レモン",
      "音楽",
      "たこやき",
      "こいのぼり",
      "リップクリーム",
      "抱き枕",
      "プロ野球選手",
      "キャリーケース",
      "レンタカー",
      "雨のち晴れ",
      "映画鑑賞",
      "五郎丸",
      "キャッシュカード",
      "韓国旅行",
      "大統領",
      "ウエディングドレス",
      "ニンニクマシマシ",
      "札幌ラーメン",
      "青髭おじさん",
      "転職活動",
      "レントゲン撮影",
      "ケーキ入刀",
      "百点満点",
      "メモリーカード"
      ]

      //Javascriptにて出力したscoreをphpへ送信する
      function getScore(){
        var xhr = new XMLHttpRequest();
        // ここの第2引数は自分のphpファイルを指定
        xhr.open("POST", "easy.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            
        var data ="score=" + score;
        
        xhr.onreadystatechange = function () {

        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = xhr.responseText;  
            document.getElementById("score").innerHTML = response;
        }
        }

        // 送る
        xhr.send(data);
        };
    </script>
</html>