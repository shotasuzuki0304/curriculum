"use strict"
/*
<img id="player" src="img/jiki.png">
<img id="enemy" src="img/mido.png">
<img id="player_bullet" src="img/baku.png">
<img id="enemy_bullet" src="img/nani.png">
*/
// 全体で使用する変数を定義
var canvas;
var ctx;
// FPS管理に使用するパラメータを定義
var FPS = 30;
var MSPF = 1000 / FPS; // 33.3

// 背景の動く星
let hoshi;
let tamas;
let count;
let bakut;

// プレイヤーの画像を保持する変数を定義
var img_player;
// プレイヤーの弾画像を保持する変数を定義
var img_player_bullet;
// 敵キャラの画像を保持する変数を定義
var img_enemy;

// プレイヤーの現在位置を保持する変数を定義
var player_x; // プレイヤーのx座標
var player_y; // プレイヤーのy座標

// 弾の数を定義（同時に描画される弾の最大数より大きい必要あり）
var BULLETS = 5;
// BULLETS分だけ要素数を持つ配列を代入
var player_bullets_x = new Array(BULLETS);
var player_bullets_y = new Array(BULLETS);
// 発射インターバルの値を定義（この値が大きいほど連射が遅くなる）
var FIRE_INTERVAL = 20;

// プレイヤーの発射インターバル
var player_fire_interval = 0;

// 敵キャラの数を定義
var ENEMIES = 10;
// 敵キャラの現在位置（配列）を保持する変数を定義し、ENEMIES分だけ要素数を持つ配列を代入
var enemies_x = new Array(ENEMIES);
var enemies_y = new Array(ENEMIES);

// プレイヤーのHP
var player_hp;
// 敵キャラのヒットポイント（配列）を保持する変数を定義し、ENEMIES分だけ要素数を持つ配列を代入
var enemies_hp = new Array(ENEMIES);
// 弾のヒットポイント（配列）を保持する変数を定義し、BULLETS分だけ要素数を持つ配列を代入
var player_bullets_hp = new Array(BULLETS);

// 倒した敵の数を保存する変数を定義
var killed = 0;

// キー状態管理変数の定義
var KEYS = new Array(256);
// キーの状態を false （押されていない）で初期化
for(var i=0; i<KEYS.length; i++) {
    KEYS[i] = false;
}

// 再描画する関数（無引数、無戻り値）
var redraw = function() {
    // キャンバスをクリアする
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // 生きている場合のみ、新しい位置にプレイヤーを描画
    if(player_hp > 0) {
        ctx.drawImage(img_player, player_x, player_y);
    }

    // 弾の画像を (bullets_x[i], bullets_y[i]) の位置に表示
    for(var i=0; i<BULLETS; i++) {
        // 生きている場合のみ描画
        if(player_bullets_hp[i] > 0) {
            ctx.drawImage(img_player_bullet,player_bullets_x[i],player_bullets_y[i]);
        }
    }

    // 敵キャラの画像を (enemies_x[i], enemies_y[i]) の位置に表示
    for(var i=0; i<ENEMIES; i++) {
        // 生きている場合のみ描画
        if(enemies_hp[i] > 0) {
            ctx.drawImage(img_enemy, enemies_x[i], enemies_y[i]);
        }
    }

    // コンテキストの状態を保存（fillStyleを変えたりするので）
    ctx.save();
    // HPの最大値（10）x 5 の短形を描画（白）
    ctx.fillStyle = "#fff";
    ctx.fillRect(10, canvas.height-10, 10*5, 5);
    // 残りHP x 5 の短形を描画（赤）
    ctx.fillStyle = "#f00";
    ctx.fillRect(10, canvas.height-10, player_hp*5, 5);

    // 「倒した敵の数/全敵の数」という文字列を作成
    var text = "Killed: " + killed + "/" + ENEMIES;
    // 文字列の（描画）横幅を計算する
    var width = ctx.measureText(text).width;
    // 文字列を描画（白）
    ctx.fillStyle = "#fff";
    ctx.fillText(text, canvas.width - 10 - width, canvas.height - 10);

    // プレイヤーが死んでいた場合ゲームオーバー画面を表示する
    if(player_hp <= 0) {
        // 真ん中に大きな文字でゲームオーバー（赤）と表示する
        ctx.font = "20px sans-serif";
        ctx.textBaseline = "middle"; // 上下位置のベースラインを中心に
        ctx.fillStyle = "#f00";
        text = "Game Over";
        width = ctx.measureText(text).width;
        ctx.fillText(text, (canvas.width - width)/2, canvas.height/2);
    } else if(killed == ENEMIES) {
        // 真ん中に大きな文字でゲームクリア（白）と表示する
        ctx.font = "20px sans-serif";
        ctx.textBaseline = "middle"; // 上下位置のベースラインを中心に
        ctx.fillStyle = "#fff";
        text = "Game Cear";
        width = ctx.measureText(text).width;
        ctx.fillText(text, (canvas.width - width)/2, canvas.height/2);
    }

    // コンテキストの状態を復元
    ctx.restore();
};

