<?php
// db_connect.phpの読み込み
require_once('db_connect.php');

// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$errorMessage2 = "";
$signUpMessage = "";

// POSTで送られていれば処理実行
if (isset ($_POST["signUp"])) {
    if (empty($_POST["name"])) {
        $errorMessage = '名前が未入力です。';
    }
    if (empty($_POST["password"])) {
        $errorMessage2 = 'パスワードが未入力です。';
    }
    // nameとpassword両方送られてきたら値を変数に格納
    if (!empty($_POST["name"]) && !empty($_POST["password"])) {
        $name = $_POST["name"];
        $password = $_POST["password"];
        // パスワードをハッシュ化
        $password_hash = password_hash($password,PASSWORD_DEFAULT);
        // PDOのインスタンスを取得
        $pdo = db_connect();

        try {
            // SQL文の準備 (ユーザー登録処理)
            $sql = "INSERT INTO users(name,password) VALUES(:name,:password)";
            // プリペアドステートメントの作成
            $stmt = $pdo->prepare($sql);
            // 値をバインド
            $stmt->bindValue(':name',$name);
            $stmt->bindValue('password',$password_hash);
            // 実行
            $stmt->execute();
            // 登録完了メッセージ出力
            echo "登録が完了しました。";
        }catch (PDOException $e) {
            // エラーメッセージの出力
            $errorMessage = "データベースエラー";
            echo $e->getMessage();
            // 終了
            die();
        }
    }
}
// 8行目 signUpMessageいる？
?>

<!DOCTYPE html>
<html>
    <head>
        <title>ユーザー登録画面</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <h1>ユーザー登録画面</h1>
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage2, ENT_QUOTES); ?></font></div>
        <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="ユーザー名">
            <br>
            <input type="password" name="password" placeholder="パスワード">
            <br>
            <input type="submit" value="新規登録" name="signUp">
        </form>
    </body>
</html>