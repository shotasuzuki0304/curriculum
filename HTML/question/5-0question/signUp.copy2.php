<?php

// db_connect.phpの読み込みFILL_IN
require_once("db_connect.php");

// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$signUpMessage = "";

//入力してない場合の処理を書く
//if文はネスト化可能、優先度が高いものから書いていく
//iseset→イエスかノーか判定する(フォームのsubmitで判定を行うことができる)

// POSTで送られていれば処理実行
// nameとpassword両方送られてきたら処理実行
if (isset ($_POST["signUp"])) {
    if (empty($_POST["name"])) {
        $errorMessage = '名前が未入力です。';
        } else if (empty($_POST["password"])) {
            $errorMessage = 'パスワードが未入力です。';
    }
        if(!empty($_POST["name"]) && !empty($_POST["password"])) {
                $name = $_POST['name'];
                $password = $_POST['password'];
        // PDOのインスタンスを取得FILL_IN
        $pdo = db_connect();
        
            try {
            // SQL文の準備 FILL_IN (ユーザー登録処理)
            $stmt = $pdo->prepare('INSERT INTO users(name, password) VALUES(:name, :password)');
            // パスワードをハッシュ化
            $password = $_POST["password"];
            $password_hash = password_hash($password,PASSWORD_DEFAULT);
            // プリペアドステートメントの作成 FILL_IN
            // 値をセット FILL_IN
            $stmt->bindValue(':name',$name);
            $stmt->bindValue(':password',$password_hash); 
            // 実行 FILL_IN
            $stmt->execute();
            // 登録完了メッセージ出力
            echo "登録が完了しました";
            }catch (PDOException $e) {
            // エラーメッセージの出力 FILL_IN 
            $errorMessaage = 'データベースエラー';
                echo $e->getMessage();
            // 終了 FILL_IN
                die();
            }
        }
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
    <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
    <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
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

