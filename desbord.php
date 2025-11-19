<?php include 'server_connection.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body >
    <div class="page-content">
<?php
// মোট কাস্টমার সংখ্যা
$result = $conn->query("SELECT COUNT(*) AS total_customers FROM customers");
$row = $result->fetch_assoc();
echo "<p>মোট কাস্টমার: <b>" . $row['total_customers'] . "</b></p>";
?>

<h3>কাস্টমার লিস্ট</h3>
<div class="for_pc">
<table>
    
    <tr>
        <th>ID</th>
        <th>Customer Name</th>
        <th>Contact Person</th>
        <th>Phone</th>
        <th>Details</th>
        <th>Action</th>
    </tr>
    <?php
    $sql = "SELECT * FROM customers";
    $customers = $conn->query($sql);
    while ($c = $customers->fetch_assoc()) {
        echo "<tr>
            <td>{$c['customer_id']}</td>
            <td>{$c['name']}</td>
            <td>{$c['contact_person']}</td>
            <td>{$c['phone']}</td>
            <td><a href='customer.php?id={$c['customer_id']}'>Details....</a></td>
            <td>
            <button class='edit btn' onclick=\"editData('customers', '{$c['customer_id']}')\">Edit</button>
            <button class='delete btn' onclick=\"deleteData('customers', '{$c['customer_id']}')\">Delete</button></td>
           
        </tr>";
    }
    ?>
</table>
</div>
<div class="for_phone">
    <table>
        <?php 
        $sql = "SELECT * FROM customers";
        $customers = $conn->query($sql);
        while ($c = $customers->fetch_assoc()) {
        echo "
        <table border='1' cellspacing='0' cellpadding='6' style='margin-bottom:20px; border-collapse:collapse; width:100%; border-radius:7px;'>
        <tr>
            <th>Customer ID:</th>
            <td>{$c['customer_id']}</td>
        </tr>

        <tr>
        <th>Customer Name:</th>
        <td>{$c['name']}</td>
        </tr>

        <tr>
        <th>Contact Person:</th>
         <td>{$c['contact_person']}</td>
        </tr>

        <tr>
        <th>Phone:</th>
        <td>{$c['phone']}</td>
        </tr>
        
        <tr> 
        <th>Details:</th>
        <td><a href='customer.php?id={$c['customer_id']}'>Details....</a></td>
        </tr>
        <tr>
        <th>Action:</th>
        <td><button class='edit btn' onclick=\"editData('customers', '{$c['customer_id']}')\">Edit</button>
        <button class='delete btn' onclick=\"deleteData('customers', '{$c['customer_id']}')\">Delete</button></td>
        </tr>
        ";
    }
        ?>
    </table>
</div>
</div>
</body>
</html>

