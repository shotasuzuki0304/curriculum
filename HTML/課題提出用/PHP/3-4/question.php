<?php
/*
作業メモ
$port_number = ["80","22","20","21"];
$web_language = ["PHP","Python","JAVA","HTML"];
$My_SQL = ["join","select","insert","update"];

$true_answer = ["80","HTML","select"];

<input type="radio" name="port" value="">
ボタン作成
*/

/*
foreach ($port_number as $value) {
    echo $value;
}
$port_number内の要素を全件出力する
valueの値がname="port"に送信されるから、ここにforeachで全件出力をかけたい
*/
?>

<?php
/*
// ①初期案 PHPとHTMLをガッチャンコ方式で試してみた
$your_name = $_POST["your_name"];
$port_number = ["80","22","20","21"];
$true_answer = ["80","JAVA","update"];
?>

<p>お疲れ様です<?php echo $your_name; ?>さん</p>
<h2>①ネットワークのポート番号は何番？</h2>

<form action="answer.php" method="post" >
<?php
$port_number = ["80","22","20","21"];

foreach ($port_number as $value) { ?>
<input type="radio">
<?php echo $value;?>
<name="port" value=><?php
}
?>

<input type="submit" value="回答する" />

</form>

<!--
・入力フォーム
各要素のボタンは出来るが、選択ボタンにならない
→ただラジオボタンを作っただけ

・送信結果
Notice: Undefined index: port
注意：未定義のインデックス

残念・・・
さんの結果は・・・？
①の答え
②の答え
③の答え
-->

*/
?>

<?php
/*
// ②プルダウン(セレクトボックスだったのでボツ)
$your_name = $_POST["your_name"];
$port_number = ["80","22","20","21"];
$true_answer = ["80"];
?>

<p>お疲れ様です<?php echo $your_name; ?>さん</p>
<form action="answer.php" method="post" >
<h2>①ネットワークのポート番号は何番？</h2>
    <p>
        <select name = "number">
        <?php
        $port_number = ["80","22","20","21"];
        foreach ($port_number as $value) {
            echo 'option value "', $value, '</option>';
        }
        ?>
        </select>
    </p>
        
    <input type = "submit" value="送信">

    <!--
    ・入力フォーム    
    選択肢なしのプルダウン式のボタンができた

    ・送信結果
    Notice: Undefined index : port
    注意：未定義のインデックス

    さんの結果は・・・？
    ①の答え
    ②の答え
    ③の答え
    -->
*/
?>

<?php
/*
// ③送信ボタンのvalue値に連想配列を入れてみた
$your_name = $_POST["your_name"];
$port_number = ["80","22","20","21"];
$true_answer = ["80"];
?>

<p>お疲れ様です<?php echo $your_name; ?>さん</p>
<form action="answer.php" method="post" >
<h2>①ネットワークのポート番号は何番？</h2>

<input type="radio" name="port" value="<?php
foreach ($port_number as $value) {
    echo $value;
} ?>">

<input type="submit" value="回答する" />
</form>

<!--
・入力フォーム
ただのボタン*1のみ
→foreachの中にradioボタンを書かないと繰り返しにならない

・送信結果
残念・・・
さんの結果は・・・？
①の答え
②の答え
③の答え
-->
*/
?>

<?php
/*有力案
//④foreach構文の中に選択ボタンを入れてみた-1
$your_name = $_POST["your_name"];
$port_number = ["80","22","20","21"];
$true_answer = ["80"];
?>


<p>お疲れ様です<?php echo $your_name; ?>さん</p>
<h2>①ネットワークのポート番号は何番？</h2>

<?php
$port_number = ["80","22","20","21"];
?>

<form action="answer.php" method="post" >
<?php
foreach ($port_number as $value) {?>
    <input type="radio" name="port" value="$value"><?php
}
?>

<br>
<input type="submit" value="回答する" />


<button type="submit" name="colors" value="selectcolor">怪盗する</button>
</form>

<!--
・入力フォーム
選択ボタンにボタン名が何も表示されないボタンが4つ出来上がった
→<input type="radio" name="port" value="$value">の後にボタンを記述するラベルを書いてないから

・送信結果
さんの結果は・・・？
①の答え
②の答え
③の答え
-->
*/
?>

