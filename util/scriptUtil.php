<?php
// 特殊文字を HTML エンティティに変換する関数
function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

//ログアウト処理
function logout(){
    session_unset();
    if (isset($_COOKIE['PHPSESSID'])) {
        setcookie('PHPSESSID', '', time() - 1800, '/');
    }
    session_destroy();
}

// 商品検索APIでの検索結果を返す
function itemSearch($query, $category_id, $sort){
    $query4url = rawurlencode($query);
    $sort4url  = rawurlencode($sort);

    $url = ITEM_SEARCH.
        "?appid=".APP_ID.
        "&query=$query4url&category_id=$category_id&sort=$sort4url";

    $xml = simplexml_load_file($url);
    return $xml;
}

// 商品コード検索APIでの検索結果を返す
// 返り値はHITオブジェクトまで絞る
function hitBy_itemLookup($code){

    $url = ITEM_LOOKUP.
        "?appid=".APP_ID.
        "&itemcode=$code&responsegroup=large&image_size=300";

    $xml = simplexml_load_file($url);

    if ($xml["totalResultsReturned"] != 0) {
        return $xml->Result->Hit;
    }
    return null;
}

/**
 * 前の画面からボタンを押して遷移してきたかどうかを判定
 * 不正アクセス処理用
 * @param type $value 前ページから送られるhiddenデータ
 * @return type
 */
function chk_transition($value){
    if (isset($_POST['transition']) && $_POST['transition']==$value) {
        return TRUE;
    }
    return FALSE;
}

/**
 * フォームの再入力時に、すでにセッションに対応した値があるときはその値を返却する
 * @param type $name formのname属性
 * @return type セッションに入力されていた値
 */
function form_value($name){
    if(chk_transition('REINPUT')){
        if(isset($_SESSION[$name])){
            $result = $_SESSION[$name];
            $_SESSION[$name] = null;    //セッション破棄
            return $result;
        }
    }
}

/**
 * ポストからセッションに存在チェックしてから値を渡す。
 * 二回目以降のアクセス用に、ポストから値の上書きがされない該当セッションは初期化する
 * @param type $name
 * @return type
 */
function bind_p2s($name){
    if(!empty($_POST[$name])){
        $_SESSION[$name] = h($_POST[$name]);
        return h($_POST[$name]);
    }else{
        $_SESSION[$name] = null;
        return null;
    }
}

/**
 * 現在時をdatetime型で取得し返す
 * @param type
 * @return type datetime型の現在時
 */
function now(){
    $datetime =new DateTime();
    $date = $datetime->format('Y-m-d H:i:s');
    return $date;
}

// PHPの変数をJSで使えるようにする関数
function json_safe_encode($data){
    return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}

/**
 * ページ遷移、新規登録、商品購入のログをログファイルに追記する
 * @param type $info log.txtに書き込む情報
 * @return type
 */
function write_log($info){
    $fp = fopen('../logs/log.txt','a');
    fwrite( $fp,$info.'　'.date('Y年n月j日 G時i分s秒')."\r\n" );
    fclose($fp);
}
