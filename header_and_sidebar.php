<?php include 'server_connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><A:link>MS Corporation</A:link></title>
<link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- <div class="header">
    <div class="logo">
      <img src="image/logo.jpg" alt="">
    </div>
    <div class="menu">
      <button onclick="loadPage('page1.php')">Page 1</button>
      <button onclick="loadPage('page2.php')">Page 2</button>
      <button onclick="loadPage('desbord.php')">Page 3</button>
    </div>
  </div> -->

<div class="for_body">
  <div class="for_sidebar">
    <button onclick="loadPage('add_employee.php')">Add Employee</button>
    <button onclick="loadPage('desbord.php')">DeshBoard</button>
    <button onclick="loadPage('desbord.php')">📄 Page 3</button>
    <button onclick="loadPage('page1.php')">📄 Page 1</button>
    <button onclick="loadPage('page2.php')">📄 Page 2</button>
    
    
  </div>
  <div class="for_content" id="contentArea">
    <div class="for_emp">
    <h3>Add New Employee</h3>
    <form method="POST">
        <div class="for_center">
            <label>Name:</label>
            <input type="text" name="name"  required>
        </div>
        <div class="for_center">
            <label>Email:</label>
            <input type="email" name="email"  required>
        </div>
        <div class="for_center">
            <label>Password:</label>
            <input type="text" name="password"  required>
        </div>
        <div class="for_center">
            <label>Role:</label>
            <select name="role" >
                <option value="admin">Admin</option>
                <option value="staff">Employee</option>
            </select>
        </div>
        <button type="submit" name="save" >Save</button>
    </form>
    <?php
    if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // নিরাপদে hash করতে পারো: password_hash($password, PASSWORD_DEFAULT)
    $role = $_POST['role'];

    $sql = "INSERT INTO employees (name, email, password, role) VALUES ('$name','$email','$password','$role')";
    if ($conn->query($sql)) {
        echo "<script>alert('Employee Added Successfully');window.location='index.php';</script>";
    } else {
        echo "Error: ".$conn->error;
    }
    }
      ?>
    </div>
  </div>
</div>

<script src="script.js"></script>
</body>
</html>
