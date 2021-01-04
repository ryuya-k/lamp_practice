<?php

function add_history_query($db,$user_id){
  $sql = "
    INSERT INTO
      history(
        user_id,
        createdate    
      )
    VALUES(?,now());
    ";

  return execute_query($db,$sql,[$user_id]);
}

function add_details_query($db,$item_id,$price,$amount,$order_id){
  $sql = "
    INSERT INTO
      details(
        item_id,
        price,
        amount,
        order_id
      )
    VALUES(?,?,?,?);
    ";
  return execute_query($db,$sql,[$item_id,$price,$amount,$order_id]);
}

function create_history($db,$carts){
  if(add_history_query($db,$carts[0]['user_id'])===false){
    set_error('履歴テーブルの作成に失敗しました。');
    return false;
  }
  //order_idを取得
  $order_id = $db -> lastInsertID();
  //foreachを使ってadd_details_queryを実行
  foreach($carts as $cart){
    if(add_details_query(
      $db,
      $cart['item_id'],
      $cart['price'],
      $cart['amount'],
      $order_id
      ) === false){
    set_error('購入詳細テーブルの作成に失敗しました。');
    return false;
    }
  }
}
?>