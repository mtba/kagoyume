<?php
require_once("../util/defineUtil.php");
require_once(SCRIPT);

write_log(SEARCH.'に遷移');

session_start();

$query       = !empty($_GET["query"]) ? $_GET["query"] : "";    //検索ワード
$sort        = !empty($_GET["sort"]) && array_key_exists($_GET["sort"], SORT_ORDER) ? $_GET["sort"] : "-score"; //ソートの種類
$id          = !empty($_GET["category_id"]) ? $_GET["category_id"] : "";
$category_id = ctype_digit($id) && array_key_exists($id, CATEGORIES) ? $id : 1; //カテゴリー
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <title>kagoyume_search</title>
        <link rel="stylesheet" type="text/css" href=<?php echo CSS_COMMON;?>>
    </head>
    <body>
        <header>

            <?php require_once(HEADER_TOP);?>

            <div class='header_under'>
                <form action="<?php echo SEARCH ;?>" class="Search">
                    表示順序：
                    <select name="sort">
                        <?php foreach (SORT_ORDER as $key => $value) { ?>
                            <option value="<?php echo h($key); ?>" <?php if($sort == $key) echo "selected=\"selected\""; ?>><?php echo $value;?></option>
                        <?php } ?>
                    </select>
                    キーワード検索：
                    <select name="category_id">
                        <?php foreach (CATEGORIES as $id => $name) { ?>
                            <option value="<?php echo h($id); ?>" <?php if($category_id == $id) echo "selected=\"selected\""; ?>><?php echo $name;?></option>
                        <?php } ?>
                    </select>
                    <input type="text" name="query" value="<?php echo h($query); ?>"/>
                    <input type="submit" value="Yahooショッピングで検索"/>
                </form>
            </div>
        </header>

        <section class='main'>
            <h2>検索結果</h2>
            <?php
            if ($query != "") { //検索ワードが空でなければ

                // 検索ワード、カテゴリー、ソートパターンを基に商品検索し、結果を取得
                $xml = itemSearch($query, $category_id, $sort);

                ?>

                <p>検索ワード：「<?php echo h($xml->Result->Request->Query).'」で '. h($xml["totalResultsAvailable"]);?>件ヒット</p>

                <?php
                if ($xml["totalResultsReturned"] != 0) {    //検索件数が0件でない場合

                    $hits = $xml->Result->Hit;

                    // 商品情報を表示(20件まで)
                    // 商品詳細ページへのリンクを付加
                    foreach ($hits as $hit) { ?>
                        <div class="Item">
                            <a href="<?php echo ITEM.'?code='.h($hit->Code); ?>">
                                <div class="img"><img src="<?php echo h($hit->Image->Medium); ?>"></div>
                            </a>
                            <div class="data">
                                <a href="<?php echo ITEM.'?code='.h($hit->Code); ?>">
                                    <?php echo h($hit->Name); ?>
                                </a>
                                <p class="price">￥<?php echo number_format( h($hit->Price) );?></p>
                            </div>
                        </div>
                        <?php
                    }
                }
            }else {
                echo "<p>検索結果はありません</p>";
            } ?>
        </section>
    </body>
</html>
