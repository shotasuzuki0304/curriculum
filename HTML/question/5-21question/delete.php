<?php
// db_connect.phpの読み込み
require_once('db_connect.php');

// セッション開始
session_start();

// // セッション値がなければ(ログインしていなければ)ログインページに飛ばす
if (empty($_SESSION['user_name'])) {
    header("Location: login.php");
    exit;
}

// メインページから送られてきたidをキャッチ
$id = $_GET['id'];

// idが空だったらメインページにリダイレクトする
if (empty($id)) {
    header("Location: main.php");
    exit;
}

// DBに接続する
$pdo = db_connect();

// 送られてきたidのbooksテーブルのデータを削除する
try {
    $sql = "DELETE FROM books WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    header("Location: main.php");
    exit;
} catch (PDOException $e) {
    echo 'Error:' . $e->getMessage();
    die();
}

?>
