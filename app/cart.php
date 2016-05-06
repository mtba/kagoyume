<?php
require_once("../util/defineUtil.php");
require_once(SCRIPT);

write_log(CART.'に遷移');

session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <title>kagoyume_cart</title>
        <link rel="stylesheet" type="text/css" href=<?php echo CSS_COMMON;?>>
    </head>
    <body>

        <header>
            <?php require_once(HEADER_TOP);?>
            <?php require_once(HEADER_UNDER);?>
        </header>

        <section class="main">
            <?php
            if ( empty($_SESSION['user']) ) {

                echo BAD_ACCESS;

            }else {
                ?>
                <h2>カート内商品</h2>
                <?php
                if ( isset($_COOKIE[$_SESSION['user']['userID']]) ) {

                    $numPrice = 0;   //カート内商品の合計金額を格納する変数
                    $codes_array = explode(" ", $_COOKIE[$_SESSION['user']['userID']]); // クッキー内の商品コード群を分割し、配列に格納

                    // 削除ボタンが押された商品のコードを配列から削除し、再びクッキーに格納する
                    if (isset($_POST['delete']) && $_POST['delete']=='削除') {

                        array_splice($codes_array, $_POST['item_num'], 1);
                        $codes_string = implode(" ", $codes_array);
                        setcookie($_SESSION['user']['userID'],$codes_string);
                        ?>
                        <!-- カート内の商品数も更新 -->
                        <script type="text/javascript">
                            var num_delete = <?php echo json_safe_encode($_POST['delete_num']); ?>;
                            document.getElementById('numGoods').innerHTML =parseInt( document.getElementById('numGoods').innerHTML ) -  num_delete;
                        </script>
                        <?php
                    }

                    // セットクッキーはすぐには反映されないため、配列でカートが空かどうか判定
                    if ( empty($codes_array) ) {

                        echo "<p>カートは空です</p>";

                    }else {
                        ?>
                        <div class="goods">
                            <?php
                            // 商品情報(リンク付き)と削除ボタンを表示
                            foreach ($codes_array as $key => $value) {
                                $code_and_num = explode("*",$value);
                                $hit = hitBy_itemLookup($code_and_num[0]);
                                ?>
                                <div class="Item">
                                    <a href="<?php echo ITEM.'?code='.$code_and_num[0];?>">
                                        <div class="img"><img src="<?php echo $hit->Image->Medium;?>" ></div>
                                    </a>
                                    <div class="data">
                                        <a href="<?php echo ITEM.'?code='.$code_and_num[0];?>">
                                            <?php echo h($hit->Name);?>
                                        </a>
                                        <p class="price">￥<?php echo number_format( h($hit->Price) );?></p>
                                        <p>個数　<?php echo $code_and_num[1];?></p>
                                    </div>
                                    <div class="delete">
                                        <form action="<?php echo CART?>" method="post">
                                            <input type="hidden" name="item_num" value=<?php echo h($key);?>>
                                            <input type="hidden" name="delete_num" value=<?php echo $code_and_num[1];?>>
                                            <input type="submit" name="delete" value="削除">
                                        </form>
                                    </div>
                                </div>
                                <?php
                                $numPrice += $hit->Price * $code_and_num[1];   //商品の値段を合計金額にプラス
                            } ?>
                        </div>


                        <!-- 合計金額と購入ボタン表示
                        合計金額は別のページからも参照できるようセッションに保存 -->
                        <div class="buy">
                            <p>合計金額：<span class="price">￥<?php echo number_format($numPrice);?></span></p>
                            <form action="<?php echo BUY_CONFIRM?>" method="post">
                                <input type="hidden" name="transition" value='from_cart'>
                                <input type="submit" name="buy" value="購入">
                            </form>
                        </div>
                        <?php
                        $_SESSION['numPrice'] = $numPrice;
                    }
                }else {
                    echo "<p>カートは空です</p>";
                }
            }
            ?>
        </section>
    </body>
</html>
