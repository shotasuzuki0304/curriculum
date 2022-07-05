<?php
try {
            // データベースアクセスの処理文章。ログイン名があるか判定。
            $sql = "SELECT * FROM users WHERE name = :name";
            // プリコンパイルする(SQL文の準備)
            $stmt = $pdo->prepare($sql);
            // プレースホルダに値をバインドする
            $stmt->bindParam(':name',$name);
            // SQLを実行する
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error' . $e->getMessage();
            die();
        }
?>

<?php
try {
    // データベースアクセスの処理文章。ログイン名があるか判定。
    // プリコンパイルする(SQL文の準備)
    $stmt = $pdo->prepare('SELECT * FROM users WHERE name = :name');
    // プレースホルダに値をバインドする
    $stmt->bindParam(':name',$name);
    // SQLを実行する
    $stmt->execute();
} catch (PDOException $e) {
    echo 'Error' . $e->getMessage();
    die();
}
?>

<?php
// db_connect.phpの読み込み
require_once('db_connect.php');

// function.phpの読み込み
require_once('function.php');

// ログインしていなければ、login.phpにリダイレクト
check_user_logged_in();

// URLの?以降で渡されるIDをキャッチ
$id = $_GET['id'];
// もし、$idが空であったらmain.phpにリダイレクト
// 不正なアクセス対策
if (empty($id)) {
    header("Location: main.php");
    exit;
}

// PDOのインスタンスを取得
$pdo = db_connect();

try {
    // SQL文の準備
    $sql = "SELECT * FROM posts WHERE id = :id";
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
    $id = $row['id'];
    $title = $row['title'];
    $content = $row['content'];
} else {
    // 対象のidでレコードがない => 不正な画面遷移
    echo "対象のデータがありません。";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>記事編集</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <h1>記事編集</h1>
        <form method="POST" action="edit_done_post.php">
            <input type="hidden" name="id" value="<?php echo $id; ?>" >
            title:<br>
            <input type="text" name="title" id="title" style="width:200px;height:50px;" value=<?php echo $title; ?>>
            <br>
            content:<br>
            <input type="text" name="content" id="content" style="width:200px;height:100px;" value=<?php echo $content; ?>><br>
            <input type="submit" value="submit" id="edit" name="edit">
        </form>
    </body>
</html>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>メイン</title>
</head>
<body>
    <h1>メインページ</h1>
    <p>ようこそ<?php echo $_SESSION["user_name"]; ?>さん</p>
    <a herf="logout.php">ログアウト</a><br />
    <a href="create_post.php">記事投稿！</a><br />
    <table>
        <tr>
            <td>記事ID</td>
            <td>タイトル</td>
            <td>本文</td>
            <td>投稿日</td>
            <td></td>
            <td></td>
        </tr>
        <?php foreach ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['content']; ?></td>
                <td><?php echo $row['time']; ?></td>
                <td><a herf="edit_post.php?id=<?php echo $row['id']; ?>">編集</a></td>
                <td><a herf="edit_post.php?id=<?php echo $row['id']; ?>">削除</a></td>
            </tr>
        <?php } ?>
    </table>
</body>    
</html>