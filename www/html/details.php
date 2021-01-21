<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';
require_once MODEL_PATH . 'history.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);
$order_id = get_get('order_id');
//購入詳細処理
if(is_admin($user)){
    $carts = get_details($db, $order_id);
    $header = get_admin_history($db,$order_id);
}else{
    $carts = get_details($db, $order_id,$user['user_id']);
    $header = get_user_history($db,$user['user_id'],$order_id);
    
}
$token = get_csrf_token();

include_once VIEW_PATH . 'details_view.php';