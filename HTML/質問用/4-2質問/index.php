<?php
require_once("getData.php");
//getData.phpを一度だけ読み込む

$namae = new getData();
$userdata = $namae->getUserData();
//$namaeというインスタンスを作成し、$namaeからUserData()関数を実行して得た結果を、$userdataとして定義する

// var_dump($userdata);
/*
出力結果
array(4) { ["id"]=> string(1) "1" ["first_name"]=> string(6) "翔伍" ["last_name"]=> string(6) "隼田" ["last_login"]=> string(19) "2022-06-14 12:39:04" } 
object(PDOStatement)#3 (1) { ["queryString"]=> string(36) "SELECT * FROM posts ORDER BY id desc" } 0
*/

$name = $userdata["last_name"].$userdata["first_name"];
/*
関数getUserData();はデータベースのusersテーブルから1つの値を取ってくるというもの
実行内容：$getusers_sql = "SELECT * FROM users limit 1";
今回使いたいのはlast_nameとfirst_nameなのでそれを抽出し変数$namaeに格納する
*/

$table = $namae->getPostData();
//getPostData()に定義されているもう一つの関数を使いたいだけなので、同じインスタンスを使い回す

?>


<!DOCTYPE html>
<html lang="en">    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

<html>
    <head>
        <meta charset="UTF-8" />
        <title>Document</title>
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
       <div class="header clearfix">
           <img class="left" src="1599315827_logo.png">
           <div class="right">
               <div class="above">ようこそ <?php echo $name?> さん</div>
               <div class="under">最終ログイン日：<?php echo $userdata["last_login"];?></div>
           </div>
       </div>

       
       <table border class="main">
           <tr>
               <th>記事ID</th>
               <th>タイトル</th>
               <th>カテゴリ</th>
               <th>本文</th>
               <th>投稿日</th>
           </tr>
           <?php foreach ($table as $key) {?>
           <tr>
              <td><?php echo $key["id"]; ?></td>
              <td><?php echo $key["title"]; ?></td>
              <td><?php 
              $category = $key["category_no"];
              if ($category == 1) {
                  echo "食事";
              } elseif ($category == 2) {
                  echo "旅行";
              } else {
                  echo "その他";
              }?></td>
              <td><?php echo $key["comment"]; ?></td>
              <td><?php echo $key["created"]; ?></td>
           </tr>
           <?php }?>
       </table>
    

       <div class="footer">Y&I group.inc</div>
       </div>
       
    </body>
</html>