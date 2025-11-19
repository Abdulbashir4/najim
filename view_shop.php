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
// মোট প্রডাক্ট সংখ্যা
$result = $conn->query("SELECT COUNT(*) AS total_product FROM products");
$row = $result->fetch_assoc();
echo "<p>Total Product: <b>" . $row['total_product'] . "</b></p>";
?>

<h3>Products List</h3>
<div class="for_pc">
<table>
    
    <tr>
        <th>SL</th>
        <th>Product Name</th>
        <th>Model</th>
        <th>Brand</th>
        <th>Stock Available</th>
        <th>Total Sell</th>
        <th>Total Bye</th>
        <th>Product Code</th>
        <th>Action</th>
    </tr>
    <?php
$sql = "
SELECT 
    p.product_id,
    p.product_name,
    p.model,
    p.brand,
    COALESCE(SUM(b.qty), 0) AS total_buy_qty,
    COALESCE(SUM(s.qty), 0) AS total_sale_qty,
    (COALESCE(SUM(b.qty), 0) - COALESCE(SUM(s.qty), 0)) AS current_stock
FROM products p
LEFT JOIN bye_info b ON b.product_name = p.product_id
LEFT JOIN sales s ON s.product_name = p.product_name
GROUP BY p.product_id, p.product_name, p.model, p.brand
ORDER BY p.product_name ASC
";
$result = $conn->query($sql);

$sl = 1;
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$sl}</td>
        <td>{$row['product_name']}</td>
        <td>{$row['model']}</td>
        <td>{$row['brand']}</td>
        <td><b>{$row['current_stock']}</b></td>
        <td>{$row['total_sale_qty']}</td>
        <td>{$row['total_buy_qty']}</td>
        <td>{$row['product_id']}</td>
        <td>
            <button class='edit btn' onclick=\"editData('products', '{$row['product_id']}')\">Edit</button>
            <button class='delete btn' onclick=\"deleteData('products', '{$row['product_id']}')\">Delete</button>
        </td>
    </tr>";
    $sl++;
}
?>


</table>
</div>
<div class="for_phone">
    <table>
        <?php 
        $sql = "
SELECT 
    p.product_id,
    p.product_name,
    p.model,
    p.brand,
    COALESCE(SUM(b.qty), 0) AS total_buy_qty,
    COALESCE(SUM(s.qty), 0) AS total_sale_qty,
    (COALESCE(SUM(b.qty), 0) - COALESCE(SUM(s.qty), 0)) AS current_stock
FROM products p
LEFT JOIN bye_info b ON b.product_name = p.product_id
LEFT JOIN sales s ON s.product_name = p.product_name
GROUP BY p.product_id, p.product_name, p.model, p.brand
ORDER BY p.product_name ASC
";
$result = $conn->query($sql);
        $sl = 1;
        while ($c = $result->fetch_assoc()) {
        echo "
        <table border='1' cellspacing='0' cellpadding='6' style='margin-bottom:20px; border-collapse:collapse; width:100%; border-radius:7px;'>
        <tr>
            <th>SL:</th>
            <td>{$sl}</td>
        </tr>

        <tr>
        <th>Product Name</th>
        <td>{$c['product_name']}</td>
        </tr>

        <tr>
        <th>Model</th>
        <td>{$c['model']}</td>
        </tr>

        <tr>
        <th>Brand</th>
        <td>{$c['brand']}</td>
        </tr>
        <tr>
        <th>Stock Available</th>
        <td>{$c['current_stock']}</td>
        </tr>
        <tr>
        <th>Action:</th>
        <td><button class='edit btn' onclick=\"editData('products', '{$c['product_id']}')\">Edit</button>
        <button class='delete btn' onclick=\"deleteData('products', '{$c['product_id']}')\">Delete</button></td>
        </tr>
        
        ";
        $sl += 1;
    }
        ?>
    </table>
</div>
</div>
</body>
</html>

