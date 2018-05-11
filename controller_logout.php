<?php
session_start();

if (isset($_SESSION["account"]))
  unset($_SESSION["account"]);
if (isset($_SESSION["cart"]))
  unset($_SESSION["cart"]);

header("Location: view_login_form.php?logout");
exit();
?>