<?php
require_once 'auth.php';
require_login();
include 'server_connection.php'; // DB connection include করতে ভুল না করো

// ================== INSERT CUSTOMER ==================
if (isset($_POST['save_customer'])) {
    $name = $_POST['name'];
    $contact = $_POST['contact_person'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "INSERT INTO customers (name, contact_person, phone, address) 
            VALUES ('$name', '$contact', '$phone', '$address')";
    if ($conn->query($sql)) {
        $message = '<p class="alart">Customer Added Successfully</p>';
    } else {
        $message = "Error: " . $conn->error;
    }
}

// ================== INSERT SALE ==================
if (isset($_POST['save_sale'])) {
    $customer_id = $_POST['customer_id'];
    $machine_name = $_POST['machine_name'];
    $sale_amount = $_POST['sale_amount'];
    $paid_amount = $_POST['paid_amount'];
    $installment_count = $_POST['installment_count'];
    $desc = $_POST['description'];

    // Demo: employee_id fix করা আছে, পরে session থেকে আনতে পারবে
    $id = 1;

    $sql = "INSERT INTO sales (customer_id, employee_id, machine_name, sale_amount, paid_amount, installment_count, description)
            VALUES ($customer_id, $id, '$machine_name', $sale_amount, $paid_amount, $installment_count, '$desc')";
    if ($conn->query($sql)) {
        echo "<script>alert('Sale Added Successfully');window.location='index.php';</script>";
    } else {
        $message = "Error: " . $conn->error;
    }
}








?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MS Corporation</title>
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
        <img src="image/logo.jpg">
        <h1>MS Corporation</h1>
    </div>
    <hr>
    <div class="button">
    <a class="dr_btn" onclick="showPage('customer_page')" >add customer</a>
    <a class="dr_btn" onclick="showPage('add_sale_page')" >add sale</a>
    <a class="dr_btn" onclick="showPage('home_page')" href="add_installment.php" >History</a>
    <a class="dr_btn" onclick="showPage('home_page')" >Add payment</a>
    <a class="dr_btn" onclick="showPage('home_page')"  href="desbord.php">DashBoard</a>
    <a class="dr_btn" onclick="showPage('home_page')"  href="customer.php">Customer</a>
    <a class="dr_btn" onclick="showContent('Entry_page')" >Add Entry</a>
    <a class="dr_btn" onclick="showPage('home_page')"  href="desbord.php">Us Employee</a>
    <a class="dr_btn" onclick="showPage('home_page')"  href="logout.php">LogOut</a>
    </div>

</div>
<!-- Drawer end here  -->

<!-- Home page start here -->
<div class="page cls6" id="home_page">
  <img src="image/reagent.jpg" alt="">
  <p>Wel Come To Our MS Corpotation <br> We Are Trusted Reagent Company</p>
  
</div>

<!-- Home page end here -->


<!-- ADD Entry page start here -->
<div class="page" id="Entry_page">
<h1>ADD Entry page</h1>
</div>
<!-- ADD Entry page end here -->


<!-- ADD sale page start here -->
<div class="page" id="add_sale_page">
<div >
  <h3 class="cls1">Add New Sale</h3>
  <form method="POST">
    <div >
      <label class="cls2">Select Customer</label>
      <select class="cls4" name="customer_id"  required>
        <option class="tes"  value="">-- Select Customer --</option>
        <?php
        $customers = $conn->query("SELECT * FROM customers");
        while ($c = $customers->fetch_assoc()) {
            echo "<option value='{$c['customer_id']}'>{$c['name']}</option>";
        }
        ?>
      </select>
    </div>
    <div >
      <label class="cls2">Machine Name</label>
      <input class="cls3" type="text" name="machine_name" class="form-control" required>
    </div>
    <div >
      <label class="cls2">Total Amount</label>
      <input class="cls3" type="number" step="0.01" name="sale_amount"  required>
    </div>
    <div >
      <label class="cls2">Paid Amount</label>
      <input class="cls3" type="number" step="0.01" name="paid_amount"  required>
    </div>
    <div >
      <label class="cls2">Installment Count</label>
      <input class="cls3" type="number" name="installment_count" >
    </div>
    <div >
      <label class="cls2">Description</label>
      <textarea class="cls5" name="description" ></textarea>
    </div>
    <button class="gb_btn" type="submit" name="save_sale" >Save</button>
  </form>
</div>
</div>
<!-- ADD sale page end here -->


<!-- ADD customer page start here -->
<div class="page" id="customer_page">
<div >
  <h3 class="cls1">Add New Customer</h3>
  <form method="POST">
    <div >
      <label class="cls2">Customer/Institute Name</label>
      <input class="cls2" type="text" name="name"  required>
    </div>
    <div >
      <label class="cls2">Contact Person</label>
      <input class="cls2" type="text" name="contact_person" >
    </div>
    <div >
      <label class="cls2">Phone</label>
      <input class="cls2" type="text" name="phone" >
    </div>
    <div >
      <label class="cls2">Address</label>
      <textarea class="cls5" name="address" ></textarea>
    </div>
    <button class="gb_btn" type="submit" name="save_customer" >Save</button>
  </form>
</div>
</div>
<!-- ADD Customer page end here -->

<script src="script.js"></script>
</body>
</html>


