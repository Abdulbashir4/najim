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

<!-- Add Product -->
    <h2>প্রোডাক্ট যোগ করুন</h2>
    <form method="POST" enctype="multipart/form-data">
      <label>Product Name :</label>
      <input type="text" name="product_name" required>
      <label>Model :</label>
      <input type="text" name="product_model" required>
      <label>Brand :</label>
      <input type="text" name="product_brand" required>
      <label>Image Picture:</label>
      <input type="file" name="product_image" accept="image/*">
      <button type="submit" name="save_product">যোগ করুন</button>
    </form>
    <?php
    if (isset($_POST['save_product'])) {
        $product_name = $_POST['product_name'];
        $product_model = $_POST['product_model'];
        $product_brand = $_POST['product_brand'];

        $target_dir = "uploads/";
        $image_file = $target_dir . basename($_FILES["product_image"]["name"]);
        move_uploaded_file($_FILES["product_image"]["tmp_name"], $image_file);

        $sql = "INSERT INTO products (product_name, model, brand, product_image) 
                VALUES ('$product_name', '$product_model', '$product_brand', '$image_file')";
        if ($conn->query($sql)) {
            echo "<script>alert('প্রোডাক্ট সফলভাবে যোগ হয়েছে!'); window.location.href='admin.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
    ?>
  
    <script src="script.js"></script>
</body>
</html>