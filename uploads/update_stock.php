<?php
include 'server_connection.php';
// ফর্ম সাবমিট হলে
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $product_id = intval($_POST['product_id']);
    $action = $_POST['action']; // "add" বা "sell"
    $amount = intval($_POST['amount']);

    // পুরোনো স্টক নাও
    $res = $conn->query("SELECT quantity FROM products WHERE id=$product_id");
    $row = $res->fetch_assoc();
    $current_qty = $row['quantity'];

    if($action=="add"){
        $new_qty = $current_qty + $amount;
    } else if($action=="sell"){
        $new_qty = $current_qty - $amount;
        if($new_qty < 0) $new_qty = 0; // নেগেটিভ স্টক এড়ানোর জন্য
    }

    // স্টক আপডেট
    $conn->query("UPDATE products SET quantity=$new_qty WHERE id=$product_id");
    echo "<script>alert('স্টক আপডেট হয়েছে! নতুন পরিমাণ: $new_qty'); window.location.href='update_stock.php';</script>";
}

// প্রোডাক্ট লিস্ট
$products = $conn->query("SELECT * FROM products ORDER BY product_name ASC");
?>
<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<title>স্টক আপডেট</title>
<style>
body{font-family: Arial,sans-serif;background:#f4f6f9;padding:30px;}
.form-box{background:#fff;padding:20px;border-radius:12px;max-width:400px;margin:auto;box-shadow:0 4px 8px rgba(0,0,0,0.1);}
label{display:block;margin-bottom:6px;font-weight:bold;}
input,select{width:100%;padding:10px;margin-bottom:12px;border:1px solid #ccc;border-radius:8px;}
button{background:#4CAF50;color:white;padding:12px;border:none;border-radius:8px;width:100%;cursor:pointer;font-size:16px;}
button:hover{background:#45a049;}
</style>
</head>
<body>
<div class="form-box">
<h2>স্টক আপডেট করুন</h2>
<form method="POST">
<label>প্রোডাক্ট সিলেক্ট করুন:</label>
<select name="product_id" required>
<option value="">-- সিলেক্ট করুন --</option>
<?php
if($products->num_rows>0){
    while($p = $products->fetch_assoc()){
        echo "<option value='{$p['id']}'>{$p['product_name']} (পরিমাণ: {$p['quantity']})</option>";
    }
}
?>
</select>

<label>অ্যাকশন:</label>
<select name="action" required>
<option value="add">কিনলে (স্টক বাড়ানো)</option>
<option value="sell">বিক্রি করলে (স্টক কমানো)</option>
</select>

<label>পরিমাণ:</label>
<input type="number" name="amount" min="1" required>

<button type="submit">আপডেট করুন</button>
</form>
</div>
</body>
</html>
<?php $conn->close(); ?>
