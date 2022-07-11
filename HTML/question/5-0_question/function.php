<?php

function check_user_logged_in() {
    // セッション開始
    session_start();
    // セッションにuser_nameの値がなければlogin.phpにリダイレクト
    if (empty($_SESSION["user_name"])) {
    header("Location: login.php");
    exit;
    }
}

// もし、$idが空であったらmain.phpにリダイレクト
// 不正なアクセス対策
// 「$param」を指定することで、「$id」だけでなく他の要素で使用しても違和感なく使用することが出来る
function redirect_main_unless_parameter($param) {
    if (empty($param)) {
        header("Location: main.php");
        exit;
    }
}

// 記事を編集するために、編集したい記事の情報を取得する
function find_post_by_id($id) {
    // PDOのインスタンスを生成
    $pdo = db_connect();
    try {
    // SQL文の準備
    $sql = "SELECT * FROM posts WHERE id = :id";
    // プリペアドステートメントの作成
    $stmt = $pdo->prepare($sql);
    // idのバインド
    $stmt->bindParam(':id', $id);
    // 実行
    $stmt->execute();
} catch (PDOException $e) {
    // エラーメッセージの出力
    echo 'Error' . $e->getMessage();
    // 終了
    die();
}
// 結果が1件取得できたら
if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // DBから取得したid,title,contentを変数に格納する
    return $row;
} else {
    // もし、$rowが空であったらmain.phpにリダイレクト
    redirect_main_unless_parameter($row);
}
}
?>
