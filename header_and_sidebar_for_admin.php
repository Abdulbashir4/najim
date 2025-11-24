<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="UTF-8">
  <title>MS Corporation</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="header">
    <div class="logo">
      <img class="pc_logo" src="image/logo.jpg" alt="">
      <div onclick="drawer_menu()" class="phone_logo">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>

<div class="for_body">
  <div class="sidebar">
        <div class="account">
            <img src="image/logo.jpg" alt="">
            <p>MS Corporation</p>
            <hr>
        </div>
        <div class="items">
            <div class="sidebar_button">
                <img src="image/dashbord.png" alt="">
                <span>DashBoard</span>
            </div>
            <div class="sidebar_button" onclick="window.location.href='customer_page.php'">
                <img src="image/user.png" alt="">
                <span>Customer Management</span>
            </div>
            <div class="sidebar_button" onclick="window.location.href='employee_page.php'">
                <img src="image/product.png" alt="">
                <span>Employee Management</span>
            </div>
            <div class="sidebar_button" onclick="window.location.href='product_and_store_page.php'">
                <img src="image/product.png" alt="">
                <span>Product Management</span>
            </div>
            <div class="sidebar_button" onclick="window.location.href='bill_and_invoice_page.php'">
                <img src="image/product.png" alt="">
                <span>Billing and Invoice</span>
            </div>
            <div class="sidebar_button">
                <img src="image/call.png" alt="">
                <span>Payment and Accounts</span>
            </div>
            <div class="sidebar_button">
                <img src="image/call.png" alt="">
                <span>Purchase & Supplier</span>
            </div>
            <div class="sidebar_button" onclick="window.location.href='setting.php'">
                <img src="image/setting.png" alt="">
                <span>Setting</span>
            </div>
            <div class="sidebar_button">
                <img src="image/about.png" alt="">
                <span>About Us</span>
            </div>

        </div>
    </div>
  <div class="for_sidebar" >
    <div class="sidebar_button">
                <img src="image/dashbord.png" alt="">
                <span>DashBoard</span>
    </div>
    <div class="sidebar_button" onclick="window.location.href='customer_page.php'">
                <img src="image/user.png" alt="">
                <span>Customer Management</span>
            </div>
            <div class="sidebar_button" onclick="window.location.href='employee_page.php'">
                <img src="image/employee.png" alt="">
                <span>Employee Management</span>
            </div>
            <div class="sidebar_button" onclick="window.location.href='product_and_store_page.php'">
                <img src="image/product.png" alt="">
                <span>Product Management</span>
            </div>
            <div class="sidebar_button" onclick="window.location.href='bill_and_invoice_page.php'">
                <img src="image/product.png" alt="">
                <span>Billing and Invoice</span>
            </div>
            <div class="sidebar_button" onclick="window.location.href='account_page.php'">
                <img src="image/call.png" alt="">
                <span>Payment and Accounts</span>
            </div>
            <div class="sidebar_button">
                <img src="image/call.png" alt="">
                <span>Purchase & Supplier</span>
            </div>
            <div class="sidebar_button" onclick="window.location.href='setting.php'">
                <img src="image/setting.png" alt="">
                <span>Setting</span>
            </div>
            <div class="sidebar_button">
                <img src="image/about.png" alt="">
                <span>About Us</span>
            </div>
    
    <br>
    <button onclick="loadPage('stock_report.php')">Product Bye</button>
    <button onclick="loadPage('store_view.php')">Store view</button>
    <button onclick="loadPage('coming_soon_product.php')">View Product</button>
  </div>
<script src="script.js"></script>
</body>
</html>
