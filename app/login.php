<?php
require_once("../util/defineUtil.php");
require_once(SCRIPT);
require_once(DBACCESS);

write_log(LOGIN.'に遷移');

session_start();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <title>kagoyume_login</title>
        <link rel="stylesheet" type="text/css" href=<?php echo CSS_COMMON;?>>
    </head>
    <body>
        <header>
            <div class='header_top'>
                <div class="title">
                    <a href="<?php echo TOP ;?>">かごゆめ</a>
                </div>
                <div class="right">
                    <?php
                    if ( !empty($_SESSION['user']) ){ ?>
                        <ul>
                            <li><?php echo 'さようなら'.h($_SESSION['user']['name']).'さん！'?></li>
                        </ul>
                        <?php
                    } ?>
                </div>
            </div>

            <?php require_once(HEADER_UNDER);?>

        </header>

        <section class='main'>
            <?php

            // ログインボタンを押してこのページに遷移してきた場合
            if (isset($_POST["in_or_out"]) && $_POST["in_or_out"]=='ログイン') { ?>

                <h2>ログイン画面</h2>

                <?php
                $name = isset($_POST['name']) ? $_POST['name'] : '';    //ユーザ名
                $pass = isset($_POST['pass']) ? $_POST['pass'] : '';    //パスワード

                if (empty($name) && empty($pass)) {

                    echo "<p>ユーザー名とパスワードを入力してください</p>";

                }else {

                    $result = search_profiles($name,$pass);  //DBからユーザ名、パスワードでAND検索

                    //DBでエラーが発生したらエラー文を表示
                    if( ! is_array($result) ){

                        echo "<p>データの検索に失敗しました:".$result."</p>";

                    }else{
                        // 入力したユーザ名とパスワードがＤＢのものと一致すれば、
                        // ユーザーデータをセッションに保管し、もといたページに飛ぶ
                        if ( !empty($result) ) {
                            $_SESSION['user'] = $result[0];
                            echo "<h3>ログイン成功</h3>";
                            echo '<meta http-equiv="refresh" content="0.5;URL='.$_POST['comeFrom'].'">';
                            exit;
                        }

                        echo "<p>ユーザー名またはパスワードが異なります。もう一度入力してください</p>";
                    }
                }
                ?>
               <form action="<?php echo LOGIN ;?>" method="POST">
                   <p>ユーザー名：<input type="text" name="name" value=<?php echo $name;?>></p>
                   <p>パスワード：<input type="password" name="pass" value=<?php echo $pass;?>></p>
                   <input type='hidden' name='comeFrom' value=<?php echo $_POST['comeFrom'];?>>
                   <input type="submit" name='in_or_out' value="ログイン">
               </form>
               <form action="<?php echo REGISTRATION ;?>" method="POST">
                   <input type='hidden' name='comeFrom' value=<?php echo $_POST['comeFrom'];?>>
                   <input type='hidden' name='transition' value='from_login'>
                   <input type="submit" name='new' value="新規会員登録">
               </form>
               <?php

            // ログアウトボタンを押してこのページに遷移してきた場合
            }elseif (isset($_POST["in_or_out"]) && $_POST["in_or_out"]=='ログアウト') {

                logout() ?>

                <h2>ログアウト画面</h2>
                <p>ログアウトしました。３秒後にトップページへ移動します</p>

                <?php
                echo '<meta http-equiv="refresh" content="3;URL='.TOP.'?mode=timeout">';

            }else {

                echo BAD_ACCESS;

            } ?>
        </section>
    </body>
</html>
