<?php
$user_name = $_POST["user_name"];
$user_password = $_POST["user_password"];

require 'dto.php';

$account_dto = new AccountsDTO();

$rst = $account_dto->confirm_login($user_name, $user_password);

if ($rst == false) {
  header("Location: view_login_form.php?incorrect");
  exit();
}

session_start();
$_SESSION["account"] = $user_name;

header("Location: view_items.php");
exit();
?>