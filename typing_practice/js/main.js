//変数の初期化
let untyped ="";
let untypedJapanese ="";
let typed ="";
let score =0;

//必要なhtmlの取得
const untypedfieldJapanese = document.getElementById("untypedJapanese");
const untypedfield = document.getElementById("untyped");
const typedfield = document.getElementById("typed");
const wrap = document.getElementById("wrap");
const count = document.getElementById("count");


//タイピング音を設定
var se = new Audio("../bgm/keyboard.mp3");
onkeydown = (e) => {
se.currentTime = 0;
se.play();
};


//ランダムにテキストを表示する
const createText = () => {
//正しいタイプをした文字列のクリア
//初期化しないと次の問題でも前の問題が残ってしまう
typed="";
typedfield.textContent=typed;

//配列からランダムな数値を生成する(Math.floorメソッド)
let random = Math.floor(Math.random() *textLists.length);
//配列からランダムにテキストを取得し画面を表示する
untyped = textLists[random];
untypedfield.textContent = untyped;
untypedJapanese = textListsJapanese[random];
untypedfieldJapanese.textContent = untypedJapanese;
}    


//eはイベントオブジェクトを受け取るための引数
const keyPress = e => {
//タイポ音を設定
var fm= new Audio("../bgm/se_damage4.mp3");
//タイポのの場合
//substring(文字列,文字列)で文字数を取得することができ、この場合は0~1文字を指定し、1文字のみ取得
if(e.key !==untyped.substring(0,1)){
//クラス属性を追加する(mistypedという)、これによりタイプミスの時mistypedのcssが反応する
wrap.classList.add("mistyped");
fm.currentTime = 0;
fm.play();
//setTimeout(callback(実行したい関数), delay(何ミリ秒後に実行するか、初期値は0))
setTimeout(() => {
//さっきaddしたclass属性を削除する
wrap.classList.remove("mistyped");
},100);

return;
}

//正しいタイピングを打った時
//スコアを増やす
score++;
typed += untyped.substring(0,1);
untyped = untyped.substring(1);
typedfield.textContent = typed;
untypedfield.textContent = untyped;
if(untyped ===""){
createText();
}
};



//ゲーム終了時の音を設定
var gm= new Audio("../bgm/victory.mp3");

//タイピングスキルのランクを判定
const rankCheck = score => {

// テキストを格納する変数を作る
let text = '';
gm.currentTime = 0;
gm.play();                
// スコアに応じて異なるメッセージを変数textに格納する
if(score < 150) {
text = `あなたのランクはCです。\nBランクまであと${150 - score}文字です。\n称号:そこら辺の村人`;
} else if(score < 250) {
text = `あなたのランクはBです。\nAランクまであと${250 - score}文字です。\n称号:脳筋勇者`;    
} else if(score < 350) {
text = `あなたのランクはAです。\nSランクまであと${350 - score}文字です。\n称号:量産型勇者`;    
} else if(score >= 350) {
text = `あなたのランクはSです。\nおめでとうございます!\n称号:偉大なる勇者(王冠かぶってる)`;    
}
//生成したメッセージと一緒に文字列を返す
return`${score}文字打てました！\n${text}\n【Ok】リトライ / 【キャンセル】終了`
};



//ゲームを終了
function gameOver(id) {
clearInterval(id);  
const result = confirm(rankCheck(score));

//OKボタンをクリックされたらリロードする
if (result == true) {
window.location.reload();
getScore();
} 
}

//カウントダウンタイマー
const timer = () => {
//タイマー部分のHTML要素(p要素)を取得する
let time = count.textContent;
const id = setInterval(() =>{
//カウントダウンする、1秒ずつ減らす
time--;
count.textContent = time;
//カウントが0になったらタイマーを停止する
if(time <= 0){
gameOver(id);
// JavaScriptでスコアを保持
typedfield.remove();
untypedfield.remove();
untypedfieldJapanese.remove();
wrap.textContent = "Enterキーでもういちどたたかう";

document.addEventListener('keypress',restart); 

function restart(e){
  if(e.key === "Enter"){
    window.location.reload();
  }
}
}
},1000);
};


//開始前の3秒カウントダウン
//ゲームスタート時の処理(Enterキー)
let countNumber = 4;

document.addEventListener('keypress',keypress_ivent);

function keypress_ivent(e){
if(e.key === 'Enter'){
function countDown(){
countNumber--;
if(countNumber > 0){
  untypedfield.textContent = countNumber;
}else{
  clearInterval(countDownId);
  timer();
  createText();
  document.addEventListener("keypress",keyPress); 
}
}
const countDownId = setInterval(countDown,500);
};

return false;
}

untypedfield.textContent = "たたかうボタンで開始(Enterキー)";






