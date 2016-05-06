<?php
require_once("../util/defineUtil.php");
require_once(SCRIPT);

write_log(ADD.'に遷移');

session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <title>kagoyume_add</title>
        <link rel="stylesheet" type="text/css" href=<?php echo CSS_COMMON;?>>
    </head>
    <body>

        <header>
            <?php require_once(HEADER_TOP);?>
            <?php require_once(HEADER_UNDER);?>
        </header>

        <?php
        if( ! chk_transition("from_item") ){

            echo BAD_ACCESS;

        }else{
            // 追加する商品のコードと個数をクッキーに保管する
            // キー名にはユーザーIDを指定(別ユーザーでログインしたときクッキーを保持させないため)
            // ２回目以降は空欄で区切って、あくまで文字列として保管
            if ( !isset($_COOKIE[$_SESSION['user']['userID']]) ) {
                setcookie($_SESSION['user']['userID'],$_POST["code"].'*'.$_POST['num_item']);
            }else {

                if ( strpos($_COOKIE[$_SESSION['user']['userID']],$_POST["code"]) !== false ) {

                    $codes_array = explode(" ", $_COOKIE[$_SESSION['user']['userID']]);

                    foreach ($codes_array as $key => $value) {
                        $code_and_num = explode("*",$value);
                        if ($code_and_num[0]==$_POST["code"]) {
                            $code_and_num[1]+=$_POST['num_item'];
                        }
                        $codes_array[$key] = implode('*', $code_and_num);
                    }
                    $codes_string = implode(" ", $codes_array);

                }else {
                    $codes_string = $_COOKIE[$_SESSION['user']['userID']].' '.$_POST["code"].'*'.$_POST['num_item'];
                }

                setcookie($_SESSION['user']['userID'],$codes_string);
            }

            $hit = hitBy_itemLookup($_POST["code"]); ?>
            <p>「<?php echo h($hit->Name);?>」をカートに追加しました</p>

            <!-- ヘッダーのカート内商品数も更新 -->
            <script type="text/javascript">
                var num_item = <?php echo json_safe_encode($_POST['num_item']); ?>;
                document.getElementById('numGoods').innerHTML =parseInt( document.getElementById('numGoods').innerHTML ) + parseInt(num_item);
            </script>
            <?php
        } ?>
    </body>
</html>
