<?php
require_once("../util/defineUtil.php");
require_once(SCRIPT);
require_once(DBACCESS);

write_log(UPDATE_RESULT.'に遷移');

session_start();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <title>kagoyume_update_result</title>
        <link rel="stylesheet" type="text/css" href=<?php echo CSS_COMMON;?>>
    </head>
    <body>
        <header>
            <?php require_once(HEADER_TOP);?>
            <?php require_once(HEADER_UNDER);?>
        </header>

        <section class='main'>
            <?php
            if( ! chk_transition("to_update_result") ){

                echo BAD_ACCESS;

            }else {
                if ( !empty($_POST['name']) && $_POST['name']!=$_SESSION['user']['name']){

                    $result = search_profiles($_POST['name']);  //DBから入力したユーザ名で検索

                    if( ! is_array($result) ){

                        echo "<p>データの検索に失敗しました:".$result."</p>";

                    }else{
                        if ( !empty($result) ) {
                            echo "<h2>そのユーザー名は既に使われています</h2><p>再度入力を行ってください</p>";
                            ?>
                            <form action="<?php echo UPDATE?>" method="post">
                                <input type="hidden" name="transition" value='to_update'>
                                <input type="submit" name="update" value="更新ページへ戻る">
                            </form>
                            <?php
                            exit;
                        }
                    }
                }


                $update_values = array();   //更新したい項目と更新後の値を格納する配列

                //入力したデータで空でないものを配列にまとめる
                foreach ($_POST as $key => $value) {
                    if ( !empty($_POST[$key]) && $key!='transition' && $key!='btnSubmit') {
                        $update_values[$key] = $value;
                    }
                }

                if (empty($update_values)) {    //入力項目がすべて空のとき
                    // 何も変わってないが
                    echo '<h2>データの更新が完了しました</h2>';

                }else {

                    $result_update = update_profile( $update_values,$_SESSION['user']['userID'] );

                    //エラーが発生しなければ
                    if(!isset($result_update)){

                        echo '<h2>データの更新が完了しました</h2>';

                        foreach ($update_values as $key => $value) {
                            $_SESSION['user'][$key] = $value; //セッション内のデータも更新
                        } ?>

                        <!-- ようこそ○○さん！の○○も更新 -->
                        <script type="text/javascript">
                            var userName = <?php echo json_safe_encode($_SESSION['user']['name']); ?>;
                            document.getElementById('userName').innerHTML = userName;
                        </script>

                        <?php
                    }else{
                        echo '<p>データの更新に失敗しました。次記のエラーにより処理を中断します:'.$result_update.'</p>';
                    }
                }
            }
            ?>
        </section>
    </body>
</html>
