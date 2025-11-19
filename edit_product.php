<?php
include 'server_connection.php';
$id = intval($_GET['id']);
$res = $conn->query("SELECT * FROM products WHERE product_id=$id");
$row = $res->fetch_assoc();

// আপডেট
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $product_name = $_POST['product_name'];
    $quantity = $_POST['qty'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $image_file = $row['product_image'];
    if(isset($_FILES['product_image']) && $_FILES['product_image']['name'] != ''){
        // পুরোনো ছবি ডিলিট
        if(file_exists($row['product_image'])) unlink($row['product_image']);
        $target_dir = "uploads/";
        $image_file = $target_dir . basename($_FILES["product_image"]["name"]);
        move_uploaded_file($_FILES["product_image"]["tmp_name"], $image_file);
    }

    $update_sql = "UPDATE products SET 
        product_name='$product_name',
        quantity='$quantity',
        price='$price',
        description='$description',
        product_image='$image_file'
        WHERE product_id=$id";

    if($conn->query($update_sql)===TRUE){
        echo "<script>alert('প্রোডাক্ট আপডেট হয়েছে!'); window.location.href='products.php';</script>";
    }else{
        echo "Error: ".$conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<title>প্রোডাক্ট এডিট</title>
<style>
body{font-family: Arial,sans-serif;background:#f7f9fc;padding:30px;}
.form-box{background:#fff;padding:20px;border-radius:12px;max-width:500px;margin:auto;box-shadow:0 4px 8px rgba(0,0,0,0.1);}
h2{text-align:center;margin-bottom:20px;}
label{display:block;margin-bottom:6px;font-weight:bold;}
input,textarea{width:100%;padding:10px;margin-bottom:12px;border:1px solid #ccc;border-radius:8px;}
textarea{resize:none;height:80px;}
button{background:#4CAF50;color:white;padding:12px;border:none;border-radius:8px;width:100%;cursor:pointer;font-size:16px;}
button:hover{background:#45a049;}
</style>
</head>
<body>
<div class="form-box">
<h2>প্রোডাক্ট এডিট করুন</h2>
<form method="POST" enctype="multipart/form-data">
<label>প্রোডাক্ট নাম:</label>
<input type="text" name="product_name" value="<?= $row['product_name'] ?>" required>

<label>প্রোডাক্ট ছবি:</label>
<input type="file" name="product_image">
<img src="<?= $row['product_image'] ?>" alt="<?= $row['product_name'] ?>" style="width:100px;margin-bottom:10px;">

<label>পরিমাণ:</label>
<input type="number" name="quantity" value="<?= $row['qty'] ?>" required>

<label>দর:</label>
<input type="number" step="0.01" name="price" value="<?= $row['price'] ?>" required>

<label>বিস্তারিত:</label>
<textarea name="description"><?= $row['description'] ?></textarea>

<button type="submit">আপডেট করুন</button>
</form>
</div>
</body>
</html>
<?php $conn->close(); ?>
