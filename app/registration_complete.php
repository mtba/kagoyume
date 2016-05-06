<?php
require_once("../util/defineUtil.php");
require_once(SCRIPT);
require_once(DBACCESS);

write_log(REGISTRATION_COMPLETE.'に遷移');

session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <title>kagoyume_complete</title>
        <link rel="stylesheet" type="text/css" href=<?php echo CSS_COMMON;?>>
    </head>
    <body>
        <header>
            <div class="header_top">
                <div class="title">
                    <a href="<?php echo TOP ;?>">かごゆめ</a>
                </div>
            </div>

            <?php require_once(HEADER_UNDER);?>
        </header>

        <section class='main'>

            <?php
            if( ! chk_transition("from_confirm") ){

                echo BAD_ACCESS;

            }else {
                $name     = $_SESSION['name'];
                $pass     = $_SESSION['pass'];
                $mail     = $_SESSION['mail'];
                $address  = $_SESSION['address'];

                session_unset();

                //データのDB挿入処理。エラーの場合のみエラー文がセットされる。成功すればnull
                $result = insert_profiles($name, $pass, $mail, $address);

                //エラーが発生しなければログを残し表示を行う
                if(!isset($result)){

                    write_log($name.'が新規会員登録');

                     ?>
                     <h2>登録結果画面</h2>
                     <p>ユーザー名:    <?php echo $name;?></p>
                     <p>パスワード:    <?php echo $pass;?></p>
                     <p>メールアドレス:<?php echo $mail;?></p>
                     <p>住所:          <?php echo $address;?></p>
                     <p>以上の内容で登録しました。</p>

                     <form action="<?php echo LOGIN ?>" method="POST">
                         <input type='hidden' name='comeFrom' value=<?php echo $_POST['comeFrom'];?>>
                         <input type="hidden" name="in_or_out" value="ログイン" >
                         <input type="submit" name="backToLogin" value="ログイン画面に戻る">
                     </form>
                     <a href=<?php echo TOP;?>>トップへ戻る</a>
                    <?php
                }else {

                    echo 'データの挿入に失敗しました。次記のエラーにより処理を中断します:'.$result;

                }
            } ?>

        </section>
    </body>
</html>
