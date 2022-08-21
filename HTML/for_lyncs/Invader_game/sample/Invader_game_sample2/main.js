// 画面サイズ
const SCREEN_W = 180;
const SCREEN_H = 320;

// キャンバスサイズ (画面サイズと同じ比率で作る、アスペクト比を揃える)
const CANVAS_W = SCREEN_W *2;
const CANVAS_H = SCREEN_H *2;

// フィールドサイズ
const FIELD_W = SCREEN_W *2;
const FIELD_H = SCREEN_H *2;

// 星の数をCONSTで定義
const STAR_MAX =300;

// キャンバスの作成
let can = document.getElementById("can");
let con = can.getContext("2d");
can.width = CANVAS_W;
can.height = CANVAS_H;

// ランダムを作る関数
// 最大値と最小値を入れるとその中の乱数を取得する関数
function rand(min,max)
{
    // max-minを引いた値(範囲)だと少ないので+1する
    // そこにminを足せばminからmaxの乱数が得られる
    return Math.floor(Math.random()*(max-min+1))+min;

}

// 星のクラスを作成
class Star
{
    constructor()
    {
        // 星の座標(ランダム)
        // 60fps(秒間60回)だと1だと速すぎるため、少数を使う→ビット(シフト)演算子
        // 今回は8ビットを左にしている
        // 数字を2進数にするとわかりやすい(8なので16進数でも可)
        // 下8ビットは小数点(不動小数点)とする
        // 8ビットなので256→256で1
        this.x = rand(0,FIELD_W)<<8;
        this.y = rand(0,FIELD_H)<<8;

        // 星が動くベクトル(移動距離)
        // 横には動かないので0にする
        // 上から下に流れるようにする
        this.vx = 0;
        this.vy = rand(30,200); 

        // 星のサイズ
        this.sz = rand(1,2)
    }
    // 描画のメソッド
    draw()
    {
        // 単色だとつまらないので、0以外だったら色を暗めの色にして、1,2だったら明るめの色にする
        con.fillStyle=rand(0,2)!=0?"66f":"#8af";
        // 8ビット左にシフトしているので、8ビット戻して書く(書くときは8ビット右にシフトする)
        con.fillRect(this.x>>8,this.y>>8,this.sz,this.sz);
    }

    // アップデートのメソッド
    // 毎フレームごとにどれだけ動くか=毎フレームごとの更新処理を行う
    update()
    {
        // x座標,y座標にベクトル分を足す
        // 毎フレームごとに乱数(30~200)動くことになる
        this.x += this.vx;
        this.y += this.vy;

        // 星は上から下までしか動かないので、フィールドの下まで行ってしまった場合、もう一度上に戻す
        if (this.y>FIELD_H<<8);
        {
            this.y = 0;
            // 同じ場所から星が出てきても微妙なので、改めて乱数でx座標を変える
            this.x = rand(0,FIELD_W)<<8;
        }
    }

}

// 星を作る
// starという変数を配列で作る
let star=[];

// forループで300個星を作成
for(let i=0; i<STAR_MAX;i++)star[i] = new Star();

// このままだと星が見づらいのでブラックで一回画面をクリアする
con.fillStyle="black";

// クリアしてから星を描画する
con.fillRect(0,0,SCREEN_W,SCREEN_H);

// 作った星を全部drawメソッドを呼び出して描画する
for(let i=0; i<STAR_MAX;i++)star[i] = new Star().draw();












/* 作業の手順
①背景の星を描写
fieldがあってscreen(実際のゲーム画面)がある
screenをcanvasにコピーしてcanvasを表示する
fieldとスクリーンは画面には表示されない、canvasにコピーされた時に初めて表示される

②星のクラスを作る

*/

/* 不明点
const
let can = document.getElementById("can");
let con = can.getContext("2d");
*/