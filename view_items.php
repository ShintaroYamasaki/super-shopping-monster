<?php
session_start();
if (!isset($_SESSION["account"])) {
  header("Location: view_login_form.php?session_destroied");
  exit();
}

$account = $_SESSION["account"];

require "dto.php";
$items_dto = new ItemsDTO();
$str_keywords = '';
if (isset($_GET["search"])) {
  $str_keywords = $_GET["search"];
  $keywords = explode(" ", $str_keywords);
  $rst = $items_dto->select_items($keywords);
} else {
  $rst = $items_dto->select_items(array());
}

$cart = array();
if (isset($_SESSION["cart"])) {
  $cart = $_SESSION["cart"];
}
// echo "<pre>";
// print_r($rst);
// echo "</pre>";
session_commit();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>Items | Super Shopping Monster</title>
</head>
<body>
<?php include 'view_header.php'; ?>
<h1>Items</h1>
<form action="view_items.php" method="GET">
  <input type="text" name="search" />
  <button type="submit">search</button>
</form>
<hr>
<?php if ($str_keywords != ''): ?>
<p>
  Search keyword: <?php echo $str_keywords; ?>
</p>
<?php endif; ?>
<?php if (count($rst) == 0): ?>
<div id="Not found">
Not found. Please research.
</div>
<?php else : ?>
<form action="controller_confirm_items.php" method="POST">
  <table border="1">
    <tr><th>Name</th><th>Price</th><th>Category</th><th>Purchase count</th></tr>
    <?php foreach ($rst as $item):?>
    <tr><th><?php echo $item['name']; ?></th><th><?php echo $item['price']; ?></th><th><?php echo $item['category']; ?></th>
      <th>
        <select name="items[<?php echo $item['id']; ?>]">
          <?php for ($i = 0; $i <= 10; $i++): ?>
            <option value="<?php echo $i; ?>" <?php if (isset($cart[$item['id']]) && $cart[$item['id']] == $i) echo "selected"; ?>><?php echo $i; ?></option>
          <?php endfor; ?>
        </select>
      </th>
    </tr>
    <?php endforeach; ?>
  </table>
  <hr>
  <button type="submit">Update cart</button>
</form>
<?php endif; ?>
</body>
</html>
