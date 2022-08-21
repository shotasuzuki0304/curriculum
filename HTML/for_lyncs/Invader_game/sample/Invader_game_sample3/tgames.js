var ten;
var c;var ctx;

var img01;
var img02;

var gamestart;
var lastPosx = 150;
var lastPoxy = 200; 


function iniwit(){
ten = document.getElementByld('ten');

c = document.getElementByld('canvas');
ctx = c.getContext('2d');

ctx.fillStyle = 'bluck';
ctx.fillRect(0,0,300,300);

img01 = new Image();
img01.src = "";

img02 = new Image();
img02.src = "";

gamestart = false;
c.addEventListener('mousedown',function(e) {
    gamestart = !gamestart;
    if(gamestart)setTimeout(countUp,100);
});
c.setAttribute('tabindex', 0);
c.addEventListener('keydown',onKeyDown,false);
}

function onKeyDown(e) {
    if(e.key === 'a')lastPosx-=10;
    if(e.key === 's')lastPosx+=10;
    if(e.key === 'w')lastPosy-=10;
    if(e.key === 'z')lastPosy+=10;

    if(lastPosx<0)lastPosx=0;
    if(lastPosy<0)lastPosy=0;

    if(lastPosx>240)lastPosx=240;
    if(lastPosy>240)lastPosy=240;
}

function countUp() {
    ctx.drawImage(img01,lastPosx,lastPosy);
    if(gamestart)setTimeout(countUp,100);
}

// 初期設定
// ページが読み込まれたら呼ばれるやつ
window.onload = iniwit;