<?php
/*
// ⑤foreach構文の中に選択ボタンを入れてみた-2
$your_name = $_POST["your_name"];
$port_number = array("80","22","20","21");
$true_answer = ["80"];
?>

<p>お疲れ様です<?php echo $your_name; ?>さん</p>
<h2>①ネットワークのポート番号は何番？</h2>

<form action="answer.php" method="post" >
    <?php
    foreach( $port_number as $id => $value ){
        echo "<input type=\"radio\" name=\"port_number\" value=\"{$value}\"";
    
    if( $id == 0 ) echo "checked";
    //一番左のラジオボタンを選択中の状態にする
    echo ">";
    //">"を記載しないと入力ウィンドウに80しか表示されない
    echo $value;
    }
    ?>
    <input type = "submit" value="送信">
</form>
<!--
    ・入力フォーム
    フォーム内(80)80,フォーム内(22)22,フォーム内(20)20,フォーム内(21)21 送信ボタン
    →\"で正しく覆えてないから

    ・送信結果
    80入力時
    正解！
    さんの結果は・・・？
    ①の答え
    ②の答え
    ③の答え
    -->
*/
?>

<?php
/*
// ⑥foreach構文の中に選択ボタンを入れてみた-3
$your_name = $_POST["your_name"];
$port_number = array("80","22","20","21");
$true_answer = ["80"];
?>

<p>お疲れ様です<?php echo $your_name; ?>さん</p>
<h2>①ネットワークのポート番号は何番？</h2>

<form action="answer.php" method="post" >
    <?php
    foreach( $port_number as $id => $value ){
        echo "<input type=\"radio\" name=\"port_number\" value=\"{$value}\"";
        echo ">";
        // ">"を入れないとradioボタンが1つしか生成されない→input文の閉じタグなので必須
        echo $value;
        // $valueをechoしないと$port_number内の要素が出力されない
    }
    ?>
    
    <input type = "submit" value="送信">
</form>
*/
?>

<?php
/*
// ⑦→⑥をベースに各項目を設置
$your_name = $_POST["your_name"];
$port_number = array("80","22","20","21");
$true_answer = ["80"];
?>

<p>お疲れ様です<?php echo $your_name; ?>さん</p>
<h2>①ネットワークのポート番号は何番？</h2>

<form action="answer.php" method="post" >
    <?php
    foreach( $port_number as $id => $value ){
        //echo "<input type=\"radio\" name=\"port_number\" value=\"{$value}\">{$value}" ;
    }
    // \"の意味 → PHPの記述の仕方の中にHTMLを埋め込む書き方
    ?>
    
    <input type = "submit" value="送信">
</form>
*/
?>

<?php
/*
// ⑧→⑦の改良型
$your_name = $_POST["your_name"];
$port_number = array("80","22","20","21");
$true_answer = ["80"];
?>

<p>お疲れ様です<?php echo $your_name; ?>さん</p>
<h2>①ネットワークのポート番号は何番？</h2>

<form action="answer.php" method="post" >
    <?php
    foreach( $port_number as $id => $value ){
        echo '<input type="radio" name="port_number" value="'.$value.'">' .$value;
        //.$value;は入力フォームに表示させる名前
    }
    ?>
    
    <input type = "submit" value="送信">
</form>
*/
?>

<?php
/*
// ⑧亜種
$your_name = $_POST["your_name"];
$port_number = array("80","22","20","21");
$true_answer = ["80"];
?>

<p>お疲れ様です<?php echo $your_name; ?>さん</p>
<h2>①ネットワークのポート番号は何番？</h2>

<form action="answer.php" method="post" >
    <?php
    foreach( $port_number as $id => $value ){
        echo '<input type="radio" name="port_number" value="$value">' .$value;
        
        //value="$value"だと$valueが文字列扱いのため、送信先では変数ではなく文字列『$value』
        //として認識される
        
    }
    ?>
    
    <input type = "submit" value="送信">
</form>
*/
?>

<?php
/*
//④の改良型
$your_name = $_POST["your_name"];
$port_number = ["80","22","20","21"];
$web_language = ["PHP","Python","JAVA","HTML"];
$My_SQL = ["join","select","insert","update"];
?>


<p>お疲れ様です<?php echo $your_name; ?>さん</p>

<form action="answer.php" method="post" >

<h2>①ネットワークのポート番号は何番？</h2>
<?php
$port_number = ["80","22","20","21"];
foreach ($port_number as $value) {
    echo '<input type="radio" name="port" value="'.$value.'">' .$value;
}
         // ①'~'で、input~value="までを文字列として囲っている
         // ②'~'で、">を囲ってる
echo '<br>';
*/
?>

