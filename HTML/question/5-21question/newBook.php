<!-- CSSファイルの読み込み -->
<link rel="stylesheet" href="style.css">

<?php
// db_connect.phpの読み込み
require_once('db_connect.php');

// セッション開始
session_start();

// セッション値がなければ(ログインしていなければ)ログインページに飛ばす
if (empty($_SESSION["user_name"])) {
    header("Location: login.php");
    exit;
}

// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$errorMessage2 = "";
$errorMessage3 = "";
$signUpMessage = "";

// POSTでデータが送られていれば処理実行
if (isset ($_POST["signUp"])) {
    // タイトルが未入力の場合の処理
    if (empty($_POST['title'])) {
        $errorMessage = 'タイトルを入力してください。';
    }
    // 発売日が未入力の場合の処理
    if (empty($_POST['release'])) {
        $errorMessage2 = '発売日を入力してください。';
    }
    // 在庫数が未入力の場合の処理
    if (empty($_POST['lot'])) {
        $errorMessage3 = '在庫数を選択してください。';
    }
    // 必要項目が全て入力されていた場合の処理
    if (!empty($_POST['title']) && !empty($_POST['release']) && !empty($_POST['lot'])) {
        // 送られてきた値を変数に格納する
        $title = $_POST['title'];
        $release = $_POST['release'];
        $lot = $_POST['lot'];
        
        // DBに接続する
        $pdo = db_connect();
        
        // 送られてきたデータをDBに登録する
        try {
            $sql = "INSERT INTO books(title,date,stock) VALUES(:title,:date,:stock)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue('title',$title);
            $stmt->bindValue('date',$release);
            $stmt->bindValue('stock',$lot);
            $stmt->execute();
            echo '登録が完了しました。';
        } catch (PDOException $e) {
            $errorMessage = "データベースエラー";
            echo $e->getMessage();
            die();
        }
    }
}


?>

<!DOCTYPE html>
<html>
    <head>
        <title>登録画面</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <h1 class="booktouroku">本 登録画面</h1>
        <!-- エラーメッセージの出力 -->
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage2, ENT_QUOTES); ?></font></div>
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage3, ENT_QUOTES); ?></font></div>
        <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
        <form method="POST" action="">
        <input type="text" name="title" placeholder="タイトル" class="title">
            <br>
            <input type="text" name="release" placeholder="発売日" class="release">
            <br>
            <p class="zaiko_lot">在庫数</p>
            <select name="lot">
                <option value="" selected class="select">選択してください</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
            <br>
            <input type="submit" value="登録" name="signUp" class="bookbotton">
        </form>
    </body>
</html>