<?php
session_start();
if (isset($_SESSION["cart"])) {
  $_SESSION["cart"] = array();
}
session_commit();
header("Location: view_cart.php");
exit();
?>