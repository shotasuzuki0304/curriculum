<?php
// db_connect.phpの読み込み
require_once('getData.php');

// メインページから送られてきたidをキャッチ
$id = $_GET['id'];

// idが空だったらメインページにリダイレクトする
if (empty($id)) {
    header("Location: index.php");
    exit;
}

// DBに接続する
$pdo = connect();

try {
    // SQL文の準備
    $sql = "SELECT * FROM adress WHERE id = :id";
    // プリペアドステートメントの作成
    $stmt = $pdo->prepare($sql);
    // idのバインド
    $stmt->bindParam(':id', $id);
    $stmt->execute();
} catch (PDOException $e) {
    // エラーメッセージの出力
    echo 'Error: ' . $e->getMessage();
    // 終了
    die();
}

// 結果が1行取得できたら
if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $name = $row['name'];
    $furigana = $row['furigana'];
    $phone = $row['phone'];
    $email = $row['email'];
    $home = $row['home'];
} else {
    // 対象のidでレコードがない => 不正な画面遷移
    echo "対象のデータがありません。";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>編集画面</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <h1>編集画面</h1>
        <form method="POST" action="edit_done_post.php">
            <input type="hidden" name="id" value="<?php echo $id; ?>" >
            <br>
            <input type="text" name="name" value="<?php echo $name;?>">
            <br>
            <input type="text" name="furigana" value="<?php echo $furigana;?>">
            <br>
            <input type="text" name="phone" value="<?php echo $phone;?>">
            <br>
            <input type="text" name="email" value="<?php echo $email;?>">
            <br>
            <input type="text" name="home" value="<?php echo $home;?>">
            <br>
            <input type="submit" value="更新" name="edit">
        </form>
        <a href = "index.php">アドレス一覧に戻る</a>
    </body>
</html>