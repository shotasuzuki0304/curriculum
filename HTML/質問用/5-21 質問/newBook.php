<?php
require_once('db_connect.php');

$errorMessage = "";
$errorMessage2 = "";
$errorMessage3 = "";
$signUpMessage = "";

if (isset ($_POST["signUp"])) {
    if (empty($_POST['title'])) {
        $errorMessage = 'タイトルを入力してください。';
    }
    if (empty($_POST['release'])) {
        $errorMessage2 = '発売日を入力してください。';
    }
    if (empty($_POST['lot'])) {
        $errorMessage3 = '在庫数を選択してください。';
    }
    if (!empty($_POST['title']) && !empty($_POST['release']) && !empty($_POST['lot'])) {
        $title = $_POST['title'];
        $release = $_POST['release'];
        $lot = $_POST['lot'];

        $pdo = db_connect();

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
        <h1>本 登録画面</h1>
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage2, ENT_QUOTES); ?></font></div>
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage3, ENT_QUOTES); ?></font></div>
        <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
        <form method="POST" action="">
        <input type="text" name="title" placeholder="タイトル">
            <br>
            <input type="text" name="release" placeholder="発売日">
            <br>
            <p>在庫数</p>
            <select name="lot">
                <option value="" selected>選択してください</option>
                <option value="10">10</option>
                <option value="10">15</option>
                <option value="10">20</option>
            </select>
            <br>
            <input type="submit" value="登録" name="signUp">
        </form>
    </body>
</html>