<?php
session_start();

$selected = $_POST["items"];

$new_cart = array();
$new_cnt = 0;
if (isset($_SESSION["cart"]))
  $new_cart = $_SESSION["cart"];

// Cart info is retained with the item ID.
foreach ($selected as $id => $cnt) {
  if ($cnt == '0') {
    if (isset($new_cart[$id])) {
      unset($new_cart[$id]);
    }
  } else {
    if (!isset($new_cart[$id]) || $new_cart[$id] != $cnt) $new_cnt += 1;
    $new_cart[$id] = $cnt;
  }
}

$_SESSION["cart"] = $new_cart;

header("Location: view_cart.php?new_count=".$new_cnt);
exit();
?>