<?php
session_start();
$action = $_POST["action"];
if ($action == "settle") {
  $_SESSION["cart"] = array();
  header("Location: view_thanks.php");
} else {
  header("Location: view_items.php");
}

exit();
?>