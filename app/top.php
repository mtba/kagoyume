<?php
require_once("../util/defineUtil.php");
require_once(SCRIPT);

write_log(TOP.'に遷移');

session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
        <!-- BootstrapのCSS読み込み -->
        <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
        <!-- jQuery読み込み -->
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
        <!-- BootstrapのJS読み込み -->
        <!-- <script src="js/bootstrap.min.js"></script> -->
        <title>kagoyume_top</title>
        <link rel="stylesheet" type="text/css" href=<?php echo CSS_COMMON;?>>
    </head>
    <body>
        <header>
            <?php require_once(HEADER_TOP);?>
            <?php require_once(HEADER_UNDER);?>
        </header>

        <section class='main'>
            <h2>かごいっぱいの夢</h2>
            <p>　ショッピングサイトを使っている時、こんな経験ありませんか？　「あれいいな」「これいいな」「あっ、関連商品のこれもいい」「20%オフセールだって！？　買わなきゃ！」・・・そしていざ『買い物かご』を開いたとき、その合計金額に愕然とします。「こんなに買ってたのか・・・しょうがない。いくつか減らそう・・・」<br>　仕方がありません。無駄遣いは厳禁です。でも、一度買うと決めたものを諦めるなんて、ストレスじゃあありませんか？　できればお金の事なんか考えずに好きなだけ買い物がしたい・・・。このサービスは、そんなフラストレーションを解消するために生まれた『金銭取引が絶対に発生しない』『いくらでも、どんなものでも購入できる(気分になれる)』『ECサイト』です</p>
        </section>
    </body>
</html>
