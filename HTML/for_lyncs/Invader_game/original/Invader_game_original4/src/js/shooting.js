"use strict"
/* 全体で使用する変数を定義 */
var canvas;
var ctx;
// FPS管理に使用するパラメータを定義
var FPS = 30;
var MSPF = 1000 / FPS; // 33.3
// 倒した敵の数を保存する変数を定義
var killed = 0;

/* 画像を管理 */
// プレイヤーの画像を保持する変数を定義
var img_player;
// 敵キャラの画像を保持する変数を定義
var img_enemy;
// 大きい敵の画像を保存する変数を定義
var img_large_enemy;
// ボス敵の画像を保存する変数を定義
var img_boss_enemy;
// 壁の画像を保存する変数を定義
var img_kabe1;
var img_kabe2;
var img_kabe3;
var img_kabe4;

/* 弾の画像を管理 */
// プレイヤーの弾画像を保持する変数を定義
var img_player_bullet;
// ボス敵の弾画像を保持する変数を定義
var img_boss_enemy_bullet;

/* 位置を管理 */
// プレイヤーの現在位置を保持する変数を定義
var player_x;
var player_y;
// 敵キャラの現在位置（配列）を保持する変数を定義し、ENEMIES分だけ要素数を持つ配列を代入
var enemies_x = new Array(ENEMIES);
var enemies_y = new Array(ENEMIES);
// 大きい敵キャラの現在位置（配列）を保持する変数を定義し、ENEMIES分だけ要素数を持つ配列を代入
var large_enemies_x = new Array(LARGEENEMIES);
var large_enemies_y = new Array(LARGEENEMIES);
// ボス敵の現在位置を保持する変数を定義
var boss_enemy_x;
var boss_enemy_y;
// 壁の位置を保持する変数を定義
var kabe1_x;
var kabe1_y;
var kabe2_x;
var kabe2_y;
var kabe3_x;
var kabe3_y;
var kabe4_x;
var kabe4_y;

/* 敵の数を管理 */
// 敵キャラの数を定義
var ENEMIES = 10;
// 大きい敵キャラの数を定義
var LARGEENEMIES = 5;

/* 弾を管理 */
// プレイヤーの弾の数を定義（同時に描画される弾の最大数より大きい必要あり）
var BULLETS = 5;
// BULLETS分だけ要素数を持つ配列を代入
var player_bullets_x = new Array(BULLETS);
var player_bullets_y = new Array(BULLETS);
// ボス敵の弾の数を定義（同時に描画される弾の最大数より大きい必要あり）
var BOSSENEMIEBULLETS = 500;
// BOSSENEMIEBULLETS分だけ要素数を持つ配列を代入
var boss_enemy_bullets_x = new Array(BOSSENEMIEBULLETS);
var boss_enemy_bullets_y = new Array(BOSSENEMIEBULLETS);

/* 発射インターバルを管理 */
// プレイヤーの発射インターバルの値を定義（この値が大きいほど連射が遅くなる）
var FIRE_INTERVAL = 20;
// プレイヤーの発射インターバル
var player_fire_interval = 0;
// ボス敵の発射インターバルの値を定義（この値が大きいほど連射が遅くなる）
var BOSS_FIRE_INTERVAL = 15;
// ボス敵の発射インターバル
var boss_enemy_fire_interval = 0;

/* HPを管理 */
// プレイヤーのHP
var player_hp;
// 敵キャラのヒットポイント（配列）を保持する変数を定義し、ENEMIES分だけ要素数を持つ配列を代入
var enemies_hp = new Array(ENEMIES);
// 大きい敵キャラのヒットポイント（配列）を保持する変数を定義し、LARGEENEMIES分だけ要素数を持つ配列を代入
var large_enemies_hp = new Array(LARGEENEMIES);
// ボス敵のHP
var boss_enemy_hp;
// 壁のHPを管理
var kabe1_hp;
var kabe2_hp;
var kabe3_hp;
var kabe4_hp;

/* 弾のHPを管理 */
// プレイヤーの弾のヒットポイント（配列）を保持する変数を定義し、BULLETS分だけ要素数を持つ配列を代入
var player_bullets_hp = new Array(BULLETS);
// ボス敵の弾のヒットポイント（配列）を保持する変数を定義し、BOSSENEMIEBULLETS分だけ要素数を持つ配列を代入
var boss_enemy_bullets_hp = new Array(BOSSENEMIEBULLETS);

