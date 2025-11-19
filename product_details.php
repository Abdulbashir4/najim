<?php
include 'server_connection.php';

$id = intval($_GET['id']);
$sql = "SELECT * FROM products WHERE product_id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$shop_sql = "SELECT shop_name FROM product_and_shop WHERE products_name='" . $row['product_name'] . "'";
$shop_result = $conn->query($shop_sql);
$shop = $shop_result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <title><?= $row['product_name'] ?> - ডিটেইলস</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php
include 'header_for_customer_page.php'; ?>

  <div class="box">
    <div class="pdct_img">
     <img class="pdct_imgage" src="<?= $row['product_image'] ?>" alt="<?= $row['product_name'] ?>">
    </div>
    <div class="pdct_detail">
   <p>Name : <?= $row['product_name'] ?></p>
   <p>Model : <?= $row['model']?></p>
   <p>Brand :<?= $row['brand']?> </p>
   <p class="txt">Stock Quantity :- <?= $row['qty'] ?></p>
   <p class="txt">Price :- <?= $row['price'] ?> TK</p>
   <p class="txt">Shop Name :- <?= $shop ? $shop['shop_name'] : 'Not Found' ?> </p>
    <div class="desc txt"> description :-<?= nl2br($row['description']) ?></div>
    </div>
  </div>

</body>
</html>
<?php $conn->close(); ?>
