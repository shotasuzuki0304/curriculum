<?php
//ファイルが書き込み可能なのか確認
$testFile = "test.kakikomi.txt";
$contents = "こんにちは!";

if(is_writable($testFile)){
    echo "writable!!";
    //書き込み可能な場合の処理
}else{
    echo "not writable!";
    //書き込み不可のときの処理
    exit;
}
echo '<br>';
//出力結果 writable!!
?>

<?php
//書き込みをする
$testFile = "test.kakikomi.txt";
$contents = "こんにちは!";

if (is_writable($testFile)) {
    $fp = fopen($testFile,"w");
    /*
    書き込み可能な場合、対象のファイル$testFileを開く(fopen)
    その後、ファイルを状態を$fpという変数に格納する
    */
    fwrite($fp,$contents);
    //対象のファイル$testFileに$contents = "こんにちは!を書き込む
    fclose($fp);
    //対象のファイル$testFileを閉じる
    echo "finish writing!!";
} else {
    "not writable";
    exit;
}
//出力結果 白紙 → こにんちは!

echo '<br>';

//書き込みモード
//①完全上書き"w"について
$word = "こんばんは!";
if (is_writable("$testFile")) {
    $fp = fopen($testFile,"w");
    fwrite($fp,$word);
    echo "completed!!";
} else {
    "uncompleted";
    exit;
}
/*
出力結果 こんばんは!(こんにちは!が置き換えられた)
解説 fopen($testFile,"w")で"w"を指定したからこうなった
wを指定すると 完全上書き になる → 元々のデータを消して新しく作成する
*/

echo '<br>';

//②追記モード"a"について
$kotoba = "おはよう!";
if (is_writable("$testFile")){
    $fp = fopen($testFile,"a");
    fwrite($fp,$kotoba);
    echo"FINISH NOW!!";
} else {
    echo "NOT FINISH!!";
    exit;
}
/*
出力結果 こんばんは!おはよう!
解説 "a"にすると元の文章に追記される
*/
echo '<br>';
?>

<?php
//ファイルの読み込み
$test_file = "test.yomikomi.txt";

if (is_readable($test_file)) {
    $fp = fopen($test_file, "r");
    while ($line = fgets($fp)) {
        //開いたファイルから1行ずつ読み込む
        //ループ文のwhile(繰り返す回数が決まってない時に使うやつ)
        echo $line.'<br>';
        //改行コード込みで1行ずつ出力
    }
    fclose($fp);
} else {
    echo "not readable!";
    exit;
}
echo '<br>';
?>


