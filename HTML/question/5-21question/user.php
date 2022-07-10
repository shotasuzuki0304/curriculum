<!-- CSSファイルの読み込み -->
<link rel="stylesheet" href="style.css">

<?php
// db_connect.phpの読み込み
require_once('db_connect.php');

// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$errorMessage2 = "";
$signUpMessage = "";

// POSTでデータが送られていれば処理実行
if (isset ($_POST["signUp"])) {
    // 名前が未入力の場合の処理
    if (empty($_POST["name"])) {
        $errorMessage = '名前が未入力です。';
    }
    // パスワードが未入力の場合の処理
    if (empty($_POST["password"])) {
        $errorMessage2 = 'パスワードが未入力です。';
    }
    // nameとpassword両方送られてきたら処理実行
    if (!empty($_POST["name"]) && !empty($_POST["password"])) {
        // 送られてきた値を変数に格納
        $name = $_POST["name"];
        $password = $_POST["password"];
        // パスワードをハッシュ化
        $password_hash = password_hash($password,PASSWORD_DEFAULT);
        
        // PDOのインスタンスを取得
        $pdo = db_connect();
        
        // ユーザー名とパスワードをDBに登録する
        try {
            $sql = "INSERT INTO users(name,password) VALUES(:name,:password)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':name',$name);
            $stmt->bindValue('password',$password_hash);
            $stmt->execute();
            echo "登録が完了しました。";
        }catch (PDOException $e) {
            $errorMessage = "データベースエラー";
            echo $e->getMessage();
            die();
        }
    }
}
// 11行目 signUpMessageいる？
?>

<!DOCTYPE html>
<html>
    <head>
        <title>ユーザー登録画面</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <h1 class="usertouroku">ユーザー登録画面</h1>
        <!-- エラーメッセージの出力 -->
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage2, ENT_QUOTES); ?></font></div>
        <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="ユーザー名" class="name">
            <br>
            <input type="password" name="password" placeholder="パスワード" class="pass">
            <br>
            <input type="submit" value="新規登録" name="signUp" class="botton">
        </form>
    </body>
</html>