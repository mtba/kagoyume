<?php
require_once("../util/defineUtil.php");
require_once(SCRIPT);
require_once(DBACCESS);

write_log(REGISTRATION_CONFIRM.'に遷移');

session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <title>kagoyume_registration_confirm</title>
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
            if( ! chk_transition("from_registration") ){

                echo BAD_ACCESS;

            }else {
                //ポストの存在チェックとセッションに値を格納しつつ、連想配列にポストされた値を格納
                $confirm_values = array(
                    'name'    => bind_p2s('name'),
                    'pass'    => bind_p2s('pass'),
                    'mail'    => bind_p2s('mail'),
                    'address' => bind_p2s('address')
                );

                //1つでも未入力項目があったら登録不可
                if(!in_array(null,$confirm_values, true)){

                    $result = search_profiles($confirm_values['name']);  //DBから入力したユーザ名で検索

                    if( ! is_array($result) ){

                        echo "<p>データの検索に失敗しました:".$result."</p>";

                    }else{
                        if ( !empty($result) ) {
                            echo "<h2>そのユーザー名は既に使われています</h2><p>再度入力を行ってください</p>";
                        }else {
                            ?>
                            <h2>登録確認画面</h2>
                            <p>ユーザー名:    <?php echo $confirm_values['name'];?></p>
                            <p>パスワード:    <?php echo $confirm_values['pass'];?></p>
                            <p>メールアドレス:<?php echo $confirm_values['mail'];?></p>
                            <p>住所:          <?php echo $confirm_values['address'];?></p>

                            <p>上記の内容で登録します。よろしいですか？</p>

                            <form action="<?php echo REGISTRATION_COMPLETE ?>" method="POST">
                                <input type='hidden' name='comeFrom' value=<?php echo h($_POST['comeFrom']);?>>
                                <input type="hidden" name="transition" value="from_confirm" >
                                <input type="submit" name="yes" value="はい">
                            </form>
                            <?php
                        }
                    }

                }else {

                    echo '<h2>入力項目が不完全です</h2><p>再度入力を行ってください</p>';
                    echo '<h3>不完全な項目</h3>';

                    //連想配列内の未入力項目を検出して表示
                    foreach ($confirm_values as $key => $value){
                        if($value == null){
                            if($key == 'name'){
                                echo '<p>ユーザー名';
                            }
                            if($key == 'pass'){
                                echo '<p>パスワード';
                            }
                            if($key == 'mail'){
                                echo '<p>メールアドレス';
                            }
                            if($key == 'address'){
                                echo '<p>住所';
                            }
                            echo 'が未記入です</p>';
                        }
                    }
                }
                ?>
                <form action="<?php echo REGISTRATION ?>" method="POST">
                    <input type='hidden' name='comeFrom' value=<?php echo h($_POST['comeFrom']);?>>
                    <input type="hidden" name="transition" value="REINPUT" >
                    <input type="submit" name="no" value="登録画面に戻る">
                </form>
                <?php
           } ?>
        </section>
    </body>
</html>
