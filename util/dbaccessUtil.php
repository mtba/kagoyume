<?php

//DBへの接続を行う。成功ならPDOオブジェクトを、失敗なら中断、メッセージの表示を行う
function connect2MySQL(){
    try{
        //ユーザとパスを変更
        $pdo = new PDO( DB_TYPE.':host='.DB_HOST.';dbname='.DB_DBNAME.
            ';charset='.DB_CHARSET,DB_USER,DB_PWD );
        //SQL実行時のエラーをtry-catchで取得できるように設定
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //とりあえずエミュレートはオフ
        //$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        return $pdo;
    } catch (PDOException $e) {
        die('DB接続に失敗しました。次記のエラーにより処理を中断します:'.$e->getMessage());
    }
}

//レコードの挿入を行う。失敗した場合はエラー文を返却する
function insert_profiles($name, $pass, $mail, $address){
    //db接続を確立
    $insert_db = connect2MySQL();

    //DBに全項目のある1レコードを登録するSQL
    $insert_sql = "INSERT INTO user_t(name,password,mail,address,total,newDate)"
            . "VALUES(:name,:pass,:mail,:address,0,:newDate)";

    //現在時をdatetime型で取得
    $date = now();

    //クエリとして用意
    $insert_query = $insert_db->prepare($insert_sql);

    //SQL文にセッションから受け取った値＆現在時をバインド
    $insert_query->bindValue(':name',$name);
    $insert_query->bindValue(':pass',$pass);
    $insert_query->bindValue(':mail',$mail);
    $insert_query->bindValue(':address',$address);
    $insert_query->bindValue(':newDate',$date);

    //SQLを実行
    try{
        $insert_query->execute();
    } catch (PDOException $e) {
        //接続オブジェクトを初期化することでDB接続を切断
        $insert_db=null;
        return $e->getMessage();
    }

    $insert_db=null;
    return null;
}

function insert_buy($userID, $total, $type){
    //db接続を確立
    $insert_db = connect2MySQL();

    //DBに全項目のある1レコードを登録するSQL
    $insert_sql = "INSERT INTO buy_t(userID,total,type,buyDate)"
            . "VALUES(:userID,:total,:type,:buyDate)";

    //現在時をdatetime型で取得
    $date = now();

    //クエリとして用意
    $insert_query = $insert_db->prepare($insert_sql);

    //SQL文に値をバインド
    $insert_query->bindValue(':userID',$userID);
    $insert_query->bindValue(':total',$total);
    $insert_query->bindValue(':type',$type);
    $insert_query->bindValue(':buyDate',$date);

    //SQLを実行
    try{
        $insert_query->execute();
    } catch (PDOException $e) {
        //接続オブジェクトを初期化することでDB接続を切断
        $insert_db=null;
        return $e->getMessage();
    }

    $insert_db=null;
    return null;
}

function search_profiles($name=null,$pass=null){
    //db接続を確立
    $search_db = connect2MySQL();

    $search_sql = "SELECT * FROM user_t";

    if(!empty($name)){
        $search_sql .= " WHERE name = :name";
        if(!empty($pass)){
            $search_sql .= " AND password = :pass";
        }
    }

    //クエリとして用意
    $seatch_query = $search_db->prepare($search_sql);

    if(!empty($name)){
        $seatch_query->bindValue(':name',$name);
    }
    if(!empty($pass)){
        $seatch_query->bindValue(':pass',$pass);
    }

    //SQLを実行
    try{
        $seatch_query->execute();
    } catch (PDOException $e) {
        $seatch_db=null;
        return $e->getMessage();
    }

    //該当するレコードを連想配列として返却
    return $seatch_query->fetchAll(PDO::FETCH_ASSOC);
}

function update_profile($update_data,$userID){
    //db接続を確立
    $update_db = connect2MySQL();

    //SQL文作成
    $update_sql = "update user_t set";
    foreach ($update_data as $key => $value) {
        $update_sql .= " $key = ?,";
    }
    $update_sql = substr( $update_sql , 0 , strlen($update_sql)-1 );//末尾の,を削除
    $update_sql .= " where userID = ?";

    //クエリとして用意
    $update_query = $update_db->prepare($update_sql);
    $i =1;
    foreach ($update_data as $value) {
        $update_query -> bindValue($i,$value);
        $i++;
    }
    $update_query -> bindValue($i,$userID);
    //SQLを実行
    try{
        $update_query->execute();
    } catch (PDOException $e) {
        $update_db=null;
        return $e->getMessage();
    }
    $update_db=null;
    return null;
}

function delete_profile($id){
    //db接続を確立
    $delete_db = connect2MySQL();

    $delete_sql = "DELETE FROM user_t WHERE userID=:id";

    //クエリとして用意
    $delete_query = $delete_db->prepare($delete_sql);

    $delete_query->bindValue(':id',$id);

    //SQLを実行
    try{
        $delete_query->execute();
    } catch (PDOException $e) {
        $delete_db=null;
        return $e->getMessage();
    }
    $delete_db=null;
    return null;
}
