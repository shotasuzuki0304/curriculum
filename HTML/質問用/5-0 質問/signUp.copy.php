<?php

// db_connect.phpの読み込みFILL_IN
require_once("db_connect.php");

//入力してない場合の処理を書く
//if文はネスト化可能、優先度が高いものから書いていく
//iseset→イエスかノーか判定する(フォームのsubmitで判定を行うことができる)

// POSTで送られていれば処理実行
// nameとpassword両方送られてきたら処理実行
if (isset ($_POST["signUp"])) {
    //送られて来た値を変数に格納する
    $user = $_POST['name'];
    $password = $_POST['password'];
    
    // PDOのインスタンスを取得FILL_IN
    $pdo = db_connect();
    
    try {
    // SQL文の準備 FILL_IN (ユーザー登録処理)
    
    // パスワードをハッシュ化
    $password = $_POST["password"];
    $password_hash = password_hash($password,PASSWORD_DEFAULT);

    // プリペアドステートメントの作成 FILL_IN
    // 値をセット FILL_IN
    $stmt->bindValue(':password',$password_hash); 

    // 実行 FILL_IN
    $stmt->excute();

    // 登録完了メッセージ出力
    echo "登録が完了しました";
    }catch (PDOException $e) {
    // エラーメッセージの出力 FILL_IN 
    $errorMessaage = 'データベースエラー';
        echo $e->getMessage();
    // 終了 FILL_IN
        die();
    }

    }else {
        echo 'パスワードと名前を入力してください';
    }
    

?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
    <h1>新規登録</h1>
    <form method="POST" action="">
        user:<br>
        <input type="text" name="name" id="name">
        <br>
        password:<br>
        <input type="password" name="password" id="password"><br>
        <input type="submit" value="submit" id="signUp" name="signUp">
    </form>
</body>
</html>

