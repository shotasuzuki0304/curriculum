<?php
require_once('db_connect.php');

session_start();

if (!empty($_POST)) {
    if (empty($_POST['name'])) {
        echo '名前が未入力です。';
    }
    if (empty($_POST['password'])) {
        echo 'パスワードが未入力です。';
    }

    if (!empty($_POST['name']) && !empty($_POST['password'])) {
        $name = htmlspecialchars($_POST['name'],ENT_QUOTES);
        $password = htmlspecialchars($_POST['password'],ENT_QUOTES);

        $pdo = db_connect();

        try {
            $sql = "SELECT * FROM users WHERE name = :name";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':name',$name);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error:' . $e->getMessage();
            die();
        }

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($password,$row['password'])) {
                $_SESSION["user_name"] = $row['name'];
                $_SESSION["user_password"] = $row['password'];

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
        <p>ログイン画面  <a href="user.php">新規ユーザー登録</a></p>
        <form method="post" action="">
            <input type="text" name="name" placeholder="ユーザー名">
            <br>
            <input type="password" name="password" placeholder="パスワード">
            <br>
            <input type="submit" value="ログイン" name="signUp">
        </form>
    </body>
</html>