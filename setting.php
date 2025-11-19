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
        <div onclick="window.location.href='add_product.php'" class="cls06">
            <img src="image/bill.png" alt="">
            <span>Product In Listed</span>
        </div>
        <div onclick="window.location.href='add_brance.php'" class="cls06">
            <img src="image/bill.png" alt="">
            <span>Branch In Listed</span>
        </div>
        <div onclick="window.location.href='add_customer.php'" class="cls06">
            <img src="image/customerAdd.png" alt="">
            <span>Customer In Listed</span>
        </div>
        <div onclick="window.location.href='add_employee.php'" class="cls06">
            <img src="image/bill.png" alt="">
            <span>Employee In Listed</span>
        </div>
        <div onclick="window.location.href='add_shop.php'" class="cls06">
            <img src="image/bill.png" alt="">
            <span>Shop In Listed</span>
        </div>
        
        
</div>


</div>
</div>
    <script src="script.js"></script>
</body>
</html>