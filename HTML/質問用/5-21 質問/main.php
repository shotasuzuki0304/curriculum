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

// PDOインスタンスを作成する
$pdo = db_connect();

// booksテーブルのデータを取得する
try {
    $sql = "SELECT * FROM books";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
} catch (PDOException $e) {
    echo 'Error:' . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>メインページ</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <h1 class="zaiko">在庫一覧画面</h1>
        <a href = "newBook.php" class="new">新規登録</a>
        <a href = "logout.php" class="out">ログアウト</a>
        <table border>
            <tr align="center">
                <th width="150">タイトル</th>
                <th width="180">発売日</th>
                <th width="100">在庫数</th>
                <th width="100"></th>
            </tr>
            <!-- PHPで取得したbooksテーブルのデータを取得して表示 -->
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr align="center">
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['stock'] ?></td>
                <!-- 削除ページへのリンク → idをGET通信で渡す -->
                <td><a href="delete.php?id=<?php echo $row['id']?>" class="delete">削除</a></td>
            </tr>
        <?php } ?>    
        </table>
    </body>
</html>
