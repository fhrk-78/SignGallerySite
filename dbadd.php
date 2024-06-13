<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>SignGallery</title>
        <link rel="stylesheet" href="assets/index.css" />
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
        require('./config.php');

        if (isset($_POST["recaptchaResponse"]) && !empty($_POST["recaptchaResponse"]))
        {
            $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secretkey."&response=".$_POST["recaptchaResponse"]);
            $reCAPTCHA = json_decode($verifyResponse);
                if ($reCAPTCHA->success)
                {
                    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname, $dbport);
                    // SQLインジェクション対策()
                    $sqlbefore = $mysqli->prepare("INSERT INTO signs (imagepath, descriptions, author) VALUES (?, ?, ?);");
                    $sqlbefore->bind_param('sss', $_POST['url'], $_POST['descriptions'], $_POST['author']);
                    $sqlbefore->execute();
                    $sqlbefore->close();
                    print "<div class=\"succefy\">登録が完了しました <a href=\"./\">戻る</a></div>";
                }
                else
                {
                    print "認証エラーが発生しました";
                }
            } else {
                print "不明なエラーが発生しました";
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
