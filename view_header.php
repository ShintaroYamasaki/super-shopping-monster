<?php
session_start();
$account = '';
if (isset($_SESSION["account"]))
  $account = $_SESSION["account"];
$cart_length = 0;
if (isset($_SESSION["cart"]))
  $cart_length = count($_SESSION["cart"]);
session_commit();
?>
<header style="margin: 0px; padding: 4px;">
  <h1 style="text-align: center;background-color: #fc6a6a;"><a href="index.php"><span style=" color: black; "><i>Super Shopping Monster</i></span></a></h1>
  <?php if ($account !== ''): ?>
  <p style="padding: 3px; background-color:#fff56e;">
    Account name: <strong><?php echo $account; ?></strong><br>
    <a href="view_cart.php">There are <strong><?php echo $cart_length; ?></strong> items in your cart. </a><br>
    <a href="controller_logout.php">Logout</a>
  </p>
  <?php endif; ?>
</header>