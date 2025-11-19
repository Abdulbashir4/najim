<?php
include 'server_connection.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
if (isset($_POST['sale_submit'])) {
    $employee_id = intval($_POST['sale_by']);
    $branch_id   = intval($_POST['sale_from']);
    $customer_id = intval($_POST['customer']);
    $sale_date   = date('Y-m-d', strtotime($_POST['sale_date']));
    $paid_amount = floatval($_POST['paid_amount']);
    $discount_all = floatval($_POST['discount'] ?? 0);
    $desc        = 'Sale entry via form';

    // ✅ ইনভয়েস নম্বর জেনারেট
    $year = date('Y');
    $result = $conn->query("SELECT invoice_no FROM invoices WHERE invoice_no LIKE 'MS-$year-%' ORDER BY id DESC LIMIT 1");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        preg_match('/MS-\d{4}-(\d+)/', $row['invoice_no'], $matches);
        $last = (int)($matches[1] ?? 0);
        $new = $last + 1;
    } else { $new = 1; }
    $invoice_no = "MS-$year-" . str_pad($new, 4, '0', STR_PAD_LEFT);

    // ✅ invoices টেবিলে ইনসার্ট
    $stmt = $conn->prepare("INSERT INTO invoices 
        (invoice_no, employee_id, branch_id, sale_date, customer_id, paid_amount, discount, description)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siisidds", $invoice_no, $employee_id, $branch_id, $sale_date, $customer_id, $paid_amount, $discount_all, $desc);
    $stmt->execute();
    $invoice_id = $conn->insert_id;

    // 🔹 product name ফেচ করার prepared stmt
    $pnameStmt = $conn->prepare("SELECT product_name FROM products WHERE product_id = ?");
    // 🔹 invoice_items insert
    $itemStmt = $conn->prepare("INSERT INTO invoice_items 
        (invoice_id, product_id, qty, unit_price, total_price, discount_tk, discount_per)
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    // 🔹 ✅ sales insert (এটাই নতুন)
    $saleStmt = $conn->prepare("INSERT INTO sales 
        (customer_id, employee_id, product_name, sale_amount, paid_amount, qty,  unit, description, sale_date, invoice_no, branch_id, unit_price, discount_tk, discount_per, discount)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($_POST['product_id'] as $i => $product_id) {
        $product_id = intval($product_id);
        $qty = floatval($_POST['qty'][$i]);
        $unit_per = $_POST['unit'][$i];
        $unit_price = floatval($_POST['price'][$i]);
        $discount_tk = floatval($_POST['discount_tk'][$i] ?? 0);
        $discount_per = floatval($_POST['discount_per'][$i] ?? 0);
        $unit = 

        $base_total = $qty * $unit_price;
        $final_total = $base_total - ($discount_tk ?: ($base_total * $discount_per / 100));

        // invoice_items ➜ insert
        $itemStmt->bind_param("iiidddd", $invoice_id, $product_id, $qty, $unit_price, $final_total, $discount_tk, $discount_per);
        $itemStmt->execute();

        // product_name বের করা
        $pname = '';
        $pnameStmt->bind_param("i", $product_id);
        $pnameStmt->execute();
        $pnameRes = $pnameStmt->get_result();
        if ($rowP = $pnameRes->fetch_assoc()) { $pname = $rowP['product_name']; }

        // ✅ sales ➜ insert (invoice পেজ এই টেবিল থেকেই পড়ে)
        // bind types: i i s d d d s s s i d d d
        $saleStmt->bind_param(
            "iisdddssssidddi",
            $customer_id,           // i
            $employee_id,           // i
            $pname,                 // s
            $final_total,           // d (sale_amount = ডিসকাউন্ট-পরবর্তী লাইন টোটাল)
            $paid_amount,           // d (invoice level paid; লাইনে একইটা রাখা হলো)
            $qty,                   // d
            $unit_per,                  // s
            $desc,                  // s
            $sale_date,             // s (Y-m-d)
            $invoice_no,            // s
            $branch_id,             // i
            $unit_price,            // d
            $discount_tk,           // d
            $discount_per,           // d
            $discount_all             //i
        );
        $saleStmt->execute();
    }

    echo "<script>window.location='invoice.php?invoice={$invoice_no}';</script>";
}
} catch (mysqli_sql_exception $e) {
    echo "<h3 style='color:red;'>⚠️ Database Error:</h3><pre>{$e->getMessage()}</pre>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MS Corporation - Sale Entry</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
:root{
  --border:#d8e0ea;
  --muted:#6b7280;
  --shadow:0 4px 10px rgba(0,0,0,.08);
  --radius:10px;
}
body{
  font-family:Arial, sans-serif;
  margin:0;
  color:#111827;
  background:#f8fafc;
}
.main .for_content{padding:20px;}
h1{margin:10px 0 18px;}

/* ===== Layout ===== */
.form-row {
  display: flex;
  align-items: flex-start;
  flex-direction: row-reverse; /* ডানদিকে Add Product, বামে Sale/Billing */
  gap: 40px;
  margin-bottom: 20px;
  flex-wrap: wrap;
}
.left-side {
  display: flex;
  flex-direction: column;
  gap: 15px;
  flex: 1;
  min-width: 300px;
}
.right-side {
  flex: 1;
  min-width: 320px;
}

/* --- Card Styles --- */
.form-card {
    width: 83%;
  background:#fff;
  border:1px solid var(--border);
  border-radius:var(--radius);
  box-shadow:var(--shadow);
  padding:14px 18px;
}
.form-card h3 {
  margin:0 0 10px;
  font-size:16px;
  color:#1f2937;
}
.form-card table {
  width:100%;
  border-collapse:separate;
  border-spacing:0 10px;
}
.form-card th {
  width:40%;
  text-align:left;
  color:var(--muted);
  font-size:13px;
  padding-right:8px;
}
.form-card td {padding:0;}
.form-card select,
.form-card input {
  width:100%;
  height:36px;
  border:1px solid var(--border);
  border-radius:6px;
  padding:0 8px;
}

.form-card input {
  width:89%;
  height:36px;
  border:1px solid var(--border);
  border-radius:6px;
  padding:0 8px;
}



/* --- Submit Button --- */
.submit-wrap {
  display:flex;
  justify-content:center;
  margin-top:5px;
}
.submit-btn {
  background:#111827;
  color:#fff;
  border:none;
  border-radius:8px;
  padding:10px 16px;
  cursor:pointer;
  box-shadow:0 4px 8px rgba(0,0,0,.15);
}
.submit-btn:hover {filter:brightness(1.1);}

/* --- Cart Items Table --- */
#productList {
  width:100%;
  border-collapse:collapse;
  background:#fff;
  border:1px solid var(--border);
  border-radius:var(--radius);
  box-shadow:var(--shadow);
  margin-top:30px;
}
#productList th {
  background:#f1f5f9;
  color:#111827;
  padding:10px;
  border-bottom:1px solid var(--border);
}
#productList td {
  padding:8px;
  text-align:center;
  border-bottom:1px solid #eee;
}
#productList tbody tr:nth-child(even){background:#fafafa;}
#productList tbody tr:hover{background:#f3f4f6;}

