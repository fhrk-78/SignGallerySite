<?php require('./config.php') ?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>SignGallery</title>
        <link rel="stylesheet" href="assets/index.css" />
        <link rel="icon" type="image/x-icon" href="./assets/favicon.ico">
    </head>

    <body>
        <header>
            <p>
                まるまささん開発の FabricLoader 向け 1.20.x 対応画像Mod<br/>
                「MarumaSign」のダウンロードはここから<br/>
                まるまささんは<b>多くのソフトウェアをオープンソースで</b>開発しています。<br/>
                <a class="getnow" href="https://www.curseforge.com/minecraft/mc-mods/marumasign" target="_blank" rel="norefer noopener">MarumaSignを入手</a>
                <a class="getnow" href="https://donate.marumasa.dev/" target="_blank" rel="norefer noopener" style="background-color: #5555ff; margin-left: 0;">寄付する</a>
            </p>
        </header>
        <?php
        // データベースコネクションの作成
        $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname, $dbport);

        if (isset($_GET['id'])) {
            // URIパラメータ取得
            $id = $_GET['id'];

            // SQLインジェクション対策()
            $sqlbefore = $mysqli->prepare("SELECT * FROM signs WHERE id = ? LIMIT 1;");
            $sqlbefore->bind_param('i', $id);
            $sqlbefore->execute();
            $result = $sqlbefore->get_result()->fetch_assoc();
            $sqlbefore->close();

            print <<<__HTML__
            <div class="imagecard">
                <img src="{$result['imagepath']}" />
                <div>
                    <p>{$result['descriptions']}</p>
                    <small>Image by {$result['author']}</small><br/>

                    <hr/><br/>

                    <section><a class="getnow hoverborderbrown" href="javascript:copyURL();" id="urlCopyButton">URLをコピー</a>
                    <input value="{$result['imagepath']}" readonly id="myURL" /></section>

                    <br/><hr/>

                    <br/><section><a href="javascript:history.back()">戻る</a> | 
                    <a href="{$result['imagepath']}">画像を直接表示する</a> | 
                    <a href="./upload.html">アップロードする</a>
                    </section>
                </div>
            </div>
            __HTML__;

        } else {
            // 全てのデータを取得
            $result = $mysqli->query("SELECT id, imagepath FROM signs ORDER BY id DESC;");

            print <<<__HTML__
            <a class="getnow hoverborderbrown" href="./upload.html" style="text-align: center; display: block; margin: 0 25vw; margin-top: 30px;">アップロードする</a><br/>
            <div class="content">
            __HTML__;

            // カードを出力
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    $printurl = "http://" . $_SERVER['HTTP_HOST'] . rtrim($_SERVER['REQUEST_URI'], "/") . "?id=" . $row['id'];
                    print "<a href=\"{$printurl}\" style=\"background-image: url('{$row['imagepath']}');\"></a>";
                }
            } else {
                print "not found. :(";
            }

            print <<<__HTML__
            </div>
            __HTML__;

        }
        ?>
    <footer>
        <small>
            MarumaSign: Copyright &copy; Marumasa 2023-2024 All right reserved.<br/>
            SignGallery: Copyright &copy; PizzaHarumaki 2024-2024 All right reserved.<br/>
            削除申請はPizzaHarumakiのTwitterDM等へ
        </small>
    </footer>

    <script src="./client.js" async defer></script>
    </body>
</html>
