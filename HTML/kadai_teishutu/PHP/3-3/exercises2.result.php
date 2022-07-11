<?php
/*
$uranau = $_GET['uranau'];
?>

<p><?php echo date ("Y/m/d",time()); ?>の運勢は</p>
<p>選ばれた数字は<?php echo mt_rand(0,$uranau); ?></p>
<p></p>

<?php
/*
// 初期案
if ($uranau == 0) {
    echo "凶";
} elseif ($uranau == 1) {
    echo "小吉";
} elseif ($uranau == 2) {
    echo "小吉";
} elseif ($uranau == 3) {
    echo "小吉";
} elseif ($uranau == 4) {
    echo "中吉";
} elseif ($uranau == 5) {
    echo "中吉";
} elseif ($uranau == 6) {
    echo "中吉";
} elseif ($uranau == 7) {
    echo "吉";
} elseif ($uranau == 8) {
    echo "吉";
} else {
    echo "大吉";
}
*/
?>


<?php
/*
// 簡略化① ~以下で表示させる
if ($uranau == 0) {
    echo "凶";
} elseif ($uranau <= 3) {
    echo "小吉";
} elseif ($uranau <= 6) {
    echo "中吉";
} elseif ($uranau <= 8) {
    echo "吉";
} else {
    echo "大吉";
}
*/

/*
〈経過〉
1~3 4~6 7~8という風に指定したい
1桁の数字を入力フォームで入れた後うまく表示されたため、
問題ないかと思いきや画面を更新させると思った通りに出力されなかった
→たまたま受け取った$uranauとmt_rand(0,$uranau)が合致しただけ

〈疑問点〉
if文は上から順番にフィルターにかけられる仕様だったはずではないか？(FizzBuzz問題にて実証)
if文の判定はこの書き方だと$uranauに対して行われている
つまり、生成された乱数mt_rand(0,$uranau)に対して判定をしてない
if文が判定しているものと自分が判定したいもの(生成された乱数mt_rand(0,$uranau))が一致してないのが原因

〈回答〉
実際に入力した値が変数$uranauに代入され、その値をそのままIF文で判定しているため、エラーになります。
※生成された乱数mt_rand(0,$uranau)に対して判定をしてないということ
エラーにならないとしてもすべて大吉になってしまいます。
仮に入力された値が12345678だった場合、
$uranau = 12345678

if文は
if ($uranau(=12345678) == 0) {
echo “凶”;
}
に対して判定を行ってるため、結果はelseに当てはまり大吉になる
*/

?>

<?php
/*
// 簡略化② 論理演算子を使ってみる
if ($uranau == 0) {
    echo "凶";
} elseif ($uranau > 0 && $uranau < 4) {
    echo "小吉";
} elseif ($uranau >= 4 && $uranau <= 6) {
    echo "中吉";
} elseif ($uranau == 7 && $uranau == 8) {
    echo "吉";
} else {
    echo "大吉";
}


/*
〈経過〉
=> <=を入れると構文エラーになる
syntax error, unexpected '<' (訳：構文エラー、予期しない'<')

〈疑問点〉
なぜ=> <=,> < を入れると構文エラーになるのか？

〈回答〉
=>の書き方が間違い
正しくは >=,<= 
=は常に右側に記述する
連想配列の[$key => $value]と書き方が被るからダメと覚える！

*/
?>

<?php
// ②が構文エラーになったため検証
/*
$old = 18;

if ($old > 10 && $old < 30){
    print "変数は10より大きく30より小さい";
}
*/

/*
〈経過〉
この書き方だと問題なく『変数は10より大きく30より小さい』と表示される

〈疑問点〉
なぜ上記の論理演算子を用いた書き方だと構文エラーになるのか？

〈回答〉
=>の書き方が間違い
正しくは >=,<= 
=は常に右側に記述する
連想配列の[$key => $value]と書き方が被るからダメと覚える！
*/
?>

<?php
/*
// 簡略化③比較演算子と論理演算子のハイブリット
if ($uranau == 0) {
    echo "凶";
} elseif ($uranau > 0 && $uranau < 4) {
    echo "小吉";
} elseif ($uranau > 4 && $uranau < 7) {
    echo "中吉";
} elseif ($uranau = 7 || 8) {
    echo "吉";
} else {
    echo "大吉";
}
//書き方に問題はない

*/
?>

<?php
/*
乱数について

〈経過〉
フォームから受け取った数字の羅列から1文字の数字を抜き出すについて
フォームから受け取った数字 → $uranau で定義する
echo mt_rand(0,$uranau) → 0~受け取った数字の中で乱数を表示させる
ここで生成された乱数の中から1つの数字を無作為に抽出したい
調べると出てくるのは、array_rand()
これは配列の中からランダムな要素を抜き出すもの
生成された乱数は『一つの要素』であり、配列ではないため、これは使えない

〈疑問点〉
そもそも別の視点で見る必要があるのか？
1桁の場合、仮に0以外を入力した場合、
例えば5を入力したら0~5の中で抽出されるため、『受け取った数字の羅列から1文字の数字を抜き出す』
には該当しないため、定義の仕方が間違っているのか？

〈回答〉
①まず、入力したものを一文字ずつ配列にする
str_split()
②配列からランダムに一つ取得する
array_rand(配列,個数)

*/
?>



