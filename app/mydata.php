<?php
require_once("../util/defineUtil.php");
require_once(SCRIPT);

write_log(MYDATA.'に遷移');

session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <title>kagoyume_mydata</title>
        <link rel="stylesheet" type="text/css" href=<?php echo CSS_COMMON;?>>
    </head>
    <body>
        <header>
            <?php require_once(HEADER_TOP);?>
            <?php require_once(HEADER_UNDER);?>
        </header>

        <section class='main'>
            <?php
            if ( empty($_SESSION['user']) ) {

                echo BAD_ACCESS;

            }else {

                $user = $_SESSION['user'];

                ?>
                <h2>ユーザー情報</h2>
                <p>ユーザー名：<?php echo h($user['name']);?></p>
                <p>パスワード：<?php echo h($user['password']);?></p>
                <p>メールアドレス：<?php echo h($user['mail']);?></p>
                <p>住所：<?php echo h($user['address']);?></p>
                <p>総購入金額：￥<?php echo h($user['total']);?></p>
                <p>登録日時：<?php echo h( date('Y年n月j日　G時i分s秒', strtotime($user['newDate'])) );?></p>

                <form action="<?php echo UPDATE?>" method="post">
                    <input type="hidden" name="transition" value='to_update'>
                    <input type="submit" name="update" value="更新">
                </form>
                <form action="<?php echo DELETE?>" method="post">
                    <input type="hidden" name="transition" value='to_delete'>
                    <input type="submit" name="update" value="削除">
                </form>
                <?php
            } ?>
        </section>
    </body>
</html>
