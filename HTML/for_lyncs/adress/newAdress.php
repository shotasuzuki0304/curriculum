<?php
// getData.phpの読み込み
require_once('getData.php');

// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$errorMessage2 = "";
$errorMessage3 = "";
$errorMessage4 = "";
$errorMessage5 = "";
$signUpMessage = "";

// POSTでデータが送られていれば処理実行
if (isset ($_POST["signUp"])) {
    // 名前が未入力の場合の処理
    if (empty($_POST['name'])) {
        $errorMessage = '名前を入力してください。';
    }
    if (empty($_POST['furigana'])) {
        $errorMessage2 = 'ふりがなを入力してください。';
    }
    // 電話番号が未入力の場合の処理
    if (empty($_POST['phone'])) {
        $errorMessage3 = '電話番号を入力してください。';
    }
    // メールアドレスが未入力の場合の処理
    if (empty($_POST['email'])) {
        $errorMessage4 = 'メールアドレスを入力してください。';
    }
    // 住所が未入力の場合の処理
    if (empty($_POST['home'])) {
        $errorMessage5 = '住所を入力してください。';
    }

    // 必要項目が全て入力されていた場合の処理
    if (!empty($_POST['name']) && !empty($_POST['furigana']) && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['home'])) {
        // 送られてきた値を変数に格納する
        $name = $_POST['name'];
        $furigana = $_POST['furigana'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $home = $_POST['home'];
        
        // DBに接続する
        $pdo = connect();
        
        // 送られてきたデータをDBに登録する
        try {
            $sql = "INSERT INTO adress(name,furigana,phone,email,home) VALUES(:name,:furigana,:phone,:email,:home)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue('name',$name);
            $stmt->bindValue('furigana',$furigana);
            $stmt->bindValue('phone',$phone);
            $stmt->bindValue('email',$email);
            $stmt->bindValue('home',$home);
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
        <h1>登録画面</h1>
        <!-- エラーメッセージの出力 -->
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage2, ENT_QUOTES); ?></font></div>
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage3, ENT_QUOTES); ?></font></div>
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage4, ENT_QUOTES); ?></font></div>
        <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="名前">
            <br>
            <input type="text" name="furigana" placeholder="ふりがな">
            <br>
            <input type="text" name="phone" placeholder="電話番号">
            <br>
            <input type="text" name="email" placeholder="メールアドレス">
            <br>
            <input type="text" name="home" placeholder="住所">
            <br>
            <input type="submit" value="登録" name="signUp">
        </form>
        <a href = "index.php">アドレス一覧に戻る</a>
    </body>
</html>