/* Buttons */
.btn1 {
  background:#111827;
  color:#fff;
  border:none;
  border-radius:8px;
  padding:8px 14px;
  cursor:pointer;
}
.btn1:hover{filter:brightness(1.08);}
.btn-danger{
  background:#fff;
  color:#b91c1c;
  border:1px solid #f1d3d3;
  padding:5px 10px;
  border-radius:6px;
  cursor:pointer;
}

/* ===== Responsive ===== */
@media (max-width: 1024px) {
  .form-row {flex-direction: column; gap: 20px;}
  .left-side, .right-side {width: 100%;}
  .submit-wrap {justify-content: center; margin-top: 10px;}
}
@media (max-width: 600px) {
  .form-card { padding:12px; }
  .form-card h3 { font-size:15px; }
  th, td { font-size:13px; }
  .btn1, .submit-btn { width:90%; }
  #productList { display:block; overflow-x:auto; }
}
</style>
</head>
<body>
<?php include 'header_and_sidebar_for_admin.php'; ?>
<div class="main">
<div class="for_content">
<h1>Product Sale Entry</h1>

<form method="post" id="saleForm">
  <div class="form-row">
    <!-- LEFT SIDE: Sale & Billing + Submit -->
    <div class="left-side">
      <div class="form-card">
        <h3>Sale & Customer</h3>
        <table>
          <tr><th>Sale By:</th><td>
            <select name="sale_by" required>
              <option value="">Select Employee</option>
              <?php $res=$conn->query("SELECT * FROM employees");
              while($r=$res->fetch_assoc()){echo "<option value='{$r['employee_id']}'>{$r['name']}</option>";} ?>
            </select>
          </td></tr>
          <tr><th>Sale From:</th><td>
            <select name="sale_from" required>
              <option value="">Select Branch</option>
              <?php $br=$conn->query("SELECT * FROM branch");
              while($r=$br->fetch_assoc()){echo "<option value='{$r['branch_id']}'>{$r['branch_name']}</option>";} ?>
            </select>
          </td></tr>
          <tr><th>Customer:</th><td>
            <select name="customer" required>
              <option value="">Select Customer</option>
              <?php $cust=$conn->query("SELECT * FROM customers");
              while($r=$cust->fetch_assoc()){echo "<option value='{$r['customer_id']}'>{$r['name']}</option>";} ?>
            </select>
          </td></tr>
        </table>
      </div>

      <div class="form-card">
        <h3>Billing</h3>
        <table>
          <tr><th>Date:</th><td><input type="date" name="sale_date" required></td></tr>
          <tr><th>Paid Amount:</th><td><input type="number" name="paid_amount" step="0.01"></td></tr>
          <tr><th>Total Discount:</th><td><input type="number" name="discount" step="0.01"></td></tr>
        </table>
      </div>

      <div class="submit-wrap">
        <button type="submit" name="sale_submit" class="submit-btn">Submit & Generate Invoice</button>
      </div>
    </div>

    <!-- RIGHT SIDE: Add Product -->
    <div class="right-side">
      <div class="form-card">
        <h3>Add Product</h3>
        <table>
          <tr><th>Product:</th><td>
            <select id="productSelect">
              <option value="">Select Product</option>
              <?php $prod=$conn->query("SELECT * FROM products");
              while($r=$prod->fetch_assoc()){echo "<option value='{$r['product_id']}' data-name='{$r['product_name']}'>{$r['product_name']}</option>";} ?>
            </select>
          </td></tr>
          <tr><th>Quantity:</th><td><input type="number" id="qtyInput" min="1"></td></tr>
          <tr><th>Unit:</th><td>
            <select  id="unitInput">
               <option value="pcs">Pcs</option>
                <option value="pack">Pack</option>
                 <option value="box">Box</option>
                 <option value="carton">Carton</option>
                 </select> </td></tr>
          <tr><th>Unit Price:</th><td><input type="number" id="priceInput" step="0.01"></td></tr>
          <tr><th>Discount Tk:</th><td><input type="number" id="discount_tk" step="0.01"></td></tr>
          <tr><th>Discount %:</th><td><input type="number" id="discount_per" step="0.01"></td></tr>
          <tr><td></td><td style="text-align:right"><button class="btn1" type="button" onclick="addRow()">Add To Cart</button></td></tr>
        </table>
      </div>
    </div>
  </div>

  <!-- Hidden inputs (cart থেকে অ্যাপেন্ড হবে) -->
  <div id="hiddenInputs"></div>
