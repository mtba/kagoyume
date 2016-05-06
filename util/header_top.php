<div class="header_top">
    <div class="title">
        <a href="<?php echo TOP ;?>">かごゆめ</a>
    </div>
    <?php
    if ( empty($_SESSION['user']) ){ ?>
        <div class="right">
            <ul>
                <li>
                    <form action="<?php echo LOGIN;?>" method="POST">
                        <input type='hidden' name='comeFrom' value=<?php echo $_SERVER["REQUEST_URI"];?>>
                        <input type='submit' name='in_or_out' value='ログイン'>
                    </form>
                </li>
            </ul>
        </div>
        <?php
    }else {
        // カート内の個数を変数に保存
        $numGoods = 0;
        if ( !empty($_COOKIE[$_SESSION['user']['userID']]) ){

            $codes_array = explode(" ", $_COOKIE[$_SESSION['user']['userID']]);
            foreach ($codes_array as $value) {
                $code_and_num = explode("*",$value);
                $numGoods += $code_and_num[1];
            }

        } ?>

        <div class="right">
            <ul>
                <li class="user">
                    ようこそ<a href=<?php echo MYDATA?> id="userName"><?php echo h($_SESSION['user']['name'])?></a>さん！
                </li>
                <li class="login">
                    <form action="<?php echo LOGIN;?>" method="POST">
                        <input type='submit' name='in_or_out' value='ログアウト'>
                    </form>
                </li>
                <li class="cart">
                    <a href='<?php echo CART?>'>
                        <img src="../img/cart.png" width="12%" height="8%" alt="cart">
                        <span id="numGoods">
                            <?php echo $numGoods;?>
                        </span>
                        買い物かご
                    </a>
                </li>
            </ul>
        </div>
        <?php
    } ?>
</div>
