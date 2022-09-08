<?php
// getData.phpの読み込み
require_once('getData.php');

// POSTで受け取った値を変数に格納
$id = $_POST['id'];
$name = $_POST['name'];
$furigana = $_POST['furigana'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$home = $_POST['home'];

// PDOのインスタンスを取得
$pdo = connect();

try {
    // SQL文の準備
    $sql = "UPDATE adress SET name = :name, furigana = :furigana, phone = :phone, email = :email, home = :home WHERE id = :id";
    // プリペアドステートメントの作成
    $stmt = $pdo->prepare($sql);
    // 値のバインド
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':furigana', $furigana);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':home', $home);
    $stmt->bindParam(':id', $id);
    // 実行
    $stmt->execute();
} catch (PDOException $e) {
    exit('データベース接続失敗。' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>編集完了</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <h1>編集完了</h1>
        <p>ID: <?php echo $id; ?>を編集しました。</p>
        <a href="index.php">ホームへ戻る</a>
    </body>
</html>