<?php
//ceil（切り上げ）
$x = 4.3;
echo ceil($x);
echo '<br>';
//出力結果5
?>

<?php
//floor（切り捨て）
$x = 4.9;
echo floor($x);
echo '<br>';
//出力結果4
?>

<?php
//round（四捨五入）
$x = 4.6;
$y = 4.4;
echo round($x);
echo '<br>';
//出力結果5

echo round($y);
echo '<br>';
//出力結果4
?>

<?php
echo pi();
echo '<br>';
//出力結果 3.1415926535898

function circleArea($r) {
    $circle_area = $r * $r * pi();
    return $circle_area;
}
echo circleArea(5);
echo '<br>';
//出力結果 78.539816339745
?>

<?php
//mt_rand（乱数）
echo mt_rand(5,10);
echo '<br>';
//出力結果 ランダムな5~10の数
?>

<?php
echo mt_getrandmax();
//mt_getrandmax (乱数値の最大値を表示)
echo '<br>';
//出力結果 2147483647
?>

<?php
//strlen（文字列の長さ）
$str = "iiiiiiiiiiiiiiiiiiii";
echo strlen($str);
echo '<br>';
//出力結果 20
?>

<?php
//strpos（検索＝ある文字が何番目か)
$str = "suzuki";
echo strpos($str,"k");
echo '<br>';
//出力結果 4(0,1,2,3,4と数えるから)

echo strpos($str,"s");
echo '<br>';
//出力結果 0
?>

<?php
//substr（文字列の切り取り）
$str = "suzuki";
echo substr($str,0,5);
echo '<br>';
//出力結果 suzuk(0~5番目の文字が切り取られる)

echo substr($str,0,2);
echo '<br>';
//出力結果 su(0~2番目の文字が切り取られる)

echo substr($str,2,4);
echo '<br>';
//出力結果 zuki(2~4番目の文字が切り取られる)

echo substr($str,-3,1);
echo '<br>';
//出力結果 u (3番目から1文字が切り取られる)
?>

<?php
//str_replace（置換）
$str = "suzuki";
echo str_replace("suzu","KASHIWA",$str);
echo '<br>';
//出力結果 KASHIWAki
?>

<?php
//str_replace（空白を空文字で置き換えて削除）
$str = "I a m s u z u k i";
echo str_replace(" ","",$str);
echo '<br>';
//出力結果 Iamsuzuki
?>

<?php
//マルチバイト文字列
$str = "すずき";
echo strlen($str);
echo '<br>';
//出力結果 9(3*3=9)

//mb_strlen(マルチバイト対応)
$str = "すずき";
echo mb_strlen($str);
echo '<br>';
//出力結果 3
?>

<?php
echo "hello";
echo '<br>';
?>

<?php
//printf（フォーマット化した文字列を出力）
$name = "鈴木さん";
$limit_time = 60;

printf("%sが来日するまであと%d日です",$name,$limit_time);
echo '<br>';
//出力結果 鈴木さんが来日するまであと60日です


$name = "鈴木";
$limit_mounth = 2;
$limit_day = 10;
$country = "日本";
$code = "プログラマー";

printf("%sが%sで%sになるまでに残された時間は%02dヶ月と%03d日しかない!!",$name,$country,$code,$limit_mounth,$limit_day);
echo '<br>';
//出力結果 鈴木が日本でプログラマーになるまでに残された時間は02ヶ月と010日しかない!!
?>

<?php
//sprintf（変数に代入できるprintf)
$limit_mounth = 3;
$limit_day = 4;
$litimit_time = 5;
$limit = sprintf("%02dヶ月%02d日%02d時間",$limit_mounth,$limit_day,$litimit_time);
echo $limit;
echo '<br>';
//出力結果 03ヶ月04日05時間

echo "鈴木に残された勉強時間はあと".$limit."しかない!!";
echo '<br>';
//出力結果 鈴木に残された勉強時間はあと03ヶ月04日05時間しかない!!

?>
