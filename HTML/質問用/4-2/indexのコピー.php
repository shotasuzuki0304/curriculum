<?php
require_once("getData.php");
$namae = new getData();
$userdata = $namae->getUserData();
// var_dump($userdata);
/*
出力結果
array(4) { ["id"]=> string(1) "1" ["first_name"]=> string(6) "翔伍" ["last_name"]=> string(6) "隼田" ["last_login"]=> string(19) "2022-06-14 12:39:04" } 
object(PDOStatement)#3 (1) { ["queryString"]=> string(36) "SELECT * FROM posts ORDER BY id desc" } 0
*/
$name = $userdata["last_name"].$userdata["first_name"];

$table =new getData();
$tabledata = $table->getPostData();
var_dump($tabledata);




foreach ($table as $key =>$value) {
    echo $key;
    echo $value;
}
?>
//25行目

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
               <div class="above">ようこそ<?php echo $name?>さん</div>
               <div class="under">最終ログイン日：<?php echo $userdata["last_login"];?></div>
           </div>
       </div>

       
       <table class="main">
           <tr>
               <th>記事ID</th>
               <th>タイトル</th>
               <th>カテゴリ</th>
               <th>本文</th>
               <th>投稿日</th>
           </tr>
           <tr>

           </tr>
       </table>
    

       <div class="footer">Y&I group.inc</div>
       </div>
       
    </body>
</html>