<?php
/*
FizzBuzz問題
3の倍数のとき、 Fizz! と出力します。
5の倍数のとき、 Buzz! と出力します。
3の倍数かつ5の倍数のとき、 FizzBuzz!! と出力します。(15の倍数、と考えるのはナシです。)
3の倍数でも、5の倍数でもない場合は、その数を出力します。
それを1〜100まで実施してください。
*/

for($i = 1; $i <= 100; $i++){
	if($i % 3 ==0 && $i % 5 ==0){
        echo 'FizzBuzz!';
        echo '<br>';
    }elseif($i % 3 == 0){
        echo 'Fizz';
        echo '<br>';
    }elseif($i % 5 == 0){
        echo 'Buzz';
        echo '<br>';
    }else{
        echo $i;
        echo '<br>';
    }
    
}

?>

