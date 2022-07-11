<?php
/*
0から100まで表示するループ文
while、forはどちらを使用していただいてもかまいません。
改行を入れておくと見やすくなります（これは任意です。）
*/
$num = 0; 
while($num < 10) {
    echo $num;
    $num++;
    echo '<br>';
}
?>

<?php
//while文

$num = 0;
while($num <= 100) {
    echo $num;
    $num++;
    echo '<br>';
}
?>

<?php
//do...while文

$num = 0;
do {
    echo $num;
    $num++;
    echo '<br>';
} while($num <=100)
?>

<?php
//for文

for ($num=0;$num<=100;$num++) {
    echo $num;
    echo '<br>';
}
?>
