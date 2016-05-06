<?php
require_once("../util/defineUtil.php");
require_once(SCRIPT);

write_log(REGISTRATION.'に遷移');

session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <title>kagoyume_registration</title>
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
            <h2>新規登録画面</h2>

            <?php
            if( ! chk_transition("from_login") && ! chk_transition("REINPUT") ){

                echo BAD_ACCESS;

            }else {
                ?>
               <form action="<?php echo REGISTRATION_CONFIRM ?>" method="POST">
                   <p>ユーザー名:<input type="text" name="name" value="<?php echo h( form_value('name') ); ?>"></p>
                   <p>パスワード:
                   <input type="text" name="pass" value="<?php echo h( form_value('pass') ); ?>"></p>
                   <p>メールアドレス:
                   <input type="email" name="mail" value="<?php echo h( form_value('mail') ); ?>"></p>
                   <p>住所:
                   <input type="text" name="address" value="<?php echo h( form_value('address') ); ?>"></p>

                   <input type='hidden' name='comeFrom' value=<?php echo h($_POST['comeFrom']);?>>
                   <input type="hidden" name="transition"  value="from_registration">
                   <input type="submit" name="btnSubmit" value="確認画面へ">
               </form>
               <form action="<?php echo LOGIN ?>" method="POST">
                   <input type='hidden' name='comeFrom' value=<?php echo h($_POST['comeFrom']);?>>
                   <input type="hidden" name="in_or_out"  value="ログイン">
                   <input type="submit" name="btnSubmit" value="ログイン画面に戻る">
               </form>
               <?php
           } ?>
        </section>
    </body>
</html>
