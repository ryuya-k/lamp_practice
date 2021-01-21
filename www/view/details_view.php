<!DOCTYPE html>
<html lang="ja">
  <head>
      <title>購入詳細画面</title>
      <?php include VIEW_PATH . 'templates/head.php'; ?>
      <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'cart.css'); ?>">
  </head>
  <body>
    <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <div class="container">
      <h1>詳細一覧</h1>
      <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>注文番号</th>
                <th>日時</th>
                <th>合計</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($header as $key){ ?>
            <tr>
                <td><?php print($key['order_id']); ?></td>
                <td><?php print date("Y年m月d日 H時i分s秒",strtotime($key['createdate'])) ; ?></td>
                <td><?php print number_format(($key['sum_total'])); ?>円</td>
            </tr>
            <?php } ?>
        </tbody>
        </table>
      <table class="table table-bordered">
        <thead class="thead-light">
          <tr>
            <th>商品名</th>
            <th>購入時の価格</th>
            <th>購入数</th>
            <th>小計</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($carts as $cart){ ?>
          <tr>
            <td><?php print($cart['name']); ?></td>
            <td><?php print date($cart['price']) ; ?>円</td>
            <td><?php print ($cart['amount']); ?></td>
            <td><?php print number_format($cart['sum_total']); ?>円</td>
          </tr>
          <?php } ?>
        </tbody>
      </table>

    </div>
  </body>
</html>