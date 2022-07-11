<?php
/*
直方体の体積を求める関数を作成してください。
その関数を使用し、縦=5cm、横=10cm、高さ=8cmの直方体の体積を求めてください。
縦vertical 横wide 高さheight
*/

function getRectangular($vertical,$wide,$height) {
    $area = $vertical * $wide * $height;
    print "直方体の体積は".$area."です。";
}

getRectangular(5,10,8);
?>
