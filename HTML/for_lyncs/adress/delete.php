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

// 送られてきたidのadressテーブルのデータを削除する
try {
    $sql = "DELETE FROM adress WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    header("Location: index.php");
    exit;
} catch (PDOException $e) {
    echo 'Error:' . $e->getMessage();
    die();
}

?>