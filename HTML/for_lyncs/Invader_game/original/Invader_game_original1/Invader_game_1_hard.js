            // 難易度hard
            // プログラム全体で使う変数の宣言
            // コンテキスト、イメージ、サウンド、ゲーム中かどうかのフラグなど
            let canvas;
            let context;
            let imgjiki;
            let imgmido;
            let imgmizu;
            let imgnani;
            let imgaka;
            let imgbaku;
            let bg;
            let enmys;
            // 背景の動く星
            let hoshi;
            let tamas;
            let count;
            let bakut;
            // ゲームオーバーの文字列
            // 見えないだけで空白を常に表示しており、ゲームオーバーの時だけ文字列をセットする
            let str_gameover;
            let gamemode;

            /*
            // スコア表示
            function drawScore() {
            // ctxが未定義 
            // Uncaught ReferenceError: 初期化前に 'dx' にアクセスできません 131
            // Uncaught ReferenceError: 初期化前に 'dx' にアクセスできません 456
            ctx.font = "16px Arial";
            ctx.fillStyle = "#0095DD";
            ctx.fillText("Score: "+score, 8, 20);
            }
            drawScore();
            */

            // 初期化関数
            function initw() {
                // キャンバスを2つ、コンテキストを2つ使用→ちらつき防止のダブルバッファ
                canvas = [];
                canvas[0] = document.getElementById('canvas');
                canvas[1] = document.getElementById('canvas2');
                context = [];
                context[0] = canvas[0].getContext('2d');
                context[1] = canvas[1].getContext('2d');
                
                canvas[0].addEventListener('mousemove', mouseMove, false);
                canvas[1].addEventListener('mousemove', mouseMove, false);
                
                canvas[0].addEventListener('click', mouseClick, false);
                canvas[1].addEventListener('click', mouseClick, false);
                
                // 画像の読み込み
                // new Imageして画像を指定して、クロスオリジンをアノニマスにしている
                imgjiki = new Image();
                imgjiki.src = "./jiki.png";
                imgjiki.setAttribute('crossOrigin', 'anonymous');
                
                imgmido = new Image();
                imgmido.src = "./mido.png";
                imgmido.setAttribute('crossOrigin', 'anonymous');
                
                imgmizu = new Image();
                imgmizu.src = "./mizu.png";
                imgmizu.setAttribute('crossOrigin', 'anonymous');
                
                imgaka = new Image();
                imgaka.src = "./aka.png";
                imgaka.setAttribute('crossOrigin', 'anonymous');
                
                imgnani = new Image();
                imgnani.src = "./nani.png";
                imgnani.setAttribute('crossOrigin', 'anonymous');
                
                imgbaku = new Image();
                imgbaku.src = "./baku.png";
                imgbaku.setAttribute('crossOrigin', 'anonymous');
                
                // 画像の読み込みが完了したら呼ばれるところ
                let i = 0;
                imgjiki.onload = function () {
                    // どの画像が最後に届くかわからないので、数を数えて一番最後だと表示に行っている
                    // 画像が5個あるから5を超えたらやる
                    // requestAnimationFrameは登録した関数を、ディスプレイのリフレッシュレートに合わせて描写してくれる
                    i++; if (i > 5) { setenmy(); requestAnimationFrame(Onanime); }
                }
                imgmido.onload = function () {
                    i++; if (i > 5) { setenmy(); requestAnimationFrame(Onanime); }
                }
                imgmizu.onload = function () {
                    i++; if (i > 5) { setenmy(); requestAnimationFrame(Onanime); }
                }
                imgaka.onload = function () {
                    i++; if (i > 5) { setenmy(); requestAnimationFrame(Onanime); }
                }
                imgnani.onload = function () {
                    i++; if (i > 5) { setenmy(); requestAnimationFrame(Onanime); }
                }
                imgbaku.onload = function () {
                    i++; if (i > 5) { setenmy(); requestAnimationFrame(Onanime); }
                }
                tamas = [];
                
                hoshi = [];
                let obj;
                for (let t = 0; t < 200; t++) {
                    obj = new Object();
                    obj.x = getRandomInt(600);
                    obj.y = getRandomInt(600);
                    // 後ろの流れる星
                    let red = getRandomInt(256);
                    let green = getRandomInt(256);
                    let blue = getRandomInt(256);
                    obj.c = 'rgb(' + red + ',' + green + ',' + blue + ')';
                    
                    hoshi.push(obj);
                }
                
                // スタートボタンでゲーム開始だから、プログラムからボタンクリックを呼ぶ
                buttonStart_click();
            }

            function buttonStart_click(sender) {
                // ゲーム中かどうかのフラグ
                gamemode = false;
                // ゲームオーバーの文字列に空白を入れているからこれは消える
                str_gameover = " ";
                // 自機の数=残機
                count = 2;
                // 爆発を表示する時間
                // 即消すと見えないため、当たったらしばらく表示させる。
                // 当たったら適当な数字にして別なところでカウントダウンして数字が0になるまで爆発を表示させる。
                bakut = -1;
                dx = 550; dy = 0;
                px = py = 550;
                // 敵を並べる
                setenmy();
                bg = 1;
                Render();
            }
            function setenmy() {
                enmys = [];
                let i;
                let obj;
                // 緑の敵
                for (let t = 0; t < 3; t++) {
                    for (i = 0; i < 10; i++) {
                        obj = new Object();
                        obj.img = imgmido;
                        obj.x = i * 40;
                        obj.y = 100 + t * 30;
                        obj.rx = obj.x;
                        obj.ry = obj.y;
                        // movieは移動方法を決める関数、切り替えて別の動作をさせるようにしている
                        obj.action = movie;
                        enmys.push(obj);
                    }
                }
                // 水色の敵
                for (i = 0; i < 8; i++) {
                    obj = new Object();
                    obj.img = imgmizu;
                    obj.x = i * 45 + 30;
                    obj.y = 80;
                    obj.rx = obj.x;
                    obj.ry = obj.y;
                    obj.action = movie;
                    enmys.push(obj);
                }
                // 赤の敵
                for (i = 0; i < 6; i++) {
                    obj = new Object();
                    obj.img = imgaka;
                    obj.x = i * 55 + 50;
                    obj.y = 60;
                    obj.rx = obj.x;
                    obj.ry = obj.y;
                    obj.action = movie;
                    enmys.push(obj);
                }
                for (i = 0; i < 2; i++) {
                    obj = new Object();
                    obj.img = imgnani;
                    obj.x = (i == 0) ? 70 : 300;
                    obj.y = 40;
                    obj.rx = obj.x;
                    obj.ry = obj.y;
                    obj.action = movie;
                    enmys.push(obj);
                }
            }
            
            // ランダム整数の作成
            function getRandomInt(max) {
                return Math.floor(Math.random() * max);
            }
            let px; let py;

            // マウスで動かすイベント
            function mouseMove(e) {
                // マウスの座標から、それがキャンバスのどこなのか求めてる
                let rect = e.target.getBoundingClientRect();
                px = e.clientX - rect.left;
                py = e.clientY - rect.top;
            }
            let dx; let dy;

            // マウスのクリック
            function mouseClick(e) {
                let rect = e.target.getBoundingClientRect();
                if (dy < 5) {
                    //一回に1発
                    dx = e.clientX - rect.left + 8;
                    dy = 550;
                }
            }
            let cpos = 0;

            // フレームごとに呼ばれる関数
            // 当たりチェックなどをやって、表示のdraw()を呼び出している
            function Onanime() {
                // 敵に弾が当たったのかのチェック
                for (i = 0; i < enmys.length; i++) {
                    atari(enmys[i]);
                }
                // 敵と自分が当たってないかのチェック
                for (i = 0; i < enmys.length; i++) {
                    // 
                    enmys[i].action(enmys[i]);
                    atarie(enmys[i]);
                }
                // 敵の弾が自分に当たってないかのチェック
                for (let i = 0; i < tamas.length; i++) {
                    atarit(tamas[i]);
                }
                cpos += kasok;
                if (cpos > 10 || cpos < 0) cpos = 0;
                // ランダムにサイコロを振って10回に1回は別の関数に置き換わる
                if (getRandomInt(100) == 1) {
                    // actionという関数をmovie2()という関数に付け替える
                    enmys[getRandomInt(enmys.length)].action = movie2;
                }
                // もう一度サイコロを振ってmovie3()に置き換える敵
                // 関数を置き換えられた敵は次にaction()を呼ばれた時は、他と違う動きをする
                if (getRandomInt(10) == 1) {
                    enmys[getRandomInt(enmys.length)].action = movie3;
                }
                for (i = 0; i < enmys.length; i++) {
                    if (enmys[i].bcount == 0) {
                        // 爆破表示が終わった人は敵リストから削除する
                        enmys.splice(i, 1);
                        break;
                    }
                }
                // 敵の配列が空になったら、また敵をセットする
                if (enmys.length == 0) {
                    setenmy();
                }
                // 自機の残機が0ならゲームオーバーを表示
                if (count == 0) {
                    str_gameover = "Game Over";
                    // ゲームモードをやめるフラグを立てる
                    gamemode = true;
                }
                // 準備が揃ったので描写
                draw();
                requestAnimationFrame(Onanime);
            }
            
            function draw() {
                // 背景を黒く塗る
                context[bg].fillStyle = 'purple';
                context[bg].fillRect(0, 0, 600, 600);
                // 星を描写
                // 星を動かして下まで行ったら一番上に戻す
                for (let t = 0; t < 200; t++) {
                    context[bg].fillStyle = hoshi[t].c;
                    if (getRandomInt(10) > 1) context[bg].fillRect(hoshi[t].x, hoshi[t].y, 1, 1);
                    hoshi[t].y++; if (hoshi[t].y > 600) hoshi[t].y = 0;
                }
                // 敵を描写
                for (i = 0; i < enmys.length; i++) {
                    // 爆破中なら爆破カウントを減らす
                    if (enmys[i].bcount > 0) {
                        context[bg].drawImage(imgbaku, enmys[i].x, enmys[i].y, 18, 18);
                        enmys[i].bcount--;
                    } else {
                        // 攻撃中の敵は2度ずつ回転しながら描写
                        if (enmys[i].action == movie2 || enmys[i].action == movie3) {
                            if (enmys[i].angle < 180) enmys[i].angle += 5;
                            drawRotatedImage(enmys[i].img, enmys[i].x, enmys[i].y, enmys[i].angle);
                        } else {
                            context[bg].drawImage(enmys[i].img, enmys[i].x, enmys[i].y, 18, 18);
                        }
                    }
                }
                
                // 敵の弾の移動、下まで行ったら削除
                for (let i = 0; i < tamas.length; i++) {
                    context[bg].strokeStyle = 'White';
                    context[bg].lineWidth = 1;
                    context[bg].beginPath();
                    context[bg].moveTo(tamas[i].x, tamas[i].y);
                    context[bg].lineTo(tamas[i].x, tamas[i].y - 20);
                    context[bg].closePath();
                    context[bg].stroke();
                    tamas[i].y += 4;
                    if (tamas[i].y > 600) tamas.splice(i, 1);
                }
                // 赤文字でゲームオーバーと描く
                context[bg].font = " 50px MS UI Gothic";
                context[bg].fillStyle = 'Red';
                context[bg].fillText(str_gameover, 50, 230);
                
                if (gamemode) {
                    // ゲーム中じゃない時は、ここで終了
                    Render();
                    return;
                }
                //自機
                if (bakut > 0) {
                    // 爆破表示中なら爆破を表示してカウントダウン
                    context[bg].drawImage(imgbaku, px, 550, 16, 16);
                    bakut--;
                } else {
                    // カウントゼロなら自機の残機を減らして爆破表示をやめる
                    context[bg].drawImage(imgjiki, px, 550, 16, 16);
                    if (bakut == 0) {
                        count--; bakut = -1;
                    }
                }
                // 左上の残機の表示
                for (i = 0; i < count; i++) {
                    context[bg].drawImage(imgjiki, i * 20, 0, 16, 16);
                }
                //自機の撃った弾の表示
                if (dy > 0) {
                    context[bg].strokeStyle = 'Yellow';
                    context[bg].lineWidth = 1;
                    context[bg].beginPath();
                    context[bg].moveTo(dx, dy);
                    context[bg].lineTo(dx, dy - 20);
                    context[bg].closePath();
                    context[bg].stroke();
                    dy -= 5;
                }
                // 全部描いたらレンダリング
                Render();
            }
            // 2画面用意して配列に入れて、片方を消して片方を表示にしている
            // 表示してないほうに描いて描き終わったら、表示と消すを入れ替える
            // 見えてないキャンバスに描いて描き終わったら見えているキャバスを消して見えてない方が表示される
            // 著作権対策？
            // パタパタとコンテキストを切り替えてダブルバッファを実現
            function Render() {
                canvas[1 - bg].style.display = 'none';
                canvas[bg].style.display = 'block';
                // bgは、パタパタと1と0が切り替わる
                bg = 1 - bg;
            }
            // キャンバスのコンテキストの回転させる
            // キャラ中心が左上角になるようにコンテキストを動かして回転してから戻す
            // 表示を保存し、動かして回転させてキャラを描いて絵を戻している
            function drawRotatedImage(image, x, y, angle) {
                const TO_RADIANS = Math.PI / 180;
                context[bg].save();
                context[bg].translate(x, y);
                context[bg].rotate(angle * TO_RADIANS);
                context[bg].drawImage(image, -(image.width / 2), -(image.height / 2), 20, 20);
                context[bg].restore();
            }
            let kasok = 1;
            
            // movie()は並んで動く通常の動き
            function movie(obj) {
                obj.angle = 0;
                obj.x += kasok;
                if (obj.x > 570 || obj.x < 0) kasok *= -1;
            }
            // キャラの動きを変えてるそれぞれの変数
            // movie2()は落下してくる動き
            function movie2(obj) {
                obj.y++;
                let tx = obj.x + Math.floor(Math.sin(obj.y / 100) * 2);
                if (tx < 610) {
                    obj.x += Math.floor(Math.sin(obj.y / 100) * 2);
                } else {
                    obj.x -= Math.floor(Math.sin(obj.y / 100) * 2);
                }
                if (tx > -20) {
                    obj.x += Math.floor(Math.sin(obj.y / 100) * 2);
                } else {
                    obj.x -= Math.floor(Math.sin(obj.y / 100) * 2);
                }
                // 落下しながら弾も撃ってくる
                // 弾の初期位置は自分の位置を使用
                if (getRandomInt(100) == 1) {
                    cy = obj.y + 50; cx = obj.x
                    let tama = new Object();
                    tama.y = obj.y + 50; tama.x = obj.x
                    // 弾のオブジェクトを作って配列に追加
                    tamas.push(tama);
                }
                // 敵機は一番下まで行ったら回転角を0度にして、movier()という所定ポジションに戻る動きに、動作を変えている
                if (obj.y > 600) {
                    obj.y = 0;
                    obj.x = obj.rx + cpos;
                    obj.action = movier;
                    obj.angle = 0;
                }
            }
            function movie3(obj) {
                obj.y++;
                let tx = obj.x + Math.floor(Math.cos(obj.y / 80) * 2);
                if (tx < 610) {
                    obj.x += Math.floor(Math.cos(obj.y / 80) * 2);
                } else {
                    obj.x -= Math.floor(Math.cos(obj.y / 80) * 2);
                }
                if (tx > -20) {
                    obj.x += Math.floor(Math.cos(obj.y / 80) * 2);
                } else {
                    obj.x -= Math.floor(Math.cos(obj.y / 80) * 2);
                }
                if (getRandomInt(100) == 1) {
                    cy = obj.y + 50; cx = obj.x
                    let tama = new Object();
                    tama.y = obj.y + 50; tama.x = obj.x
                    tamas.push(tama);
                }
                if (obj.y > 600) {
                    obj.y = 0;
                    obj.x = obj.rx + cpos;
                    obj.action = movier;
                }
            }
            // 敵が編隊にに戻る動作
            // cposが、始まったらこれくらい動いたんじゃないかという量
            function movier(obj) {
                obj.angle = 0;
                let xx = obj.rx - obj.x + cpos;
                let yy = obj.ry - obj.y;
                if (xx > 0) {
                    obj.x++;
                } else if (xx < 0) {
                    obj.x--;
                }
                if (yy > 0) {
                    let my = Math.floor(yy / 10);
                    if (my == 0) {
                        obj.y = obj.ry;
                    } else { obj.y++ }
                }
                if (xx == 0 && yy == 0) obj.action = movie;
            }
            // 敵のオブジェクトを入れて範囲内に撃った弾が入ってないか調べる
            // これをループで全敵分やる
            function atari(obj) {
                if (obj.x < dx && dx < obj.x + 18 && obj.y < dy && dy < obj.y + 18) {
                    // 爆破表示タイム
                    obj.bcount = 20;
                    dx = -1;
                }
            }
            // 敵と自機との当たり判定
            function atarie(obj) {
                // 爆破中はやらない→自機が爆破中に別な弾が当たると一気に2機やられてしまうから
                if (bakut > 0) return;
                if (px < obj.x + 18 && obj.x < px + 16 && 550 < obj.y + 18 && obj.y < 550 + 16) {
                    obj.bcount = 20;
                    bakut = 20;
                }
            }
            // 自機と敵弾の当たり判定
            function atarit(obj) {
                if (bakut > 0) return;
                if (px < obj.x && obj.x < px + 16 && 550 < obj.y && obj.y - 20 < 550 + 16) {
                    let no = tamas.indexOf(obj);
                    tamas.splice(no, 1);
                    bakut = 20;
                }
            }
            
            
            /* 
            全体の挙動について
            インサートコインでゲーム開始(初期化)
            いろんな色を動かして星を表現
            弾が当たると爆破カウンタに20入れて、ここが呼ばれる度にマイナスして0になったら敵を消す
            ランダムで動作のaction()関数の中身を変えられた敵が攻撃を仕掛けてくる(その際に回転しながら襲ってくる)
            下まで行ったら位置を上にして、元の場所に戻る関数に変える

            メモ
            ①コンテキストを切り替えてダブルバッファをやれば、クロスオリジンから逃げられる
            ②キャラの回転はコンテキストを回転させる
            ③オブジェクトの関数を上書きして行動を変えればif文で場合分けするよりすっきり書ける(今回classは使用していない)
            */
