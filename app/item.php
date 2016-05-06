<?php
require_once("../util/defineUtil.php");
require_once(SCRIPT);

write_log(ITEM.'に遷移');

session_start();

$code = !empty($_GET["code"]) ? $_GET["code"] : ""; //商品コード
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <title>kagoyume_item</title>
        <link rel="stylesheet" type="text/css" href=<?php echo CSS_COMMON;?>>
    </head>
    <body>
        <header>
            <?php require_once(HEADER_TOP);?>
            <?php require_once(HEADER_UNDER);?>
        </header>

        <section class="main">
            <h2>商品詳細</h2>
            <?php

            if ($code != "") {

                // 商品コードを基に検索し、その商品の詳細情報を取得
                $hit = hitBy_itemLookup($code);

                if ($hit != null) {?>
                    <div class="Item_detail">
                        <div class="img">
                            <img src="<?php echo h($hit->ExImage->Url);?>" />
                        </div>
                        <div class="data">
                            <p><?php echo h($hit->Name);?></p>
                            <p class="price">￥<?php echo number_format( h($hit->Price) );?></p>
                            <p>評価：<?php echo h($hit->Store->Ratings->Rate);?></p>
                            <p><?php echo h($hit->Headline);?></p>
                        </div>

                        <?php
                        // ログインしているならカートに追加ボタン表示
                        if ( !empty($_SESSION['user']) ){ ?>
                            <div class="add">
                                <form action="<?php echo ADD;?>" method="POST">
                                    個数
                                    <select name='num_item'>
                                        <?php
                                        for ($i=1; $i <= 9; $i++) {
                                            echo "<option value='$i'>$i</option>";
                                        }
                                        ?>
                                    </select>
                                    <br>
                                    <input type='hidden' name='code' value=<?php echo $code;?>>
                                    <input type='hidden' name='transition' value='from_item'>
                                    <input type='submit' value='カートに追加する'>
                                </form>
                            </div>
                            <?php
                        } ?>
                    </div>
                    <p><?php echo $hit->Description;?></p>
                    <?php
                }else {
                    echo "<p>その商品コードは存在しません</p>";
                }
                ?>

                <?php
            }else{
                echo "<p>商品コードが未指定です</p>";
            } ?>
        </section>
    </body>
</html>
