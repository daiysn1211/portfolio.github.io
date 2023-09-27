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

      $stmt = $db->prepare('insert into rank_difficult (name,score) VALUES(?,?)');

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
      <script>
        //むずかしいモード
        const textLists = [ 
        "kyari-pamyupamyunoraibu",
        "okuchinichakku",
        "parareruwa-rudonimayoikomu",
        "oreoresaginihikkakaru",
        "namamuginamagomenamatamago",
        "basugasubakuhatu",
        "yo-ropparyokoukyaku",
        "daikoubutuhapurinntaruto",
        "mennma",
        "kakatogaitai",
        "hyakushouikki",
        "mainndokonntoro-ru",
        "koushokyouhushouhabokunokoto",
        "subarasiijinnsei",
        "sa-ba-hesetuzoku",
        "meruthi-kissu",
        "usbnotaipucgahosiinndakedo",
        "iekeira-mennyoritennkaippinn",
        "barikannde5miri",
        "ta-mine-ta-karanoshochuumimai",
        "piyopiyopannchihakikanaiyo",
        "pyonnkichihabokunokaerudayo",
        "maza-bo-dogakidousuru",
        "mameshibadaisukiicchokusenn"
        ]

        const textListsJapanese = [
        "きゃりーぱみゅぱみゅのライブ",
        "お口にチャック",
        "パラレルワールドに迷い込む",
        "オレオレ詐欺に引っかかる",
        "生麦生米生卵",
        "バスガス爆発",
        "ヨーロッパ旅行客",
        "大好物はプリンタルト",
        "メンマ",
        "踵が痛い",
        "百姓一揆",
        "マインドコントロール",
        "高所恐怖症は僕の事",
        "素晴らしい人生",
        "サーバーへ接続",
        "メルティーキッス",
        "USBのタイプCがほしいんだけど",
        "家系ラーメンより天下一品",
        "バリカンで5ミリ",
        "ターミネーターからの暑中見舞い",
        "ピヨピヨパンチは効かないよ",
        "ぴょん吉は僕のカエルだよ",
        "マザーボードが起動する",
        "豆しば大好き一直線"
        ]

        //Javascriptにて出力したscoreをphpへ送信する
        function getScore(){
          var xhr = new XMLHttpRequest();
          // ここの第2引数は自分のphpファイルを指定
          xhr.open("POST", "difficult.php", true);
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
    </body>
      <div id="score"></div>
</html>