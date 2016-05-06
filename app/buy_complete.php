<?php
require_once("../util/defineUtil.php");
require_once(SCRIPT);
require_once(DBACCESS);

write_log(BUY_COMPLETE.'に遷移');

session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <title>kagoyume_buy_complete</title>
        <link rel="stylesheet" type="text/css" href=<?php echo CSS_COMMON;?>>
    </head>
    <body>
        <header>
            <?php require_once(HEADER_TOP);?>
            <?php require_once(HEADER_UNDER);?>
        </header>

        <?php
        if( ! chk_transition("from_confirm") ){

            echo BAD_ACCESS;

        }else {
            $userID = $_SESSION['user']['userID'];
            $numPrice  = $_SESSION['numPrice'];
            $type   = $_POST['type'];

            $result_insert = insert_buy($userID,$numPrice,$type);

            //インサートでエラーが発生しなければ
            if(!isset($result_insert)){
                // ユーザーテーブルの総購入金額を更新
                 $update_value = array(
                    'total' => $_SESSION['user']['total'] + $numPrice
                );

                $result_update = update_profile( $update_value, $userID );

                //更新でエラーが発生しなければ
                if(!isset($result_update)){

                    echo '<h2>購入が完了しました</h2>';
                    $_SESSION['user']['total'] += $numPrice; //セッション内の総額データも更新
                    setcookie($_SESSION['user']['userID'], '', time() - 1800);  //カートを空にする
                    $_SESSION['numPrice'] = null;   //使い終えたセッションを削除

                    write_log($_SESSION['user']['name'].'が商品購入');
                    ?>
                    <!-- カート内の商品数も更新 -->
                    <script type="text/javascript">
                        document.getElementById('numGoods').innerHTML = 0;
                    </script>
                    <?php
                }else{
                    echo '<p>データの検索に失敗しました。次記のエラーにより処理を中断します:'.$result_update.'</p>';
                }
            }else {

                echo 'データの挿入に失敗しました。次記のエラーにより処理を中断します:'.$result_insert;

            }
        }
         ?>
    </body>
</html>
