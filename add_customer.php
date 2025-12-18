<?php include'server_connection.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="20000">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MS Corporation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main">
    <div class="for_content" id="contentArea">
      <div class="for_pc">
<div class="for_emp" id="Add_customer">
    <h3>Add New Customer</h3>
    <form method="POST">
      <div class="for_center">
        <label>Customer Name</label>
        <input type="text" name="name" required>
      </div>
      <div class="for_center">
        <label>Contact Person</label>
        <input type="text" name="contact_person">
      </div>
      <div class="for_center">
        <label>Phone</label>
        <input type="text" name="phone">
      </div>
      <div class="for_center">
        <label>Address</label>
        <textarea name="address"></textarea>
      </div>
      <button type="submit" name="save_customer">Save</button>
    </form>
    <?php
    if (isset($_POST['save_customer'])) {
        $name = $_POST['name'];
        $contact = $_POST['contact_person'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $sql = "INSERT INTO customers (name, contact_person, phone, address) 
                VALUES ('$name', '$contact', '$phone', '$address')";
        if ($conn->query($sql)) {
            echo "<script>alert('Customer Added Successfully');window.location='admin.php';</script>";
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    }
    ?>
  </div>
</div>
 <div class="for_phone">
  <h3>Add New Customer</h3>
  <form method="POST">
      <div class="for_center">
        <label>Customer Name</label>
        <input type="text" name="name" required>
      </div>
      <div class="for_center">
        <label>Contact Person</label>
        <input type="text" name="contact_person">
      </div>
      <div class="for_center">
        <label>Phone</label>
        <input type="text" name="phone">
      </div>
      <div class="for_center">
        <label>Address</label>
        <textarea name="address"></textarea>
      </div>
      <button class="cls09" type="submit" name="save_customer">Save</button>
    </form>
    <?php
    if (isset($_POST['save_customer'])) {
        $name = $_POST['name'];
        $contact = $_POST['contact_person'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $sql = "INSERT INTO customers (name, contact_person, phone, address) 
                VALUES ('$name', '$contact', '$phone', '$address')";
        if ($conn->query($sql)) {
            echo "<script>alert('Customer Added Successfully');window.location='admin.php';</script>";
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    }
    ?>
 </div>
</div>
    <script src="script.js"></script>
</body>
</html>