</form>

<!-- CART ITEMS TABLE -->
<table id="productList">
  <thead><tr>
    <th>Product</th>
    <th>Qty</th> 
    <th>Unit</th> 
    <th>Price</th>
    <th>Discount (Tk)</th>
    <th>Discount (%)</th>
    <th>Total</th>
    <th>Action</th>
  </tr>
</thead>
<tbody>

</tbody>
</table>

</div></div>

<script>
const discountTkInput=document.getElementById("discount_tk");
const discountPerInput=document.getElementById("discount_per");
discountTkInput.addEventListener("input",function(){
 if(parseFloat(this.value)>0){
  discountPerInput.disabled=true; discountPerInput.style.background="#eee";
 } else { discountPerInput.disabled=false; discountPerInput.style.background=""; }
});
discountPerInput.addEventListener("input",function(){
 if(parseFloat(this.value)>0){
  discountTkInput.disabled=true; discountTkInput.style.background="#eee";
 } else { discountTkInput.disabled=false; discountTkInput.style.background=""; }
});

function addRow(){
 let pSel=document.getElementById("productSelect");
 let qty=parseFloat(document.getElementById("qtyInput").value);
 let price=parseFloat(document.getElementById("priceInput").value);
 let unit = document.getElementById("unitInput").value;
 let disTk=parseFloat(document.getElementById("discount_tk").value)||0;
 let disPer=parseFloat(document.getElementById("discount_per").value)||0;
 let tbody=document.querySelector("#productList tbody");
 if(!pSel.value||!qty||!price){ alert("সব ঘর পূরণ করুন!"); return; }

 let base=qty*price, total=base;
 if(disTk>0) total-=disTk; else if(disPer>0) total-=(base*disPer/100);

 let row=document.createElement("tr");
 row.innerHTML=`<td>${pSel.options[pSel.selectedIndex].dataset.name}</td>
 <td>${qty}</td> <td>${unit}</td> <td>${price}</td><td>${disTk}</td><td>${disPer}</td>
 <td>${total.toFixed(2)}</td>
 <td><button type='button' class='btn-danger' onclick='removeRow(this)'>Remove</button></td>`;
 tbody.appendChild(row);

 let hidden=document.getElementById("hiddenInputs");
 hidden.innerHTML += `
 <input type="hidden" name="product_id[]" value="${pSel.value}">
 <input type="hidden" name="qty[]" value="${qty}">
 <input type="hidden" name="unit[]" value="${unit}">
 <input type="hidden" name="price[]" value="${price}">
 <input type="hidden" name="discount_tk[]" value="${disTk}">
 <input type="hidden" name="discount_per[]" value="${disPer}">`;

 pSel.selectedIndex=0;
 document.getElementById("qtyInput").value="";
 document.getElementById("priceInput").value="";
 discountTkInput.value=""; discountPerInput.value="";
 discountTkInput.disabled=false; discountPerInput.disabled=false;
 discountTkInput.style.background=""; discountPerInput.style.background="";
}
function removeRow(btn){ btn.closest("tr").remove(); }
</script>
</body>
</html>
