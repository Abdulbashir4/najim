
    
    <?php include 'server_connection.php';

// ফর্ম সাবমিট হলে
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $shop_name = $_POST['shop_name'];
    $purchase_datetime = $_POST['purchase_datetime'];
    $paid_amount = $_POST['paid_amount'];
    $due_amount = $_POST['due_amount'];
    $note = $_POST['note'];

    $sql = "INSERT INTO store (product_name, quantity, price, shop_name, purchase_datetime, paid_amount, due_amount, note) 
            VALUES ('$product_name', '$quantity', '$price', '$shop_name', '$purchase_datetime', '$paid_amount', '$due_amount', '$note')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('ডাটা সফলভাবে সেভ হয়েছে!'); window.location.href='input.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>