<!-- CSSファイルの読み込み -->
<link rel="stylesheet" href="style_float.css">

<?php
// db_connect.phpの読み込み
require_once('db_connect.php');

// セッション開始
session_start();

// POSTでデータが送られていれば処理実行
if (!empty($_POST)) {
    // 名前が未入力の場合の処理
    if (empty($_POST['name'])) {
        echo '名前が未入力です。';
    }
    // パスワードが未入力の場合の処理
    if (empty($_POST['password'])) {
        echo 'パスワードが未入力です。';
    }

    // 名前とパスワードが送られてきた場合の処理
    if (!empty($_POST['name']) && !empty($_POST['password'])) {
        // 名前とパスワードをエスケープ処理する
        $name = htmlspecialchars($_POST['name'],ENT_QUOTES);
        $password = htmlspecialchars($_POST['password'],ENT_QUOTES);

        // DBに接続する
        $pdo = db_connect();

        // 入力されたものと同じ名前がusersテーブルにあるかDBを検索する
        try {
            $sql = "SELECT * FROM users WHERE name = :name";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':name',$name);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error:' . $e->getMessage();
            die();
        }

        // 結果が取得できたら処理実行
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($password,$row['password'])) {
                // セッションに値を保存する
                $_SESSION["user_name"] = $row['name'];
                $_SESSION["user_password"] = $row['password'];
                // メインページにリダイレクト
                header("Location: main.php");
                exit;
            } else {
                echo "パスワードが間違ってます。";
            }
        } else {
            echo "ユーザー名かパスワードが間違っています。";
        }
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ログイン画面</title>
    </head>
    <body>
        <h1 class="in">ログイン画面</h1>
        <a href="user.php" class="user">新規ユーザー登録</a>
        <form method="post" class="form" action="">
            <input type="text" name="name" placeholder="ユーザー名" class="username">
            <br>
            <input type="password" name="password" placeholder="パスワード" class="password">
            <br>
            <input type="submit" value="ログイン" name="signUp" class="loginbotton">
        </form>
    </body>
</html>