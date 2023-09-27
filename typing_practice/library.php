<?php

  //htmlspecialchars ファンクション
  function h($value){
    return htmlspecialchars($value,ENT_QUOTES);
  }

  //Databaseへの接続 ファンクション
  function dbconnect(){
    $db = new mysqli('mysql69.conoha.ne.jp','webtk_database','Yoda!121','webtk_database');
    
    if(!$db){
      die($db->error);
    }
    
    return $db;
  }

?>

