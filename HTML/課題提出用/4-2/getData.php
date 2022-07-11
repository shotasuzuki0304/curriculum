<?php
require_once("pdo.php");
//pdo.phpを一度だけ読み込む

//getDataクラスを作成している
class getData{
    //public → プロパティ(クラスが持つ変数)
    public $pdo;
    public $data;

    //コンストラクタ → インスタンス化が起きた瞬間に自動的に動くメソッド
    function __construct()  {
        $this->pdo = connect();
        //この(getDataの)プロパティ(pdo)はconnect()である
        //connect()はphp.phpで定義しているデータベースに接続する関数
    }

    /**
     * ユーザ情報の取得
     *
     * @param 
     * @return array $users_data ユーザ情報
     */
    public function getUserData(){
        //メソッド → 関数のこと
        //-> → メソッドチェーン,プロパティやメソッドにアクセスする
        $getusers_sql = "SELECT * FROM users limit 1";
        //PDO::query — プレースホルダを指定せずに、SQL ステートメントを準備して実行する
        //usersテーブルから1件だけレコードを取得する
        $users_data = $this->pdo->query($getusers_sql)->fetch(PDO::FETCH_ASSOC);
        //getDataのプロパティpdoにアクセスして、上で定義したsqlを実行して結果を取得する
        return $users_data;
    }
    
    /**
     * 記事情報の取得
     *
     * @param 
     * @return array $post_data 記事情報
     */
    public function getPostData(){
        $getposts_sql = "SELECT * FROM posts ORDER BY id desc";
        //portsテーブルから全ての要素を降順にソートして取得する
        $post_data = $this->pdo->query($getposts_sql);
        return $post_data;
    }
}