/* キーに関する処理 */
// キー状態管理変数の定義
var KEYS = new Array(256);
// キーの状態を false （押されていない）で初期化
for(var i=0; i<KEYS.length; i++) {
    KEYS[i] = false;
}
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

/* 再描画する関数（無引数、無戻り値）*/
var redraw = function() {
    // キャンバスをクリアする
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    /* プレイヤーと敵の画像の描画 */
    // 生きている場合のみ、新しい位置にプレイヤーを描画
    if(player_hp > 0) {
        ctx.drawImage(img_player, player_x, player_y);
    }

    // 敵キャラの画像を (enemies_x[i], enemies_y[i]) の位置に表示
    for(var i=0; i<ENEMIES; i++) {
        // 生きている場合のみ描画
        if(enemies_hp[i] > 0) {
            ctx.drawImage(img_enemy, enemies_x[i], enemies_y[i]);
        }
    }

    // 大きい敵キャラの画像を (enemies_x[i], enemies_y[i]) の位置に表示
    for(var i=0; i<LARGEENEMIES; i++) {
        // 生きている場合のみ描画
        if(large_enemies_hp[i] > 0) {
            ctx.drawImage(img_large_enemy, large_enemies_x[i], large_enemies_y[i]);
        }
    }
    // ボス敵キャラの画像を (enemies_x[i], enemies_y[i]) の位置に表示
    if(boss_enemy_hp > 0) {
        ctx.drawImage(img_boss_enemy, boss_enemy_x, boss_enemy_y);
    }

    /* 弾の画像の描画 */
    // 弾の画像を (bullets_x[i], bullets_y[i]) の位置に表示
    for(var i=0; i<BULLETS; i++) {
        // 生きている場合のみ描画
        if(player_bullets_hp[i] > 0) {
            ctx.drawImage(img_player_bullet,player_bullets_x[i],player_bullets_y[i]);
        }
    }
    
    // ボス敵の弾の画像を (boss_bullets_x[i], boss_bullets_y[i]) の位置に表示
    for(var i=0; i<BOSSENEMIEBULLETS; i++) {
        // 生きている場合のみ描画
        if(boss_enemy_bullets_hp[i] > 0) {
            ctx.drawImage(img_boss_enemy_bullet,boss_enemy_bullets_x[i],boss_enemy_bullets_y[i]);
        }
    }

    // 壁の画像を描画
    if(kabe1_hp > 0) {
        ctx.drawImage(img_kabe1,kabe1_x,kabe1_y);
    }
    if(kabe2_hp > 0) {
        ctx.drawImage(img_kabe2,kabe2_x,kabe2_y);
    }
    if(kabe3_hp > 0) {
        ctx.drawImage(img_kabe3,kabe3_x,kabe3_y);
    }
    if(kabe4_hp > 0) {
        ctx.drawImage(img_kabe4,kabe4_x,kabe4_y);
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
    var text = "Killed: " + killed + "/" + (ENEMIES + LARGEENEMIES);
    // 文字列の（描画）横幅を計算する
    var width = ctx.measureText(text).width;
    // 文字列を描画（白）
    ctx.fillStyle = "#fff";
    ctx.fillText(text, canvas.width - 10 - width, canvas.height - 10);
    
    // プレイヤーが死んでいた場合ゲームオーバー画面を表示する
    if(player_hp <= 0) {
        // 真ん中に大きな文字でゲームオーバー（赤）と表示する
        ctx.font = "60px sans-serif";
        ctx.textBaseline = "middle"; // 上下位置のベースラインを中心に
        ctx.fillStyle = "#f00";
        text = "Game Over";
        width = ctx.measureText(text).width;
        ctx.fillText(text, (canvas.width - width)/2, canvas.height/2);
    } 
    
    // ボス敵を撃破したらゲームクリアと表示させる
    if(boss_enemy_hp <= 0) {
        // 真ん中に大きな文字でゲームクリア（白）と表示する
        ctx.font = "60px sans-serif";
        ctx.textBaseline = "middle"; // 上下位置のベースラインを中心に
        ctx.fillStyle = "#fff";
        text = "Game Clear!!";
        width = ctx.measureText(text).width;
        ctx.fillText(text, (canvas.width - width)/2, canvas.height/2);
    }
    // コンテキストの状態を復元
    ctx.restore();
};

/* 移動に関する処理 */
// プレイヤーの移動処理、弾の発射を定義
var movePlayer = function() {
    // ヒットポイントを確認し、生きている場合のみ処理をする
    if(player_hp <= 0) {
        return;
    }
    // 移動速度を定義
    var SPEED = 4;
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

// 大きい敵キャラの移動処理を定義
var moveLargeEnemies = function() {
    // 移動速度を定義
    var SPEED = 4;
    // 各敵キャラごとに処理を行う
    for(var i=0; i<LARGEENEMIES; i++) {
        // ヒットポイントを確認し、生きている場合のみ処理をする
        if(large_enemies_hp[i] <= 0) {
            // ループの残りのステップを無視して次のループに行く場合は`continue` を指定する
            continue;
        }

    // 大きい敵キャラのy座標を少し増やす
    large_enemies_y[i] += SPEED;

    // 大きい敵キャラが横画面にはみ出た場合に戻す
    if(large_enemies_y[i] > canvas.height) {
        large_enemies_y[i] = -img_large_enemy.height;
        // x座標を再度ランダムに設定
        large_enemies_x[i] = Math.random() * (canvas.width - img_large_enemy.width);
    }
}
};

// ボス敵キャラの移動処理と弾の発射を定義
var moveBossEnemies = function() {
    // 移動速度を定義
    var SPEED = 6;

    // ボス敵キャラのy座標を少し増やす
    boss_enemy_x += SPEED;

    // ボス敵キャラが横画面にはみ出た場合は上に戻す
    if(boss_enemy_x > canvas.width) {
        boss_enemy_x = -img_boss_enemy.width;
        // x座標0から再度出現するようにに設定
        boss_enemy_x = 0;
    }
    
    // 生きている、なおかつ発射インターバルが0の時だけ発射する
    if(boss_enemy_hp > 0 && boss_enemy_fire_interval == 0) {
        // 未使用の弾があれば発射する
        for(var i=0; i<BOSSENEMIEBULLETS; i++) {
            if(boss_enemy_bullets_hp[i] == 0) {
                // 弾の初期位置はプレイヤーと同じ位置にする
                boss_enemy_bullets_x[i] = boss_enemy_x;
                boss_enemy_bullets_y[i] = (boss_enemy_y +100 );
                // 弾のHPを1にすることで、次のループから描画や移動処理が行われるようにする
                boss_enemy_bullets_hp[i] = 1;
                
                // 弾を打ったので発射インターバルの値を上げる
                boss_enemy_fire_interval = BOSS_FIRE_INTERVAL;
                
                // 弾を打ったのでループを抜ける
                break;
            }
        }
    }
    
    // 発射インターバルの値が0より大きい場合は値を減らす
    if(boss_enemy_fire_interval > 0) {
        boss_enemy_fire_interval -= 1;
    }
    
};

/* 弾の関する処理 */
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

// ボス敵の弾の移動処理を定義    
var moveBossEnemyBullets = function() {
    var SPEED = +6;

    // 各弾ごとに処理を行う
    for(var i=0; i<BOSSENEMIEBULLETS; i++) {
        // ヒットポイントを確認し、生きている場合のみ処理をする
        if(boss_enemy_bullets_hp[i] <= 0) {
            // ループの残りのステップを無視して次のループに行く場合は`continue` を指定する
            continue;
        }

        // 弾のy座標を少し増やす(下方向に移動)
        boss_enemy_bullets_y[i] += SPEED;
        
        /*
        // 弾が下画面にはみ出た場合はHPを0にして未使用状態に戻す
        if(boss_enemy_bullets_y[i] == canvas.height) {
            boss_enemy_bullets_hp[i] = 0;
        }
        */
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

    /* 実行する関数 */
    // プレイヤーの移動処理
    movePlayer();
    // プレイヤーの弾の移動処理
    movePlayerBullets();
    // 敵キャラの移動処理
    moveEnemies();
    // 大きい敵キャラの移動処理
    moveLargeEnemies();
    // ボス敵キャラの移動処理
    moveBossEnemies();
    // ボス敵キャラの弾の移動処理
    moveBossEnemyBullets();

    /* プレイヤー x 敵の当たり判定 */
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
    
    // プレイヤーと大きい敵キャラの当たり判定(プレイヤーが生きている場合)
    if(player_hp > 0) {
        for(var i=0; i<LARGEENEMIES; i++) {
            // 敵が生きている間のみ判定する
            if(large_enemies_hp[i] > 0) {
                if(hitCheck(player_x, player_y, img_player, large_enemies_x[i], large_enemies_y[i], img_large_enemy)){
                    // 当たっているのでお互いのHPを1削る
                    player_hp -=1;
                    large_enemies_hp[i] -=1;
                    // 敵を撃破した場合はkilledを増やす
                    if(large_enemies_hp[i] == 0) {
                        killed++; 
                    }
                }
            }
        }
    }

    /* プレイヤー弾 x 敵の当たり判定 */
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
    // プレイヤー弾と大きい敵キャラの当たり判定（プレイヤーが生きている場合）
    if(player_hp > 0) {
        for(var i=0; i<LARGEENEMIES; i++) {
            // 敵が死んでいる場合はスルーする
            if(large_enemies_hp[i] <= 0) {
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
                    large_enemies_x[i], large_enemies_y[i],img_large_enemy)) {
                        // 当たっているのでお互いのHPを1削る
                        player_bullets_hp[j] -= 1;
                        large_enemies_hp[i] -= 1;
                       // 敵が死んだ場合は killed を増やす
                        if(large_enemies_hp[i] == 0) {
                        killed++;
                    }
            } 
        }
    }
    };

    // プレイヤーの弾とボス敵の当たり判定（プレイヤーが生きている場合）
    if(player_hp > 0) {
        for(var j=0; j<BULLETS; j++) {
            // 弾が死んでいる場合はスルーする
            if(player_bullets_hp[j] <= 0) {
                continue;
            }
            // 当たっていたときの処理
            if(hitCheck(
                player_bullets_x[j], player_bullets_y[j],img_player_bullet,
                boss_enemy_x, boss_enemy_y,img_boss_enemy)) {
                    // 当たっているのでお互いのHPを1削る
                    player_bullets_hp[j] -= 1;
                    boss_enemy_hp -= 1;
                }    
        } 
    }

    // 壁とプレイヤーの弾の当たり判定（壁が生きている場合）
    if(kabe1_hp > 0) {
        for(var j=0; j<BULLETS; j++) {
            // 弾が死んでいる場合はスルーする
            if(player_bullets_hp[j] <= 0) {
                continue;
            }
            // 当たっていたときの処理
            if(hitCheck(
                player_bullets_x[j], player_bullets_y[j],img_player_bullet,
                kabe1_x, kabe1_y,img_kabe1)) {
                    // 当たっているのでお互いのHPを1削る
                    player_bullets_hp[j] -= 1;
                    kabe1_hp -= 1;
                }    
        } 
    }

    if(kabe2_hp > 0) {
        for(var j=0; j<BULLETS; j++) {
            // 弾が死んでいる場合はスルーする
            if(player_bullets_hp[j] <= 0) {
                continue;
            }
            // 当たっていたときの処理
            if(hitCheck(
                player_bullets_x[j], player_bullets_y[j],img_player_bullet,
                kabe2_x, kabe2_y,img_kabe2)) {
                    // 当たっているのでお互いのHPを1削る
                    player_bullets_hp[j] -= 1;
                    kabe2_hp -= 1;
                }    
        } 
    }

    if(kabe3_hp > 0) {
        for(var j=0; j<BULLETS; j++) {
            // 弾が死んでいる場合はスルーする
            if(player_bullets_hp[j] <= 0) {
                continue;
            }
            // 当たっていたときの処理
            if(hitCheck(
                player_bullets_x[j], player_bullets_y[j],img_player_bullet,
                kabe3_x, kabe3_y,img_kabe3)) {
                    // 当たっているのでお互いのHPを1削る
                    player_bullets_hp[j] -= 1;
                    kabe3_hp -= 1;
                }    
        } 
    }

    if(kabe4_hp > 0) {
        for(var j=0; j<BULLETS; j++) {
            // 弾が死んでいる場合はスルーする
            if(player_bullets_hp[j] <= 0) {
                continue;
            }
            // 当たっていたときの処理
            if(hitCheck(
                player_bullets_x[j], player_bullets_y[j],img_player_bullet,
                kabe4_x, kabe4_y,img_kabe4)) {
                    // 当たっているのでお互いのHPを1削る
                    player_bullets_hp[j] -= 1;
                    kabe4_hp -= 1;
                }    
        } 
    }

    // 敵と壁の当たり判定(壁が生きている場合のみ判定)
    if(kabe1_hp >0) {
        for(var i=0; i<ENEMIES; i++) {
            // 敵が生きている間のみ判定する
            if(enemies_hp[i] > 0) {
                if(hitCheck(kabe1_x, kabe1_y, img_kabe1, enemies_x[i], enemies_y[i], img_enemy)){
                    // 当たっているのでお互いのHPを1削る
                    kabe1_hp -=1;
                    enemies_hp[i] -=1;
                }
            }
        }
    }

    if(kabe2_hp >0) {
        for(var i=0; i<ENEMIES; i++) {
            // 敵が生きている間のみ判定する
            if(enemies_hp[i] > 0) {
                if(hitCheck(kabe2_x, kabe2_y, img_kabe2, enemies_x[i], enemies_y[i], img_enemy)){
                    // 当たっているのでお互いのHPを1削る
                    kabe2_hp -=1;
                    enemies_hp[i] -=1;
                }
            }
        }
    }

    if(kabe3_hp >0) {
        for(var i=0; i<ENEMIES; i++) {
            // 敵が生きている間のみ判定する
            if(enemies_hp[i] > 0) {
                if(hitCheck(kabe3_x, kabe3_y, img_kabe3, enemies_x[i], enemies_y[i], img_enemy)){
                    // 当たっているのでお互いのHPを1削る
                    kabe3_hp -=1;
                    enemies_hp[i] -=1;
                }
            }
        }
    }

    if(kabe4_hp >0) {
        for(var i=0; i<ENEMIES; i++) {
            // 敵が生きている間のみ判定する
            if(enemies_hp[i] > 0) {
                if(hitCheck(kabe4_x, kabe4_y, img_kabe4, enemies_x[i], enemies_y[i], img_enemy)){
                    // 当たっているのでお互いのHPを1削る
                    kabe4_hp -=1;
                    enemies_hp[i] -=1;
                }
            }
        }
    }

    // 大きい壁と敵の当たり判定
    if(kabe1_hp > 0) {
        for(var i=0; i<LARGEENEMIES; i++) {
            // 敵が生きている間のみ判定する
            if(large_enemies_hp[i] > 0) {
                if(hitCheck(kabe1_x, kabe1_y, img_kabe1, large_enemies_x[i], large_enemies_y[i], img_large_enemy)){
                    // 当たっているのでお互いのHPを1削る
                    kabe1_hp -=1;
                    large_enemies_hp[i] -=2;
                }
            }
        }
    }

    if(kabe2_hp > 0) {
        for(var i=0; i<LARGEENEMIES; i++) {
            // 敵が生きている間のみ判定する
            if(large_enemies_hp[i] > 0) {
                if(hitCheck(kabe2_x, kabe2_y, img_kabe2, large_enemies_x[i], large_enemies_y[i], img_large_enemy)){
                    // 当たっているのでお互いのHPを1削る
                    kabe2_hp -=1;
                    large_enemies_hp[i] -=2;
                }
            }
        }
    }

    if(kabe3_hp > 0) {
        for(var i=0; i<LARGEENEMIES; i++) {
            // 敵が生きている間のみ判定する
            if(large_enemies_hp[i] > 0) {
                if(hitCheck(kabe3_x, kabe3_y, img_kabe3, large_enemies_x[i], large_enemies_y[i], img_large_enemy)){
                    // 当たっているのでお互いのHPを1削る
                    kabe3_hp -=1;
                    large_enemies_hp[i] -=2;
                }
            }
        }
    }

    if(kabe4_hp > 0) {
        for(var i=0; i<LARGEENEMIES; i++) {
            // 敵が生きている間のみ判定する
            if(large_enemies_hp[i] > 0) {
                if(hitCheck(kabe4_x, kabe4_y, img_kabe4, large_enemies_x[i], large_enemies_y[i], img_large_enemy)){
                    // 当たっているのでお互いのHPを1削る
                    kabe4_hp -=1;
                    large_enemies_hp[i] -=2;
                }
            }
        }
    }

    // 壁とボス敵の弾の当たり判定
    if( kabe1_hp > 0) {
        for(var j=0; j<BOSSENEMIEBULLETS; j++) {
            // 弾が死んでいる場合はスルーする
            if(boss_enemy_bullets_hp[j] <= 0) {
                continue;
            }
            // 当たっていたときの処理
            if(hitCheck(
                boss_enemy_bullets_x[j], boss_enemy_bullets_y[j],img_boss_enemy_bullet,
                kabe1_x, kabe1_y,img_kabe1)) {
                    // 当たっているのでお互いのHPを1削る
                    boss_enemy_bullets_hp[j] -= 1;
                    kabe1_hp -= 1;
                }    
        } 
    }
    if( kabe2_hp > 0) {
        for(var j=0; j<BOSSENEMIEBULLETS; j++) {
            // 弾が死んでいる場合はスルーする
            if(boss_enemy_bullets_hp[j] <= 0) {
                continue;
            }
            // 当たっていたときの処理
            if(hitCheck(
                boss_enemy_bullets_x[j], boss_enemy_bullets_y[j],img_boss_enemy_bullet,
                kabe2_x, kabe2_y,img_kabe2)) {
                    // 当たっているのでお互いのHPを1削る
                    boss_enemy_bullets_hp[j] -= 1;
                    kabe2_hp -= 1;
                }    
        } 
    }
    if( kabe3_hp > 0) {
        for(var j=0; j<BOSSENEMIEBULLETS; j++) {
            // 弾が死んでいる場合はスルーする
            if(boss_enemy_bullets_hp[j] <= 0) {
                continue;
            }
            // 当たっていたときの処理
            if(hitCheck(
                boss_enemy_bullets_x[j], boss_enemy_bullets_y[j],img_boss_enemy_bullet,
                kabe3_x, kabe3_y,img_kabe3)) {
                    // 当たっているのでお互いのHPを1削る
                    boss_enemy_bullets_hp[j] -= 1;
                    kabe3_hp -= 1;
                }    
        } 
    }
    if( kabe4_hp > 0) {
        for(var j=0; j<BOSSENEMIEBULLETS; j++) {
            // 弾が死んでいる場合はスルーする
            if(boss_enemy_bullets_hp[j] <= 0) {
                continue;
            }
            // 当たっていたときの処理
            if(hitCheck(
                boss_enemy_bullets_x[j], boss_enemy_bullets_y[j],img_boss_enemy_bullet,
                kabe4_x, kabe4_y,img_kabe4)) {
                    // 当たっているのでお互いのHPを1削る
                    boss_enemy_bullets_hp[j] -= 1;
                    kabe4_hp -= 1;
                }    
        } 
    }

    // ボス敵の弾とプレイヤーの当たり判定
    if( player_hp > 0) {
        for(var j=0; j<BOSSENEMIEBULLETS; j++) {
            // 弾が死んでいる場合はスルーする
            if(boss_enemy_bullets_hp[j] <= 0) {
                continue;
            }
            // 当たっていたときの処理
            if(hitCheck(
                boss_enemy_bullets_x[j], boss_enemy_bullets_y[j],img_boss_enemy_bullet,
                player_x, player_y,img_player)) {
                    // 当たっているのでお互いのHPを1削る
                    boss_enemy_bullets_hp[j] -= 1;
                    player_hp -= 1;
                }    
        } 
    }

    // プレイヤーの弾とボスの弾の当たり判定
    if(player_hp > 0) {
        for(var i=0; i<BOSSENEMIEBULLETS; i++) {
            // 敵が死んでいる場合はスルーする
            if(boss_enemy_bullets_hp[i] <= 0) {
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
                    boss_enemy_bullets_x[i], boss_enemy_bullets_y[i],img_boss_enemy_bullet)) {
                        // 当たっているのでお互いのHPを1削る
                        player_bullets_hp[j] -= 1;
                        boss_enemy_bullets_hp[i] -= 1;
                    }
            } 
        }
    }

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
    };
};