// プレイヤーの移動処理を定義
var movePlayer = function() {
    // ヒットポイントを確認し、生きている場合のみ処理をする
    if(player_hp <= 0) {
        return;
    }
    // 移動速度を定義
    var SPEED = 2;
    // キー番号だとわかりにくいため予め変数に格納
    var RIGHT = 39;
    var LEFT = 37;
    var SPACE = 32;

    if(KEYS[RIGHT] && player_x + img_player.width < canvas.width) {
        // プレイヤーのx座標を少し増やす
        player_x += SPEED;
    }
    if(KEYS[LEFT] && player_x > 0) {
        // プレイヤーのx座標を少し減らす
        player_x -= SPEED;
    }
    // プレイヤーがはみ出てしまった場合は強制的に中に戻す
    if(player_x < 0) {
        player_x = 0;
    } else if (player_x + img_player.width > canvas.width) {
        player_x = canvas.width - img_player.width;
    }

    // スペースキーが押され、なおかつ発射インターバルが0の時だけ発射する
    if(KEYS[SPACE] && player_fire_interval == 0) {
        // 未使用の弾があれば発射する
        for(var i=0; i<BULLETS; i++) {
            if(player_bullets_hp[i] == 0) {
                // 弾の初期位置はプレイヤーと同じ位置にする
                player_bullets_x[i] = player_x;
                player_bullets_y[i] = player_y;
                // 弾のHPを1にすることで、次のループから描画や移動処理が行われるようにする
                player_bullets_hp[i] = 1;
                // 弾を打ったので発射インターバルの値を上げる
                player_fire_interval = FIRE_INTERVAL;
                // 弾を打ったのでループを抜ける
                break;
            }
        }
    }

    // 発射インターバルの値が0より大きい場合は値を減らす
    if(player_fire_interval > 0) {
        player_fire_interval -= 1;
    }
};

// プレイヤーの弾の移動処理を定義
var movePlayerBullets = function() {
    var SPEED = -6;

    // 各弾ごとに処理を行う
    for(var i=0; i<BULLETS; i++) {
        // ヒットポイントを確認し、生きている場合のみ処理をする
        if(player_bullets_hp[i] <= 0) {
            // ループの残りのステップを無視して次のループに行く場合は`continue` を指定する
            continue;
        }

        // 弾のy座標を少し減らす(上方向に移動)
        player_bullets_y[i] += SPEED;

        // 弾が上画面にはみ出た場合はHPを0にして未使用状態に戻す
        if(player_bullets_y[i] <img_player_bullet.height) {
            player_bullets_hp[i] = 0;
        }
    }
};

// 敵キャラの移動処理を定義
var moveEnemies = function() {
        // 移動速度を定義
        var SPEED = 2;
        // 各敵キャラごとに処理を行う
        for(var i=0; i<ENEMIES; i++) {
            // ヒットポイントを確認し、生きている場合のみ処理をする
            if(enemies_hp[i] <= 0) {
                // ループの残りのステップを無視して次のループに行く場合は`continue` を指定する
                continue;
            }

        // 敵キャラのy座標を少し増やす
        enemies_y[i] += SPEED;

        // 敵キャラが下画面にはみ出た場合は上に戻す
        if(enemies_y[i] > canvas.height) {
            enemies_y[i] = -img_enemy.height;
            // x座標を再度ランダムに設定
            enemies_x[i] = Math.random() * (canvas.width - img_enemy.width);
        }
    }
};

// 汎用的当たり判定関数
var hitCheck = function(x1, y1, obj1, x2, y2, obj2) {
    var cx1, cy1, cx2, cy2, r1, r2, d;
    // 中心座標の取得
    cx1 = x1 + obj1.width/2;
    cy1 = y1 + obj2.height/2;
    cx2 = x2 + obj2.width/2;
    cy2 = y2 + obj2.height/2;
    // 半径の計算
    r1 = (obj1.width + obj1.height)/4;
    r2 = (obj2.width + obj2.height)/4;
    // 中心座標同士の距離の測定
    // Math.sqrt(d) -- dのルートを返す
    // Math.pow(x, a) -- xのa乗を返す
    d = Math.sqrt(Math.pow(cx1-cx2, 2) + Math.pow(cy1-cy2, 2));
    // 当たっているか判定
    if(r1 + r2 > d) {
        // 当たってる
        return true;
    } else {
        // 当たってない
        return false;
    }
};

