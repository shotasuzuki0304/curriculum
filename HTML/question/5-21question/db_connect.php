<?php
// DBに接続するための関数
function db_connect() {
    try {
    $dsn = 'mysql:host=localhost;charset=utf8;dbname=checktest5;';
    // PDOインスタンスの作成
    $pdo = new PDO($dsn,'root','root');
    // エラー処理方法の設定
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
} catch(PDOException $e) {
    echo 'Error:' . $e->getMessage();
    die();
}
}
?>