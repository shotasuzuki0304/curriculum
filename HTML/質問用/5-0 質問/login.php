<?php
require_once('db_connect.php');
// セッション開始
session_start();

// $_POSTが空でない場合
// つまりログインボタンが押された場合のみ、下記の処理を実行する
if (!empty($_POST)) {
    // ログイン名が入力されていない場合の処理
    if (empty($_POST["name"])) {
        echo "名前が未入力です。";
    }
    // パスワードが入力されていない場合の処理 
    if (empty($_POST["pass"])) {
        echo "パスワードが未入力です。";
    }

    // 両方入力されている場合
    if (!empty($_POST["name"]) && !empty($_POST["pass"])) {
        // ログイン名とパスワードのエスケープ処理
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES);
        $pass = htmlspecialchars($_POST['pass'], ENT_QUOTES);
        // ログイン処理開始
        $pdo = db_connect();
        try {
            // データベースアクセスの処理文章。入力された名前と同じログイン名がDBにあるか判定。
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
        // 結果が1行取得できたらそれを$rowという変数に入れる
        // $row → fetch(PDO::FETCH_ASSOC)によって連想配列形式で取り出してきたレコード(id,name,password,time(これらが$keyとなる))を代入している
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // ハッシュ化されたパスワードを判定する定型関数のpassword_verify
            // 入力された値とDBから引っ張ってきた値が同じか判定している
            if (password_verify($pass, $row['password'])) {
                // セッションに値を保存 ※保存の仕方 → $_SESSION['キー'] = 値
                // セッション情報の取得の仕方 → 変数 = $_SESSION['キー']
                // $row['id']; → 連想配列の$value値を出力する書き方
                $_SESSION["user_id"] = $row['id'];
                $_SESSION["user_name"] = $row['name'];
                // main.phpにリダイレクト(移動)
                header("Location: main.php");
                exit;
            } else {
                // パスワードが間違っていた時の処理
                echo "パスワードに誤りがあります。";
            }
        } else {
            // ログイン名がなかった時の処理
            echo "ユーザー名かパスワードに誤りがあります。";
        }    
    }
    }

?>

<!doctype html>
<html lang="ja">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ログインページ</title>
    </head>
    <body>
        <h2>ログイン画面</h2>
        <form method="post" action"">
            名前：<input type="text" name="name" size="15"><br><br>
            パスワード：<input type="text" name="pass" size="15"><br><br>
            <input type="submit" value="ログイン">
        </form>
    </body>
</html>

