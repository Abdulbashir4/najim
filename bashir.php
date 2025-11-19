<?php 
session_start();
include 'server_connection.php';

// ধরুন লগইন করার সময় $_SESSION['employee_id'] সেট করা হয়েছে
// উদাহরণ:
// $_SESSION['employee_id'] = $row['employee_id'];

?>

<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <title>HTML টেবিল</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      padding: 20px;
    }

    h2 {
      text-align: center;
      color: #333;
    }

    table {
      width: 70%;
      margin: auto;
      border-collapse: collapse;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
      background-color: #fff;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 12px;
      text-align: center;
    }

    th {
      background-color: #4CAF50;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    tr:hover {
      background-color: #f1f1f1;
    }
  </style>
</head>
<body>
  <h2>ছাত্রদের তথ্য টেবিল</h2>
  <table>
    <tr>
      <th>ক্রমিক</th>
      <th>নাম</th>
      <th>বয়স</th>
      <th>ঠিকানা</th>
    </tr>
    <tr>
      <td>1</td>
      <td>রাকিব</td>
      <td>20</td>
      <td>ঢাকা</td>
    </tr>
    <tr>
      <td>2</td>
      <td>সুমন</td>
      <td>22</td>
      <td>চট্টগ্রাম</td>
    </tr>
    <tr>
      <td>3</td>
      <td>আনিকা</td>
      <td>19</td>
      <td>রাজশাহী</td>
    </tr>
  </table>

  <div class="page" id="sale_page">
    <div class="sale_btn">
      <h3>Add New Sale</h3>
      <form method="POST">
        <div class="sale_customer">
          <label>Select Customer</label>
          <select name="customer_id" class="sale_select" required>
            <option value="">-- Select Customer --</option>
            <?php
            $customers = $conn->query("SELECT * FROM customers");
            while ($c = $customers->fetch_assoc()) {
                echo "<option value='{$c['customer_id']}'>{$c['name']}</option>";
            }
            ?>
          </select>
        </div>

        <div class="sale_customer">
          <label>Select Products</label>
          <select name="product_name" class="sale_select" required>
            <option value="">-- Select Products --</option>
            <?php
            $products = $conn->query("SELECT * FROM products");
            while ($p = $products->fetch_assoc()) {
                echo "<option value='{$p['product_name']}'>{$p['product_name']} = ({$p['qty']}) Pcs</option>";
            }
            ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="sale_label">Total Amount</label>
          <input type="number" step="0.01" name="sale_amount" class="sale_input" required>
        </div>

        <div class="mb-3">
          <label class="sale_label">Paid Amount</label>
          <input type="number" step="0.01" name="paid_amount" class="sale_input" required>
        </div>

        <div class="mb-3">
          <label class="sale_label">Product quantity</label>
          <input type="number" name="qty" class="sale_input">
        </div>

        <div class="mb-3">
          <label class="sale_label">Description</label>
          <textarea name="description" class="sale_input"></textarea>
        </div>

        <button type="submit" name="save_sale" class="sale_btn2">Save</button>
      </form>

<?php
if (isset($_POST['save_sale'])) {
    // ১) employee_id session থেকে নেওয়া
    if (!isset($_SESSION['employee_id'])) {
        echo "<script>alert('Employee not logged in!');</script>";
        exit;
    }
    $employee_id = intval($_SESSION['employee_id']);

    // ২) ইনপুট নেওয়া
    $customer_id = intval($_POST['customer_id']);
    $product_name = $_POST['product_name'];
    $sale_amount = floatval($_POST['sale_amount']);
    $paid_amount = floatval($_POST['paid_amount']);
    $qty = intval($_POST['qty']);
    $desc = $_POST['description'];

    // ৩) Foreign key চেক: Customer
    $check_cust = $conn->prepare("SELECT * FROM customers WHERE customer_id = ?");
    $check_cust->bind_param("i", $customer_id);
    $check_cust->execute();
    $cust_result = $check_cust->get_result();
    if ($cust_result->num_rows === 0) {
        echo "<script>alert('Invalid Customer ID');</script>";
        exit;
    }

    // ৪) Insert into sales
    $stmt = $conn->prepare("INSERT INTO sales (employee_id, customer_id, product_name, sale_amount, paid_amount, qty, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisdids", $employee_id, $customer_id, $product_name, $sale_amount, $paid_amount, $qty, $desc);

    if ($stmt->execute()) {
        echo "<script>alert('Sale Added Successfully');window.location='admin.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
    </div>
  </div>

</body>
</html>
