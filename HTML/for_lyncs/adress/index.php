<?php
// getData.phpを一度だけ読み込む
require_once("getData.php");

// $namaeというインスタンスを作成し
// $namaeからgetUserAdress()関数を実行して得た結果を、$userdataとして定義する
$namae = new getData();
$userdata = $namae->getUserAdress();
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
       <a href = "newAdress.php">新規登録</a>
       <h1 class="booktouroku">アドレス一覧</h1>
       <table border>
           <tr>
               <th>名前</th>
               <th>電話番号</th>
               <th>メールアドレス</th>
               <th>住所</th>
               <th>編集</th>
               <th>削除</th>
           </tr>
           <?php foreach ($userdata as $key) {?>
           <tr>
              <td><?php echo $key["name"]; ?></td>
              <td><?php echo $key["phone"]; ?></td>
              <td><?php echo $key["email"]; ?></td>
              <td><?php echo $key["home"]; ?></td>
              <td><a href="edit.php?id=<?php echo $key['id']?>">編集</a></td>
              <td><a href="delete.php?id=<?php echo $key['id']?>">削除</a></td>
           </tr>
           <?php }?>
       </table>
    </body>
</html>