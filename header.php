<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header start here -->
 <div class="header">
    <div class="menu" onclick="drawer_menu()">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div class="title">
        <marquee behavior="" direction="">MS Corporation</marquee>
    </div>
 </div>
<!-- Header end here -->

<!-- Drawer start here  -->
<div class="drawer" id="drawer" >
    <div class="account">
        <img src="image/logo.png">
        <h1>MS Corporation</h1>
    </div>
    <hr>
    <div class="button">
    <a class="dr_btn" href="user.php" >add customer</a>
    <a class="dr_btn" onclick="showPage('add_sale_page')" >add sale</a>
    <a class="dr_btn" onclick="showPage('home_page')" href="add_installment.php" >History</a>
    <a class="dr_btn" onclick="showPage('home_page')" href="add_employee.php" >Add Employee</a>
    <a class="dr_btn" onclick="showPage('home_page')" href="add_installment_payment.php" >Add payment</a>
    <a class="dr_btn" onclick="showPage('home_page')"  href="desbord.php">DashBoard</a>
    <a class="dr_btn" onclick="showPage('home_page')"  href="customer.php">Customer</a>
    <a class="dr_btn" onclick="showContent('Entry_page')" >Add Entry</a>
    <a class="dr_btn" onclick="showPage('home_page')"  href="desbord.php">Us Employee</a>
    <a class="dr_btn" onclick="showPage('home_page')"  href="logout.php">LogOut</a>
    </div>

</div>
<!-- Drawer end here  -->
<script src="script.js"></script>
</body>
</html>