// メインループを定義
var mainloop = function() {
    // 処理開始時間を保存
    var startTime = new Date();

    // プレイヤーの移動処理
    movePlayer();
    // プレイヤーの弾の移動処理
    movePlayerBullets();
    // 敵キャラの移動処理
    moveEnemies();

    // プレイヤーと敵キャラの当たり判定(プレイヤーが生きている場合)
    if(player_hp > 0) {
        for(var i=0; i<ENEMIES; i++) {
            // 敵が生きている間のみ判定する
            if(enemies_hp[i] > 0) {
                if(hitCheck(player_x, player_y, img_player, enemies_x[i], enemies_y[i], img_enemy)){
                    // 当たっているのでお互いのHPを1削る
                    player_hp -=1;
                    enemies_hp[i] -=1;
                    // 敵を撃破した場合はkilledを増やす
                    if(enemies_hp[i] == 0) {
                        killed++;
                    }
                }
            }
        }
    }

    // プレイヤー弾と敵キャラの当たり判定（プレイヤーが生きている場合）
    if(player_hp > 0) {
        for(var i=0; i<ENEMIES; i++) {
            // 敵が死んでいる場合はスルーする
            if(enemies_hp[i] <= 0) {
                continue;
            }
            for(var j=0; j<BULLETS; j++) {
                // 弾が死んでいる場合はスルーする
                if(player_bullets_hp[j] <= 0) {
                    continue;
                }
                // 当たっていたときの処理
                if(hitCheck(
                    player_bullets_x[j], player_bullets_y[j],img_player_bullet,
                    enemies_x[i], enemies_y[i],img_enemy)) {
                        // 当たっているのでお互いのHPを1削る
                        player_bullets_hp[j] -= 1;
                        enemies_hp[i] -= 1;
                       // 敵が死んだ場合は killed を増やす
                        if(enemies_hp[i] == 0) {
                        killed++;
                    }
            } 
        }
    }
    };

    // 描画処理
    redraw();

    // 処理経過時間および次のループまでの間隔を計算
    var deltaTime = (new Date()) - startTime; // 現在の時間から開始時間を引く(経過時間)
    var interval = MSPF - deltaTime; // 33.3 - 経過時間
    if(interval > 0) {
        // 処理が早すぎるので次のループまで少し待つ
        setTimeout(mainloop, interval); // interval秒が経過した後にmainloop関数を実行する
    } else {
        // 処理が遅すぎるので即次のループを実行する
        mainloop();
    }
};

// キーが押された時に呼び出される処理を指定
window.onkeydown = function(e) {
    // キーを押された状態に更新
    KEYS[e.keyCode] = true;
}
// キーが離された時に呼び出される処理を指定
window.onkeyup = function(e) {
    // キーが離された状態に更新
    KEYS[e.keyCode] = false;
} 

// ページロード時に呼び出される処理
// window.onload = function() {};までの間が呼び出される
window.onload = function() {
    // コンテキスト(Canvasに描画するために使うツール)を取得
    canvas = document.getElementById('screen');
    ctx = canvas.getContext('2d');

    // Playerの画像（id='player'で指定された<img>）を取得
    img_player = document.getElementById('player');
    // Playerの弾画像（id='player_bullet'で指定された<img>）を取得
    img_player_bullet = document.getElementById('player_bullet');
    // 敵キャラの画像（id='enemy'で指定された<img>）を取得
    img_enemy = document.getElementById('enemy');

    // Playerの初期位置を指定
    player_x = (canvas.width - player.width) / 2; // キャンバスの左右中央
    player_y = (canvas.height - player.height) -20 // キャンバスの下から20px上
    // PlayerのHPを指定
    player_hp = 10;

    // 弾の初期位置およびHPを指定
    for(var i=0; i<BULLETS; i++) {
        player_bullets_x[i] = 0;
        player_bullets_y[i] = 0;
        player_bullets_hp[i] = 0;
    }

    // 敵キャラの初期位置およびHPを指定
    for(var i=0; i<ENEMIES; i++) {
        enemies_x[i] = Math.random() * (canvas.width - img_enemy.width);
        enemies_y[i] = Math.random() * (canvas.height - img_enemy.height);
        enemies_hp[i] = 2;
    }

    // メインループを開始する
    mainloop();
};

