<?php
session_start();
if (!isset($_SESSION["account"])) {
  header("Location: view_login_form.php?session_destroied");
  exit();
}

$new_cnt = 0;
if (isset($_GET["new_count"])) {
  $new_cnt = (int) $_GET["new_count"];
}

$cart = array();
if (isset($_SESSION["cart"])) {
  $cart = $_SESSION["cart"];
}

require "dto.php";
$items_dto = new ItemsDTO();
$cart_items = $items_dto->select_items_w_ids(array_keys($cart));

// echo "<pre>";
// print_r($cart);
// echo "</pre>";

// echo "<pre>";
// print_r($cart_items);
// echo "</pre>";
session_commit();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>Shopping Cart | Super Shopping Monster</title>
</head>
<body>
<?php include 'view_header.php'; ?>
<h1>Cart</h1>

<?php if ($new_cnt > 0): ?>
<div id="msg">
  <?php echo $new_cnt ?> new items has been added to your cart.
</div>
<?php endif; ?>

<?php if (count($cart) == 0): ?>
No item in your cart.
<?php else: ?>
<?php $total = 0; ?>
<table border="1">
  <tr><th>Name</th><th>Price</th><th>Count</th><th>Subtotal</th></tr>
  <?php foreach($cart_items as $item): ?>
  <?php $cnt = (int)$cart[$item['id']]; $subtotal = (int)$item['price'] * $cnt; $total += $subtotal; ?>
  <tr><th><?php echo $item['name']; ?></th><th><?php echo $item['price']; ?></th><th><?php echo $cnt; ?></th><th><?php echo $subtotal; ?></th></tr>
  <?php endforeach; ?>
</table>
<form action="controller_empty_cart.php">
  <button type="submit">empty</button>
</form>
<hr>
<strong>Total: &yen; <?php echo $total; ?></strong>
<?php endif; ?>

<form action="controller_confirm_purchase.php" method="POST">
  <?php if (count($cart) > 0): ?>
  <button type="submit" name="action" value="settle">Purchase</button><br>
  <?php endif; ?>
  <button type="submit" name="action" value="back">Continue shopping</button>
</form>
</body>
</html>