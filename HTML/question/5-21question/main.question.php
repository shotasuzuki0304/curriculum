<?php
require_once('db_connect.php');

session_start();

if (empty($_SESSION["user_name"])) {
    header("Location: login.php");
    exit;
}

$pdo = db_connect();

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
        <h1>在庫一覧画面</h1>
        <a href = "newBook.php">新規登録</a>
        <a href = "logout.php">ログアウト</a>
        <table>
            <tr>
                <td>タイトル</td>
                <td>発売日</td>
                <td>在庫数</td>
            </tr>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['stock'] ?></td>
                <td><a href="delete.php?id=<?php echo $row['id']?>">削除</a></td>
            </tr>
        <?php } ?>    
        </table>
    </body>
</html>
