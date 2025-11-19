<?php include'server_connection.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MS Corporation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header_and_sidebar_for_admin.php'; ?>
    <div class="main">
    <div class="for_content" id="contentArea">
<div class="cls05">
        <div onclick="window.location.href='add_payment.php'" class="cls06">
            <img src="image/bill.png" alt="">
            <span>Add Payment</span>
        </div>
        <div onclick="window.location.href='product_sale.php'" class="cls06">
            <img src="image/bill.png" alt="">
            <span>Product Sale</span>
        </div>
        <div onclick="window.location.href='products.php'" class="cls06">
            <img src="image/bill.png" alt="">
            <span>Store</span>
        </div>
        <div onclick="loadPage('view_shop.php')" class="cls06">
            <img src="image/bill.png" alt="">
            <span>Store Manager</span>
        </div>
        <div onclick="window.location.href='product_bye.php'" class="cls06">
            <img src="image/bill.png" alt="">
            <span>Bye Product</span>
        </div>
        
        
    </div>

</div>
</div>
    <script src="script.js"></script>
</body>
</html>