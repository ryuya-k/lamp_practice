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

//購入履歴を取得
function get_user_history($db, $user_id,$order_id=null)
{
  $param = [$user_id];
  $sql = "
    SELECT
      history.order_id,
      history.createdate,
      sum(price * amount) as sum_total
    FROM
      history
    JOIN
      details
    ON
      history.order_id = details.order_id
    WHERE
      history.user_id = ?";
  if($order_id !== null){
    $sql.=' and history.order_id=?';
    $param[]=$order_id;
  }    
  $sql.="
    GROUP BY
      history.order_id
    ORDER BY
      order_id DESC
  ";
  return fetch_all_query($db, $sql, $param);
}
function get_admin_history($db,$order_id=null)
{
  $sql = "
    SELECT
      history.order_id,
      history.createdate,
      sum(price * amount) as sum_total
    FROM
      history
    JOIN
      details
    ON
      history.order_id = details.order_id";
  if($order_id !== null){
        $sql.=' and history.order_id=?';
  }    
  $sql.="
    GROUP BY
      history.order_id
    ORDER BY
      order_id DESC
  ";
  return fetch_all_query($db, $sql);
}
function get_details($db,$order_id,$user_id=null)
{
  $param = [$order_id];
  $sql = "
    SELECT
      items.name,
      details.price,
      details.amount,
      details.price * amount as sum_total
    FROM
      details
    JOIN
      items
    ON
      details.item_id = items.item_id
    WHERE
      details.order_id = ?
    ";
    if($user_id !== null){
      $sql.=' and exists(select * from history where order_id = ? and user_id = ?)';
      $param[] = $order_id;
      $param[] = $user_id;
    }
    return fetch_all_query($db,$sql,$param);
}
?>