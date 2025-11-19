<?php
include 'server_connection.php';
// স্টক আপডেট
if (isset($_GET['stock_action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['stock_action']; // "sell" বা "buy"
    $amount = isset($_GET['amount']) ? intval($_GET['amount']) : 1;

    $res = $conn->query("SELECT qty FROM products WHERE product_id=$id");
    $row = $res->fetch_assoc();
    $current_qty = $row['qty'];

    if ($action == "sell") {
        $new_qty = $current_qty - $amount;
        if ($new_qty < 0) $new_qty = 0;
    } else {
        $new_qty = $current_qty + $amount;
    }

    $conn->query("UPDATE products SET qty=$new_qty WHERE product_id=$id");
    header("Location: products.php"); // রিফ্রেশ
    exit();
}

// সর্বোচ্চ 10টি প্রোডাক্ট
$sql = "SELECT * FROM products ORDER BY product_id DESC LIMIT 10000";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<title>প্রোডাক্ট লিস্ট</title>
</head>
<body>
    <?php include 'header_and_sidebar_for_admin.php'; ?>
    <div class="main">
    <div class="for_content" id="contentArea">
    <div class="page-content">
<h2>প্রোডাক্ট লিস্ট</h2>
<div class="grid">
<?php
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo "
        <div class='card'>
            <img src='{$row['product_image']}' alt='{$row['product_name']}'>
            <h3>Name :{$row['product_name']}</h3>
            <h3>Model :{$row['model']}</h3>
            <h3>Brand :{$row['brand']}</h3>
            <a class='btn details' href='product_details.php?id={$row['product_id']}'>Details</a>
            <a class='btn edit' href='edit_product.php?id={$row['product_id']}'>Edit</a>
            <a class='btn delete' href='delete.php?table=products&id={$row['product_id']}' onclick=\"return confirm('আপনি কি ডিলিট করতে চান?');\">Delete</a>
            </div>";
    }
}else{
    echo "<p>কোনো প্রোডাক্ট পাওয়া যায়নি</p>";
}
?>
</div>
</div>
</div>
</div>
</body>
</html>
<?php $conn->close(); ?>
