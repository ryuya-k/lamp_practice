<!DOCTYPE html>
<html lang="ja">
  <head>
      <title>購入履歴画面</title>
      <?php include VIEW_PATH . 'templates/head.php'; ?>
  </head>
  <body>
    <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
    <div class="container">
      <h1>履歴一覧</h1>
      <?php include VIEW_PATH . 'templates/messages.php'; ?>

      <?php if(count($carts) > 0){ ?>
      <table class="table table-bordered">
        <thead class="thead-light">
          <tr>
            <th>注文番号</th>
            <th>購入日時</th>
            <th>金額</th>
            <th>購入明細</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($carts as $cart){ ?>
          <tr>
            <td><?php print($cart['order_id']); ?></td>
            <td><?php print date("Y年m月d日 H時i分s秒",strtotime($cart['createdate'])) ; ?></td>
            <td><?php print number_format($cart['sum_total']); ?>円</td>
            <td><a href="<?php print(DETAILS_URL.'?order_id='.$cart['order_id']);?>">購入明細</a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else { ?>
      <p>購入された商品はありません。</p>
    <?php } ?> 
    </div>
  </body>
</html>