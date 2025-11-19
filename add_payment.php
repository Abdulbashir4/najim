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

<!-- Add Payments -->
  
    <h3 class="for_label">Add Installment Payment</h3>
    <form method="POST">
        <div>
            <label class="for_label">Select Customer</label>
            <select class="for_select" id="customer" name="customer_id" required onchange="this.form.submit()">
                <option>-- Select Customer --</option>
                <?php
                $customers = $conn->query("SELECT * FROM customers");
                if($customers){
                    while($c = $customers->fetch_assoc()) {
                        $selected = (isset($_POST['customer_id']) && $_POST['customer_id']==$c['customer_id']) ? 'selected' : '';
                        echo "<option value='{$c['customer_id']}' $selected>{$c['name']}</option>";
                    }
                }
                ?>
            </select>
        </div>

        <?php
        if(isset($_POST['customer_id'])) {
            $cust_id = intval($_POST['customer_id']);
            $sales = $conn->query("SELECT * FROM sales WHERE customer_id=$cust_id AND due_amount>0");
            if($sales && $sales->num_rows>0) {
                echo '<div><label class="for_label">Select Sale</label><select class="for_select" name="sale_id" required>';
                echo '<option>-- Select Sale --</option>';
                while($s = $sales->fetch_assoc()) {
                    echo "<option value='{$s['sale_id']}'>Sale #{$s['sale_id']} - {$s['machine_name']} | Due: {$s['due_amount']}</option>";
                }
                echo '</select></div>';

                echo '<div><label class="for_label">Amount Paid</label>
                      <input type="number" step="0.01" name="amount_paid" class="for_input" required></div>';

                echo '<div><label class="for_label">Notes</label>
                      <textarea name="notes" class="for_input"></textarea></div>';

                echo '<button type="submit" name="pay_installment">Submit Payment</button>';
            } else {
                echo "<div>এই কাস্টমারের কোনো বাকি নেই।</div>";
            }
        }
        ?>
    </form>
    <?php
    if(isset($_POST['pay_installment'])) {
        $sale_id = intval($_POST['sale_id']);
        $amount = floatval($_POST['amount_paid']);
        $notes = $_POST['notes'] ?? '';

        $sql1 = "SELECT MAX(installment_no) AS last_no FROM installments WHERE sale_id=$sale_id";
        $res = $conn->query($sql1);
        $installment_no = 1;
        if($res){
            $row = $res->fetch_assoc();
            $installment_no = ($row['last_no'] ?? 0) + 1;
        }

        $sql2 = "INSERT INTO installments (sale_id, installment_no, amount_paid, notes) 
                 VALUES ($sale_id, $installment_no, $amount, '$notes')";
        if($conn->query($sql2)) {
            $sql3 = "UPDATE sales SET paid_amount = paid_amount + $amount WHERE sale_id=$sale_id";
            $conn->query($sql3);
            echo "<script>alert('Installment Paid Successfully');window.location='admin.php';</script>";
            exit;
        }
    }
    ?>
  </div>

</div>
    <script src="script.js"></script>
</body>
</html>