<?php
/*
// 〈正解〉PHP内にHTMLを埋め込む書き方
$your_name = $_POST["your_name"];
$port_number = ["80","22","20","21"];
$web_language = ["PHP","Python","JAVA","HTML"];
$My_SQL = ["join","select","insert","update"];
?>

<p>お疲れ様です<?php echo $your_name; ?>さん</p>

<form action="answer.php" method="post" >

<h2>①ネットワークのポート番号は何番？</h2>
<?php
$port_number = ["80","22","20","21"];
foreach ($port_number as $value) {
    echo '<input type="radio" name="port" value="'.$value.'">' .$value;
}

?>

<h2>②Webページを作成するための言語は？</h2>
<?php
foreach ($web_language as $value) {
    echo '<input type="radio" name="language" value="'.$value.'">' .$value;
}
echo '<br>';
?>

<h2>③MySQLで情報を取得するためのコマンドは？</h2>
<?php
foreach ($My_SQL as $value) {
    echo '<input type="radio" name="SQL" value="'.$value.'">' .$value;
}
echo '<br>';
?>

<input type="hidden" name="your_name" value="<?php echo $your_name; ?>"/>
<!--
hiddenを使用しindex.htmlから送られてきたyour_nameを表示させることなく、answer.phpに送っている
-->
<input type="submit" value="回答する" /><br>
</form>
*/
?>

<?php
/*
// 〈正解〉PHP内にHTMLを埋め込む書き方②
$your_name = $_POST["your_name"];
$port_number = ["80","22","20","21"];
$web_language = ["PHP","Python","JAVA","HTML"];
$My_SQL = ["join","select","insert","update"];
?>

<p>お疲れ様です<?php echo $your_name; ?>さん</p>

<form action="answer.php" method="post" >

<h2>①ネットワークのポート番号は何番？</h2>
<?php
foreach ($port_number as $value) {
    echo "<input type=\"radio\" name=\"port\" value=\"$value\"> $value" ;
}

?>

<h2>②Webページを作成するための言語は？</h2>
<?php
foreach ($web_language as $value) {
    echo "<input type=\"radio\" name=\"language\" value=\"$value\"> $value" ;
}
echo '<br>';
?>

<h2>③MySQLで情報を取得するためのコマンドは？</h2>
<?php
foreach ($My_SQL as $value) {
    echo "<input type=\"radio\" name=\"SQL\" value=\"$value\"> $value" ;
}
echo '<br>';
?>

<input type="hidden" name="your_name" value="<?php echo $your_name; ?>"/>
<input type="submit" value="回答する" /><br>
</form>
*/
?>

<link rel="stylesheet" href="./CSS/3-4.css">
<?php

// 〈正解〉HTML内にPHPを埋め込む書き方
$your_name = $_POST["your_name"];
$port_number = ["80","22","20","21"];
$web_language = ["PHP","Python","JAVA","HTML"];
$My_SQL = ["join","select","insert","update"];
?>

<p>お疲れ様です<?php echo $your_name; ?>さん</p>

<form action="answer.php" method="post" >

<h2>①ネットワークのポート番号は何番？</h2>
<?php
foreach ($port_number as $value) {?>
    <input type="radio" name="port" value="<?php echo $value ?>"><?php echo $value ?><?php
    }
    ?>
<br>

<h2>②Webページを作成するための言語は？</h2>
<?php
foreach ($web_language as $value) {?>
    <input type="radio" name="language" value="<?php echo $value ?>"><?php echo $value ?><?php
    }
    ?>
<br>

<h2>③MySQLで情報を取得するためのコマンドは？</h2>
<?php
foreach ($My_SQL as $value) {?>
    <input type="radio" name="SQL" value="<?php echo $value ?>"><?php echo $value ?><?php
    }
    ?>
<br>

<input type="hidden" name="your_name" value="<?php echo $your_name; ?>"/>
<input type="submit" value="回答する" /><br>
</form>