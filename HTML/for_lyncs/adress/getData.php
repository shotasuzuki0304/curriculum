<?php
//pdo.phpを一度だけ読み込む
require_once("pdo.php");

//getDataクラスを作成
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

    // ユーザ情報の取得
    public function getUserAdress(){
        $getadress_sql = "SELECT * FROM adress ORDER BY furigana ASC";
        //adressテーブルからレコードを取得する
        $users_adress = $this->pdo->query($getadress_sql);
        //getDataのプロパティpdoにアクセスして、上で定義したsqlを実行して結果を取得する
        return $users_adress;
    }
}