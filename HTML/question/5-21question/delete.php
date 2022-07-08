<?php
require_once('db_connect.php');

session_start();
if (empty($_SESSION['user_name'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

if (empty($id)) {
    header("Location: main.php");
    exit;
}

$pdo = db_connect();

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
