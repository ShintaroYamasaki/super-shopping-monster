<?php
// if Session has login info, then go to shopping items page
session_start();
if (isset($_SESSION["account"])) {
  header("Location: view_items.php");
  exit();
}
session_commit();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>Login | Super Shopping Monster</title>
</head>
<body>
<?php include 'view_header.php'; ?>
<h1>Welcome!!</h1>
<div id="login_msg">
  <?php if (isset($_GET["incorrect"])) echo "Incorrect"; ?>
  <?php if (isset($_GET["session_destroied"])) echo "Session has been destroied."; ?>
  <?php if (isset($_GET["logout"])) echo "Logout"; ?>
</div>
<form action="controller_confirm_login.php" method="POST">
  Please login with your account.<br>
  <table>
    <tr><td><strong>Account Name: </strong></td><th><input type="text" name="user_name" /></th></tr>
    <tr><td><strong>Account Password: </strong></td><th><input type="password" name="user_password" /></th></tr>
  </table>
  <button type="submit" name="action">login</button>
</form>
</body>
</html>