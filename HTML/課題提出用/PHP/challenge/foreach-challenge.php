<?php
//先ほどの果物の連想配列をforeachで下記のように出力するプログラムを組んでください。

//答え1
$fruits = ["apple" => "といったらりんご","orange" => "といったらみかん","peach" =>"といったらもも"];

foreach ($fruits as $key => $value){
    echo $key;
    echo $value;
    echo '<br>';
}

?>

<?php
//答え2
$fruits = ["apple" => "りんご","orange" => "みかん","peach" => "もも"];

foreach ($fruits as $key => $value){
    echo $key;
    echo 'といったら';
    echo $value;
    echo '<br>';
}
?>

