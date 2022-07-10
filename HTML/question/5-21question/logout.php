<!-- CSSファイルの読み込み -->
<link rel="stylesheet" href="style.css">

<?php
// セッション開始
session_start();
// セッション変数のクリア
$_SESSION = array();
// セッションクリア
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>ログアウト</title>
</head>
    <body>
        <h1>ログアウト画面</h1>
        <div>ログアウトしました</div>
        <a href="login.php">ログイン画面に戻る</a>
    </body>    
</html>