// ページロード時に呼び出される処理
// window.onload = function() {};までの間が呼び出される
window.onload = function() {
    // コンテキスト(Canvasに描画するために使うツール)を取得
    canvas = document.getElementById('screen');
    ctx = canvas.getContext('2d');

    /* 画像を取得 */
    // Playerの画像（id='player'で指定された<img>）を取得
    img_player = document.getElementById('player');
    // Playerの弾画像（id='player_bullet'で指定された<img>）を取得
    img_player_bullet = document.getElementById('player_bullet');
    // 敵キャラの画像（id='enemy'で指定された<img>）を取得
    img_enemy = document.getElementById('enemy');
    // 大きい敵キャラの画像（id='enemy'で指定された<img>）を取得
    img_large_enemy = document.getElementById('large_enemy');
    // ボス敵キャラの画像（id='enemy'で指定された<img>）を取得
    img_boss_enemy = document.getElementById('boss_enemy');
    // ボス敵キャラの弾の画像（id='boss_enemy_bullet'で指定された<img>）を取得
    img_boss_enemy_bullet = document.getElementById('boss_enemy_bullet');
    // 壁の画像(img id="kabe")を取得
    img_kabe1 = document.getElementById('kabe1');
    img_kabe2 = document.getElementById('kabe2');
    img_kabe3 = document.getElementById('kabe3');
    img_kabe4 = document.getElementById('kabe4');

    /* 初期位置とHPを指定 */
    // Playerの初期位置を指定
    player_x = (canvas.width - player.width) / 2; // キャンバスの左右中央
    player_y = (canvas.height - player.height) -20; // キャンバスの下から20px上
    player_hp = 10;

    // 敵キャラの初期位置およびHPを指定
    for(var i=0; i<ENEMIES; i++) {
        enemies_x[i] = Math.random() * (canvas.width - img_enemy.width);
        enemies_y[i] = Math.random() * (320 - img_enemy.height);
        enemies_hp[i] = 1;
    }

    // 大きい敵キャラの初期位置およびHPを指定
    for(var i=0; i<LARGEENEMIES; i++) {
        large_enemies_x[i] = Math.random() * (canvas.width - img_large_enemy.width);
        large_enemies_y[i] = Math.random() * (100 - img_large_enemy.height);
        large_enemies_hp[i] = 2;
    }

    // ボス敵キャラの初期位置とHPを指定
    boss_enemy_x = (canvas.width - boss_enemy.width) / 2; // キャンバスの左右中央
    boss_enemy_y = 0;
    boss_enemy_hp = 5;

    /* 弾に関する処理 */
    // プレイヤーの弾の初期位置およびHPを指定
    for(var i=0; i<BULLETS; i++) {
        player_bullets_x[i] = 0;
        player_bullets_y[i] = 0;
        player_bullets_hp[i] = 0;
    }

    // ボス敵の弾の初期位置およびHPを指定
    for(var i=0; i<BOSSENEMIEBULLETS; i++) {
        boss_enemy_bullets_x[i] = 0;
        boss_enemy_bullets_y[i] = 0;
        boss_enemy_bullets_hp[i] = 0;
    }

    // 壁1の位置とHPを指定
    kabe1_x = 40; 
    kabe1_y = (canvas.height - kabe1.height) -140 
    kabe1_hp = 3;

    // 壁2の位置とHPを指定
    kabe2_x = 200; 
    kabe2_y = (canvas.height - kabe2.height) -140
    kabe2_hp = 3;

    // 壁3の位置とHPを指定
    kabe3_x = 400; 
    kabe3_y = (canvas.height - kabe3.height) -140 
    kabe3_hp = 3;

    // 壁4の位置とHPを指定
    kabe4_x = 570; 
    kabe4_y = (canvas.height - kabe4.height) -140 
    kabe4_hp = 3;

    // メインループを開始する
    mainloop();
};
