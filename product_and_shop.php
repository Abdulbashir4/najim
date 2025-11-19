<?php include'header_and_sidebar_for_admin.php'; ?>
<?php include'server_connection.php'; 

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM employees WHERE employee_id = $id");
    header("Location: admin.php");
    exit();
}

// ডেটা রিড করো
$result = $conn->query("SELECT * FROM employees");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MS Corporation</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="main">
  <div class="for_content" id="contentArea"></div>

  <!-- add new employer start here -->
  <div class="for_emp page" id="add_employee">
    <h3>Add New Employee</h3>
    <form method="POST">
        <div class="for_center">
            <label>Name:</label>
            <input type="text" name="name"  required>
        </div>
        <div class="for_center">
            <label>Password:</label>
            <input type="text" name="password"  required>
        </div>
        <div class="for_center">
            <label>Role:</label>
            <select name="role">
                <option value="admin">Admin</option>
                <option value="staff">Employee</option>
            </select>
        </div>
        <button type="submit" name="save_employee">Save</button>
    </form>
    <?php
    if (isset($_POST['save_employee'])) {
        $name = $_POST['name'];
        $password = $_POST['password']; 
        $role = $_POST['role'];

        $sql = "INSERT INTO users (username, password, role) VALUES ('$name','$password','$role')";
        if ($conn->query($sql)) {
            echo "<script>alert('Employee Added Successfully');window.location='admin.php';</script>";
            exit;
        } else {
            echo "Error: ".$conn->error;
        }
    }
    ?>
  </div>

  <!-- add new employer end here -->

  <!-- Add Customer start here -->
  <div class="for_emp page" id="Add_customer">
    <h3>Add New Customer</h3>
    <form method="POST">
      <div class="for_center">
        <label>Customer Name</label>
        <input type="text" name="name" required>
      </div>
      <div class="for_center">
        <label>Contact Person</label>
        <input type="text" name="contact_person">
      </div>
      <div class="for_center">
        <label>Phone</label>
        <input type="text" name="phone">
      </div>
      <div class="for_center">
        <label>Address</label>
        <textarea name="address"></textarea>
      </div>
      <button type="submit" name="save_customer">Save</button>
    </form>
    <?php
    if (isset($_POST['save_customer'])) {
        $name = $_POST['name'];
        $contact = $_POST['contact_person'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $sql = "INSERT INTO customers (name, contact_person, phone, address) 
                VALUES ('$name', '$contact', '$phone', '$address')";
        if ($conn->query($sql)) {
            echo "<script>alert('Customer Added Successfully');window.location='admin.php';</script>";
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    }
    ?>
  </div>
  <!-- Add Customer end here -->

  <!-- Add payments page start here -->
  <div class="page pamnt" id="payment">
    <h3 class="for_label">Add Installment Payment</h3>
    <form method="POST">
        <div>
            <label lass="for_label">Select Customer</label>
            <select class="for_select" id="customer" name="customer_id" required onchange="this.form.submit()">
                <option>-- Select Customer --</option>
                <?php
                $customers = $conn->query("SELECT * FROM customers");
                while($c = $customers->fetch_assoc()) {
                    $selected = (isset($_POST['customer_id']) && $_POST['customer_id']==$c['customer_id']) ? 'selected' : '';
                    echo "<option value='{$c['customer_id']}' $selected>{$c['name']}</option>";
                }
                ?>
            </select>
        </div>

        <?php
        if(isset($_POST['customer_id'])) {
            $cust_id = $_POST['customer_id'];
            $sales = $conn->query("SELECT * FROM sales WHERE customer_id=$cust_id AND due_amount>0");
            if($sales->num_rows>0) {
                echo '<div>
                        <label class="for_label">Select Sale</label>
                        <select class="for_select" name="sale_id" required>';
                echo '<option>-- Select Sale --</option>';
                while($s = $sales->fetch_assoc()) {
                    echo "<option value='{$s['sale_id']}'>Sale #{$s['sale_id']} - {$s['machine_name']} | Due: {$s['due_amount']}</option>";
                }
                echo '</select></div>';

                echo '<div>
                        <label class="for_label">Amount Paid</label>
                        <input type="number" step="0.01" name="amount_paid" class="for_input" required>
                      </div>';
                echo '<div>
                        <label class="for_label">Notes</label>
                        <textarea name="notes" class="for_input"></textarea>
                      </div>';
                echo '<button type="submit" name="pay_installment">Submit Payment</button>';
            } else {
                echo "<div>এই কাস্টমারের কোনো বাকি নেই।</div>";
            }
        }
        ?>
    </form>
    <?php
    if(isset($_POST['pay_installment'])) {
        $sale_id = $_POST['sale_id'];
        $amount = $_POST['amount_paid'];
        $notes = $_POST['notes'];

        // Step 1: Add to installments
        $sql1 = "SELECT MAX(installment_no) AS last_no FROM installments WHERE sale_id=$sale_id";
        $res = $conn->query($sql1);
        $row = $res->fetch_assoc();
        $installment_no = $row['last_no'] ? $row['last_no']+1 : 1;

        $sql2 = "INSERT INTO installments (sale_id, installment_no, amount_paid, notes) 
                 VALUES ($sale_id, $installment_no, $amount, '$notes')";
        
        if($conn->query($sql2)) {
            // Step 2: Update sales paid_amount
            $sql3 = "UPDATE sales SET paid_amount = paid_amount + $amount WHERE sale_id=$sale_id";
            if($conn->query($sql3)) {
                echo "<script>alert('Installment Paid Successfully');window.location='admin.php';</script>";
                exit;
            }
        } else {
            echo "Error: ".$conn->error;
        }
    }
    ?>
  </div>
  <!-- Add payments page end here -->

  <!-- Add sale page start here -->
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
        <label class="sale_label">Select Products</label>
        <select name="product_name" class="sale_select" required>
          
          <option value="">-- Select Products --</option>
          <?php
          $products = $conn->query("SELECT * FROM products");
          while ($c = $products->fetch_assoc()) {
              echo "<option value='{$c['product_name']}'>{$c['product_name']} = ({$c['qty']}) Pcs</option>";
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
        $customer_id = $_POST['customer_id'];
        $product_name = $_POST['product_name'];
        $sale_amount = $_POST['sale_amount'];
        $paid_amount = $_POST['paid_amount'];
        $qty = $_POST['qty'];
        $desc = $_POST['description'];

        // Employee ID demo: 1
        $id = 1;

        $sql = "INSERT INTO sales (customer_id, employee_id, product_name, sale_amount, paid_amount, qty, description)
                VALUES ($customer_id, $id, '$product_name', $sale_amount, $paid_amount, $qty, '$desc')";
        if ($conn->query($sql)) {
            echo "<script>alert('Sale Added Successfully');window.location='admin.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
    ?>
  </div>
  </div>
  <!-- Add sale page end here -->


  <!-- Add product page start here -->
   <div class="page" id="add_product">
    <div class="form-box page-content">
    <h2>প্রোডাক্ট যোগ করুন</h2>
    <form method="POST" enctype="multipart/form-data">
      <label>প্রোডাক্ট নাম:</label>
      <input type="text" name="product_name" required>

      <label>প্রোডাক্ট ছবি:</label>
      <input type="file" name="product_image" accept="image/*" required>

      <label>পরিমাণ:</label>
      <input type="number" name="quantity" required>

      <label>দর:</label>
      <input type="number" step="0.01" name="price" required>

      <label>বিস্তারিত:</label>
      <textarea name="description"></textarea>

      <button type="submit" name="save_product">যোগ করুন</button>
    </form>
  <?php
if (isset($_POST['save_product'])) {
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // ছবি আপলোড
    $target_dir = "uploads/";
    $image_file = $target_dir . basename($_FILES["product_image"]["name"]);
    move_uploaded_file($_FILES["product_image"]["tmp_name"], $image_file);

    $sql = "INSERT INTO products (product_name, product_image, qty, price, description) 
            VALUES ('$product_name', '$image_file', '$quantity', '$price', '$description')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('প্রোডাক্ট সফলভাবে যোগ হয়েছে!'); window.location.href='admin.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

  </div>
   </div>
  <!-- Add product page end here -->


  <!-- Add product and shop page start here -->
   <div class="page" id="product_shop">
    <div class="form-box page-content">
    <h2>Product and Shop Input</h2>
    <form method="POST" enctype="multipart/form-data">
      <label>Product Name</label>
      <input type="text" name="product_name">
      <label>Shop Name</label>
      <textarea name="shop_name"></textarea>
      <label>Phone</label>
      <input type="number" name="phone" >
      <button type="submit" name="save_product_and_shop">Submit</button>
    </form>
  <?php
if (isset($_POST['save_product_and_shop'])) {
    $product_name = $_POST['product_name'];
    $shop_name = $_POST['shop_name'];
    $phone = $_POST['phone'];			


    $sql = "INSERT INTO product_and_shop (products_name, shop_name, phone) 
            VALUES ('$product_name', '$shop_name', ' $phone')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('প্রোডাক্ট সফলভাবে যোগ হয়েছে!'); window.location.href='admin.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

  </div>
   </div>
  <!-- Add product page end here -->

</div> <!-- main class end here -->
</body>
</html>
