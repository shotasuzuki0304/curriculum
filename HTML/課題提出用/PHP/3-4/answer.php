<?php
$your_name = $_POST["your_name"];
$port = $_POST['port'];
$language = $_POST['language'];
$SQL = $_POST['SQL'];
//[question.php]から送られてきた名前の変数
//ここで送られてきた値(選択肢)を受け取っている

$true_answer = ["80","HTML","select"];
//問題の答えの変数を作成

/*
echo $_POST['port'];
echo '<br>';
echo $_POST['language'];
echo '<br>';
echo $_POST['SQL'];
echo '<br>';
echo $port;
echo '<br>';
echo $language;
echo '<br>';
echo $SQL;
echo '<br>';
//選択した回答の変数
// 出力結果は全て$valueだった
// ボタンが正しく機能していない？
*/


//選択した回答と正解が一致していれば「正解！」、一致していなければ「残念・・・」と出力される処理を組んだ関数を作成する
//関数で一個の処理にまとめる
//関数内にif文を入れることはできる＝この中で判定してあげる
function answer($your_answer,$answer) {
    if ( $your_answer == $answer ) {
        echo '正解！';
    } else {
        echo '残念・・・';
    }
}
?>

<p><?php echo $your_name ?>さんの結果は・・・？</p>
<p>①の答え</p>
<?php
answer($port,$true_answer[0]);
echo '<br>';
?>

<p>②の答え</p>
<?php
answer($language,$true_answer[1]);
echo '<br>';

?>

<p>③の答え</p>
<?php
answer($SQL,$true_answer[2]);
echo '<br>';
?>