<?php
/*
$uranau = $_GET['uranau'];
?>

<p><?php echo date ("Y/m/d",time()); ?>の運勢は</p>
<p>選ばれた数字は<?php echo $key; ?></p>
<!-- Notice: Undefined variable: key 未定義の変数のなってしまう-->
<p></p>

<?php
$arr = str_split($uranau,1);
//フォームから受け取った$uranauを1文字の配列に変換する

/*
var_dump($arr);
echo '<br>';
/*
出力結果
array(8) 
{ [0]=> string(1) "1" [1]=> string(1) "2" [2]=> string(1) "3" [3]=> string(1) "4" 
[4]=> string(1) "5" [5]=> string(1) "6" [6]=> string(1) "7" [7]=> string(1) "8" } 

フォームから受け取った$uranauを1文字の配列に変換することができたことの確認ができた
*/

/*
$key = array_rand($arr,1);
echo $arr[$key];
echo '<br>';
// 配列内の値を取得


if ($key == 0) {
    echo "凶";
} elseif ($key <= 3) {
    echo "小吉";
} elseif ($key <= 6) {
    echo "中吉";
} elseif ($key <= 8) {
    echo "吉";
} else {
    echo "大吉";
}

/*
出力結果
2022/05/19の運勢は
選ばれた数字は
Notice: Undefined variable: key on line 188 未定義の変数
ランダムな数字
運勢(if文で定義している結果とは一致しない)
*/

/*
〈疑問点〉
なぜ188行目が未定義の変数になってしまうのか？
なぜif文がうまく動かないのか?

〈回答〉
188行目よりも後(下の行)に定義しているから、未定義の変数としてエラーになる
変数や関数を使う場合は、使う前(上の行)で定義する必要がある
if ($key == 0) → $keyはarray_rand($arr,1)で抽出された配列内の位置を表すランダムな数字(0番目など)
つまりif文で判定しているのは、配列内の順番を表す数字であり、要素(値)ではない
自分がif文で判定したいのは、フォームから受け取った$uranauの中のランダムな1文字であり、配列内の番号ではない
配列内の要素(値)は、$arr[$key]なので、<?php echo $key; ?>の部分を<?php echo $arr[$key]; ?>
にする必要がある
*/
?>


<?php
/*
$uranau = $_GET['uranau'];
?>

<p><?php echo date ("Y/m/d",time()); ?>の運勢は</p>
<p>選ばれた数字は<?php echo $arr[$key]; ?></p>
<p></p>

<?php
$arr = str_split($uranau,1);
$key = array_rand($arr,1);
?>

<?php
if ($key == 0) {
    echo "凶";
} elseif ($key <= 3) {
    echo "小吉";
} elseif ($key <= 6) {
    echo "中吉";
} elseif ($key <= 8) {
    echo "吉";
} else {
    echo "大吉";
}

/*
出力結果 
2022/05/19の運勢は
選ばれた数字は
Notice: Undefined variable: arr on line 251 未定義の変数
Notice: Undefined variable: key on line 251 未定義の変数
Notice: Trying to access array offset on value of type null on line 251 
配列オフセットにアクセスしようとしています
運勢
*/

/*
〈疑問点〉
なぜ251行目が未定義の変数になってしまうのか
配列オフセットにアクセスしようとしていますの意味→配列がないよの意味

〈回答〉
251行目よりも後に定義しているから、未定義の変数としてエラーになる
変数や関数を使う場合は、使う前(上の行)で定義する必要がある
未定義の変数と出たら、必ず確認すること
if ($key == 0) → if ($arr[$key] == 0)にすること
*/
?>

<?php

$uranau = $_GET['uranau'];
?>

<?php
$arr = str_split($uranau,1);
$key = array_rand($arr,1);
?>

<p><?php echo date ("Y/m/d",time()); ?>の運勢は</p>
<p>選ばれた数字は<?php echo $arr[$key]; ?></p>
<p></p>


<?php
if ($arr[$key] == 0) {
    echo "凶";
} elseif ($arr[$key] <= 3) {
    echo "小吉";
} elseif ($arr[$key] <= 6) {
    echo "中吉";
} elseif ($arr[$key] <= 8) {
    echo "吉";
} else {
    echo "大吉";
}
?>



<?php
/*
// 選ばれた数字は○○が未定義の変数になるなら、いっそ別の書き方でパターン
$uranau = $_GET['uranau'];
?>

<p><?php echo date ("Y/m/d",time()); ?>の運勢は</p>
<p>選ばれた数字は</p>
<?php
$arr = str_split($uranau,1);
$key = array_rand($arr,1);
echo $arr[$key];
?>
<p></p>

<?php
if ($key == 0) {
    echo "凶";
} elseif ($key <= 3) {
    echo "小吉";
} elseif ($key <= 6) {
    echo "中吉";
} elseif ($key <= 8) {
    echo "吉";
} else {
    echo "大吉";
}

/*
出力結果 
2022/05/19の運勢は
選ばれた数字は
9
凶~大吉
*/

/*
〈疑問点〉
if文で$key == 0の場合、凶を返すように指定しているのになぜ大吉が返ってくるのか

〈回答〉
if文で判定しているのは、$key(配列内の順番を示す番号)であり、
$arr[$key](配列内の要素=値)でないため
自分が判定したいと思っているものと、if文が判定しているものが異なっているのが原因
*/

?>
