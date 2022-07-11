<?php
//count（要素の数を数える）
$members = ["suzuki","tukamoto","araki","kaminuma","oowada"];
echo count($members);
echo '<br>';
//出力結果 5
?>

<?php
//sort（要素の並べ替え）
$members = ["suzuki","tukamoto","araki","kaminuma","oowada"];
sort($members);
var_dump($members);
echo '<br>';
/*
出力結果
array(5) 
{ [0]=> string(5) "araki" [1]=> string(8) "kaminuma" [2]=> string(6) 
"oowada" [3]=> string(6) "suzuki" [4]=> string(8) "tukamoto" }
*/

$numbers = [1,9,7,5,2,6,3,77,22,500];
sort($numbers);
var_dump($numbers);
echo '<br>';

/*
出力結果
array(10) 
{ [0]=> int(1) [1]=> int(2) [2]=> int(3) [3]=> int(5) [4]=> int(6) 
[5]=> int(7) [6]=> int(9) [7]=> int(22) [8]=> int(77) [9]=> int(500) }
*/
?>

<?php
//in_array（配列に中にある要素が存在しているか）
$members = ["suzuki","tukamoto","araki","kaminuma","oowada"];
var_dump(in_array("suzuki",$members));
echo '<br>';
//出力結果 bool(true)

var_dump(in_array("ikeda",$members));
echo '<br>';
//出力結果 bool(false)
?>

<?php
//implode（配列を結合して文字列に変換）
$members = ["suzuki","tukamoto","araki","kaminuma","oowada"];
$gattai = implode("☆",$members);
var_dump($gattai);
echo '<br>';
//出力結果 string(45) "suzuki☆tukamoto☆araki☆kaminuma☆oowada"
?>

<?php
//explode（文字列を指定の区切りで配列にする）
$num = 123456;
echo $num;
echo '<br>';
//出力結果 123456

$number = explode("☆",$num);
echo $num;
echo '<br>';
//出力結果 123456 → "123456"は一つの文字列なのでexplode出来ない

$num = "123 456 789";
$nums = explode(" ",$num);
var_dump($nums);
echo '<br>';
//出力結果 array(3) { [0]=> string(3) "123" [1]=> string(3) "456" [2]=> string(3) "789" }

$numnum = "123 456 789";
$numnums = explode("@",$numnum);
var_dump($numnums);
echo '<br>';
//出力結果 array(1) { [0]=> string(11) "123 456 789" }
//各要素の間が@で区切られている訳ではないのでこのような結果になった

$re_number = "987@654@321";
$array = explode("@",$re_number);
var_dump($array);
echo '<br>';
//出力結果 array(3) { [0]=> string(3) "987" [1]=> string(3) "654" [2]=> string(3) "321" }
//区切りにしたい場所を統一する必要がある(今回区切りにしたかったのは@)
?>

