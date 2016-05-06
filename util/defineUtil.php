<?php
const TOP                   = 'top.php';//トップページ
const SEARCH                = 'search.php';//検索ページ
const ITEM                  = 'item.php';
const ADD                   = 'add.php';
const LOGIN                 = 'login.php';
const REGISTRATION          = 'registration.php';
const REGISTRATION_CONFIRM  = 'registration_confirm.php';
const REGISTRATION_COMPLETE = 'registration_complete.php';
const CART                  = 'cart.php';
const BUY_CONFIRM           = 'buy_confirm.php';
const BUY_COMPLETE          = 'buy_complete.php';
const MYDATA                = 'mydata.php';
const UPDATE                = 'my_update.php';
const UPDATE_RESULT         = 'my_update_result.php';
const DELETE                = 'my_delete.php';
const DELETE_RESULT         = 'my_delete_result.php';

const SCRIPT        = "../util/scriptUtil.php";
const DBACCESS      = "../util/dbaccessUtil.php";
const HEADER_TOP   = "../util/header_top.php";
const HEADER_UNDER = "../util/header_under.php";
const CSS_COMMON = "../util/common.css";

const DB_TYPE     = 'mysql';            //データベースの種類
const DB_HOST     = 'localhost';        //ホスト名
const DB_DBNAME   = 'kagoyume_db';      //データベース名
const DB_CHARSET  = 'utf8';             //文字コード
const DB_USER     = 'root';             //ユーザ
const DB_PWD      = '';                 //パスワード
const DB_TBL_USER = 'user_t';           //テーブル名

const BAD_ACCESS = '<h1>不正なアクセスです</h1>';

const APP_ID = "dj0zaiZpPW11SWltR1EzODZ6MCZzPWNvbnN1bWVyc2VjcmV0Jng9MmE-";//取得したアプリケーションID
const ITEM_SEARCH = "http://shopping.yahooapis.jp/ShoppingWebService/V1/itemSearch";
const ITEM_LOOKUP = "http://shopping.yahooapis.jp/ShoppingWebService/V1/itemLookup";

// 商品カテゴリの一覧
// キーにカテゴリID、値にカテゴリ名が入っている
const CATEGORIES = array(
                    "1" => "すべてのカテゴリから",
                    "13457"=> "ファッション",
                    "2498"=> "食品",
                    "2500"=> "ダイエット、健康",
                    "2501"=> "コスメ、香水",
                    "2502"=> "パソコン、周辺機器",
                    "2504"=> "AV機器、カメラ",
                    "2505"=> "家電",
                    "2506"=> "家具、インテリア",
                    "2507"=> "花、ガーデニング",
                    "2508"=> "キッチン、生活雑貨、日用品",
                    "2503"=> "DIY、工具、文具",
                    "2509"=> "ペット用品、生き物",
                    "2510"=> "楽器、趣味、学習",
                    "2511"=> "ゲーム、おもちゃ",
                    "2497"=> "ベビー、キッズ、マタニティ",
                    "2512"=> "スポーツ",
                    "2513"=> "レジャー、アウトドア",
                    "2514"=> "自転車、車、バイク用品",
                    "2516"=> "CD、音楽ソフト",
                    "2517"=> "DVD、映像ソフト",
                    "10002"=> "本、雑誌、コミック"
                    );

// 検索結果のソート方法の一覧
// キーに検索用パラメータ、値にソート方法が入っている
const SORT_ORDER = array(
                   "-score" => "おすすめ順",
                   "+price" => "商品価格が安い順",
                   "-price" => "商品価格が高い順",
                   "+name" => "ストア名昇順",
                   "-name" => "ストア名降順",
                   "-sold" => "売れ筋順"
                   );
?>
