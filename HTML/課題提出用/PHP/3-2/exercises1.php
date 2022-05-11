<?php
/*
りんご、みかん、桃のフルーツの単価と個数をもとに料金を計算します

step1:フルーツと単価の連想配列を作成してください。
配列の0:リンゴ、1:みかん、2:桃の順に個数を配列で作成してください。

step2:単価を計算する関数を定義してください。
引数はフルーツの単価・個数の２つ、返り値は計算した合計値を返します。

step3:繰り返しを使ってそれぞれのフルーツを書き出してください。 → foreach構文

出力結果
りんごは300円です。
みかんは150円です。
ももは3000円です。


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
/*
function fruitsprice($price,$num){
    $result = $price * $num;
    print = "$fruitsは".result."です。";
}
//フルーツの値段を求める関数
//構文エラーになってしまう

?>
*/

/*
関数はどういう計算をするかを書くだけ
連想配列を持ってくるとエラーになる為、if文で分岐させて3パターン書く
詳細は変数展開参照
*/

/*
print その場で表示させる
return 必要な時に表示させる
$priceと$numは関数内で使用する変数(ここに外から変数を持ってくることはできない)
function fruitsprice($price,$num){
    $result = $price * $num;
    print = "$fruitsは".result."です。";
}
echo $key . "は" . $result . "円です。";
*/



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

//$keyが出力されない

?>