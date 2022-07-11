<?php
/*
〈問題〉
りんご、みかん、桃のフルーツの単価と個数をもとに料金を計算します

step1:フルーツと単価の連想配列を作成してください。
配列の0:リンゴ、1:みかん、2:桃の順に個数を配列で作成してください。

step2:単価を計算する関数を定義してください。
引数はフルーツの単価・個数の２つ、返り値は計算した合計値を返します。

step3:繰り返しを使ってそれぞれのフルーツを書き出してください。 → foreach構文

〈出力結果〉
りんごは300円です。
みかんは150円です。
ももは3000円です。
*/

/*
〈ボツ案①〉
$fruits = ["apple" => "りんご","orange" => "みかん","peach" =>"桃"];
//フルーツを定義

$price = ["りんご" => "100","みかん" => "50","桃" =>"300"];
//フルーツの価格を定義

$num = 1;
while($num <= 10){
    $num;
    $num ++;
}
//1~10までの数を定義

function fruitsprice($price,$num){
    $result = $price * $num;
    print = "$fruitsは".result."です。";
}
//フルーツの値段を求める関数
//構文エラーになってしまう→$fruitsが関数外で定義した変数のため、関数内に持ってきたときにローカル化
//してしまうため

?>
*/

/*
〈ボツ案②〉
function fruitsprice($price,$num){
    global $key;
    $result = $price * $num ;
    print $key . "は" . $result . "円です。";
}

$fruits = ["りんご" => 100,"みかん" => 50,"桃" =>300];

foreach ($fruits as $key => $value){
    if ($key == "りんご"){
        fruitsprice(100,3);
        echo '<br>';
    }elseif($key =="みかん"){
        fruitsprice(50,3);
        echo '<br>';
    }else{
        fruitsprice(300,10);
        echo '<br>';
    }
}

//$keyが出力されない→グルーバル化で解決→グローバル化しなくてもいける


〈ヒント〉
function fruitsprice($price,$num){
    $result = $price * $num;
    print = "$fruitsは".result."です。";
}
echo $key . "は" . $result . "円です。";

foreach ($fruits as $key => $value){
    if ($key == "りんご"){
        echo $key."は".fruitsprice(100,3)."円です。"."<br>";
    }elseif ($key == "みかん"){

ローカル変数をもう一度復習する
最初に個数、物に対する値段を定義→これらを使ってif文、関数の計算する
出力はreturn

echo $key,"は",fruitsPrice($value,$fruitsNum[0]),"円です。","<br>";←一列でおk


if文の中(関数の外)で関数の結果を使いたい場合は、return $resultを使用する
※printだとできない
書いて検証する
関数内に固定した数字は使わない方が多い
→$result = 関数名($value,$num[0]);
→$num = [3,3,10];

変数の定義
未定義の変数
場所、上の方
print その場で表示させる
return 必要な時に表示させる
$priceと$numは関数内で使用する変数(ここに外から変数を持ってくることはできない)


関数はどういう計算をするかを書くだけ
連想配列を持ってくるとエラーになる為、if文で分岐させて3パターン書く
詳細は変数展開参照

〈考え方〉
連想配列→フルーツで作る
普通の配列→個数で作る
関数を定義→個数、金額
そのままreturnをかける（計算式ごと）
if文の中でecho（関数を呼び出す）
引数(値段、個数)
(for文でも定義可能だが、今回は個数が少ないので使用しないでOK)
resultに代入しない

*/

/*
//ほぼ答え
$fruits = ["りんご" => 100,"みかん" => 50,"桃" =>300];

$num = [3,3,10];

function fruitsprice($price,$lot){
    $result = $price * $lot;
    return $result;
}
//関数をシンプルに『値段だけを求めるもの』にしたため、わざわざグローバル化しなくてもOKになった

foreach ($fruits as $key => $value){
    if ($key == "りんご"){
        $result = fruitsprice($value,$num[0]);
        //連想配列にしているため、自動で$key == "りんご"の場合、それに該当する$value == "100" が呼び出される
    }elseif($key == "みかん"){
        $result = fruitsprice($value,$num[1]);
    }else{
        $result = fruitsprice($value,$num[2]);
    }
    echo $result.'<br>';
    //同じ変数は上書きされる
   // 〈出力結果〉
   // 300
   // 150
   // 3000
}

/*
〈疑問〉
$resultはfunction fruitprice内で定義した変数(ローカル変数)なのに、なぜ関数の外で使用できるのか？
変数のスコープ(関数の外では関数内の値の変更は無視される)に該当しないのか
*/
?>


<?php

$kudamono = ["りんご" => 100,"みかん" => 50,"桃" =>300];

$kazu = [3,3,10];

function kudamononedann($price,$lot){
    $result = $price * $lot;
    return $result;
}

foreach ($kudamono as $key => $value){
    if ($key == "りんご"){
        $total = kudamononedann($value,$kazu[0]);
        //関数での計算結果を変数として定義することができる
    }elseif($key == "みかん"){
        $total = kudamononedann($value,$kazu[1]);
    }else{
        $total= kudamononedann($value,$kazu[2]);
    }
    echo $key."は".$total."円です。".'<br>';
    //関数と文字配列を共存させる書き方で表す
    //この書き方は先に計算をしてその後一気にまとめて出力するやり方
}

?>

<?php
$kajitu = ["りんご" => 100,"みかん" => 50,"桃" => 300];

$suuryou = [3,3,10];

function kajituprice($price,$lot){
    $result = $price * $lot;
    return $result;
}

foreach ($kajitu as $kagi => $fvalue){
    if ($kagi == "りんご"){
        echo $kagi."は".kajituprice($fvalue,$suuryou[0])."円です。";
        echo '<br>';
    }elseif($kagi == "みかん"){
        echo $kagi."は".kajituprice($fvalue,$suuryou[1])."円です。";
        echo '<br>';
    }else{
        echo $kagi."は".kajituprice($fvalue,$suuryou[2])."円です。";
        echo '<br>';
    }
}
?>