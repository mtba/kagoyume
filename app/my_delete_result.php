<?php
require_once("../util/defineUtil.php");
require_once(SCRIPT);
require_once(DBACCESS);

write_log(DELETE_RESULT.'に遷移');

session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <title>kagoyume_delete_result</title>
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
            if( ! chk_transition("to_delete_result") || empty($_SESSION['user']) ){

                echo BAD_ACCESS;

            }else {

                $result_delete = delete_profile($_SESSION['user']['userID']);

                if(!isset($result_delete)){ //エラーが発生しなければ

                    echo '<h2>データの削除が完了しました</h2>';
                    // クッキーとセッション破壊
                    if ( isset($_COOKIE[$_SESSION['user']['userID']]) ) {
                        setcookie($_SESSION['user']['userID'], '', time() - 1800);
                    }
                    logout();
                }else{
                    echo '<p>データの削除に失敗しました。次記のエラーにより処理を中断します:'.$result_delete.'</p>';
                }
            }
            ?>
        </section>
    </body>
</html>
