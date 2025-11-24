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
<form action="" method="POST" id="bye_form">
<div class="cls10"><h1>Shop Add</h1></div>
<div class="cls12">
<table>
<tr>
    <th>Shop Name</th>
    <td><input type="text" placeholder="ABC EnterPrice" name="shop_name"></td>
</tr>
<tr>
    <th>Contact Person</th>
    <td><input type="text" placeholder="ABDUL Basir" name="contact_person"></td>
</tr>
<tr>
    <th>Phone</th>
    <td><input type="text" placeholder="01788832489" name="phone"></td>
</tr>
<tr>
    <th>Address</th>
    <td><input type="text" placeholder="Dhaka, Mohakhali" name="address"></td>
</tr>
</table>
<div class="cls13"><button name="add_shop_btn">Submit</button></div>
</div>
</form>
<?php 
if(isset($_POST['add_shop_btn'])){
    $shop_name = $_POST['shop_name'];
    $contact_person = $_POST['contact_person'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql= " INSERT INTO shops(shop_name,address,contact_person,phone) 
    VALUES('$shop_name', '$address', '$contact_person', '$phone') ";
    if($conn->query($sql)){
        echo" <script> alert('Shop Added Succecfully'); window.location.href='add_shop.php';</script> ";

    }
    else{
        echo"<script> alert('Database Insert Fail');</script>";
    }

}
?>



</div>
</div>
    <script src="script.js"></script>
</body>
</html>