<?php
include 'server_connection.php';

// 🔹 ইনভয়েস নম্বর নেওয়া
$invoice = $_GET['invoice'] ?? '';

if (!$invoice) {
    die("❌ No invoice number provided!");
}

$sql_bye = "SELECT b.*,sh.*,p.*, i.*
                FROM bye_info b
                LEFT JOIN shops sh ON b.shop_name = sh.id
                LEFT JOIN products p ON b.product_name = p.product_id
                LEFT JOIN invoices i ON b.invoice_no = i.invoice_no
                WHERE b.invoice_no = '$invoice'";


$sale_result = $conn->query($sql_bye);
if(!$sale_result) {
    die("Query Failed (Sales+Customer): " . $conn->error);
}

$sale = $sale_result->fetch_assoc();
if(!$sale) {
    die("No sale found with invoice $invoice");
}

// 🔹 Sales Items
$items_sql = "SELECT * FROM bye_info WHERE invoice_no = '$invoice'";
$sales_items = $conn->query($items_sql);
if(!$sales_items) {
    die("Query Failed (Sales Items): " . $conn->error);
}

$grand_total = 0;
$total_discount = 0;
?>
<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <title>Invoice</title>
  <style>
html, body {
  height: 100%;
}

body {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}



/* 🔽 footer সবসময় নিচে থাকবে */
footer {
  display: flex;
  position: absolute;
  gap: 82%;
  bottom: 50px;
}



    /* 🔸 তোমার আগের CSS অপরিবর্তিত রাখা হয়েছে */
    
    .invoice-box {
      max-width: 900px;
      height: max-content;
      margin: auto;
      flex: 1;
      padding: 20px;
      border: 1px solid #ddd;
      background: #fff;
    }
    .invoice-box hr{
      margin-top:-20px;
      margin-bottom: 25px;
    }
    header {
      display: flex;
      margin-bottom: 20px;
    }
    header .logo img{
      height:150px;
      width: 300px;
    }
    .company {
      font-size: 35px;
      font-weight: bold;
      width: ;
    }
    .details {
      text-align: left;
      padding: 15px 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    table, th, td {
      border: 1px solid #444;
    }
    th, td {
      padding: 8px;
      text-align: left;
    }
    th {
      background: #f2f2f2;
    }
    .right {
      text-align: right;
    }
    .totals {
      float: right;
      width: 350px;
    }
    .totals table {
      border: 1px solid #444;
    }
    .note {
      width: 50%;
      font-weight: bold;
    }
.cus_info{
  margin-bottom: 15px;
}
    .cus_info table{
      max-width: 70%;
      min-width: 50%;
      margin-top: 32px;
    }
    .print-btn {
      margin-bottom:20px;
      text-align: center;
    }
    .print-btn button {
      padding: 10px 20px;
      font-size: 16px;
      background: #0b6ea6;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .print-btn button:hover {
      background: #094f77;
    }
    .col1{
      width: 300px;
    }
    
.cls15{
  display: flex;
}
.cls16{
  width: 40%;
}
    @media print {
      body {
        margin: 0;
        background: #fff;
      }
      .invoice-box {
        border: none;
        box-shadow: none;
        margin: 0;
        padding: 20mm;
        width: 210mm;
        min-height: 297mm;
      }
      .print-btn {
        display: none;
      }
    }
    @page {
      size: A4;
      margin: 10mm;
    }
  </style>
</head>
<body>
  <div class="print-btn">
    <button class="print-btn" onclick="window.location.href='admin.php'">Back To Home</button>
    <button class="print-btn" onclick="window.print()">Print</button>
  </div>

  <div class="invoice-box">
    <header>
      <div class="col1">
        <div class="company">MS Corporation</div>
        <div>Address: 21/A, Topkhana Road,<br> Mohbub Plaza, Dhaka-1000</div>
        <div>Phone: +880 1317-227718</div>
      </div>
      <div class="logo">
        <img src="image/logo.jpg">
      </div>
      <div class="details">
        <div><strong>Invoice No:</strong> <?= htmlspecialchars($invoice) ?></div>
        <div><strong>Date:</strong> <?= htmlspecialchars($sale['sale_date']) ?></div>
        <!-- <div><strong>Bill By:</strong> <?= htmlspecialchars($sale['employee_name']) ?></div>
        <div><strong>Sale By:</strong> <?= htmlspecialchars($sale['employee_name']) ?></div> -->
      </div>
    </header>
  <hr>
  <hr>
  <div class="cls15">
    <div class="cls16">
      <section style="margin-bottom:20px;">
      <strong>Bill To:</strong><br>
      <b>Supplyer Name: </b><?= htmlspecialchars($sale['shop_name']) ?><br>
      <b>Address: </b><?= htmlspecialchars($sale['address']) ?><br>
      <b>Phone:</b> <?= htmlspecialchars($sale['phone']) ?>
    </section>

    </div>
    <div>
      <h1>Supplyer Invoice</h1>

    </div>
  </div>
    
    <table>
      <tr>
        <th>#</th>
        <th>Description</th>
        <th>Qty</th>
        <th>Unit</th>
        <th>Unit Price</th>
        <th>Disc:</th>
        <th>Total</th>
      </tr>
      <?php
      $sl = 1;
      $grand_total = 0;
      $total_discount = 0;

      while ($row = $sales_items->fetch_assoc()) {
          $qty = floatval($row['qty']);
          $unit_price = floatval($row['unit_price']);
          $total = $qty * $unit_price;

          // ডিসকাউন্ট বের করা
          $discount_amount = 0;
          $discount_label = '0';
          if ($row['discount_tk'] > 0) {
              $discount_amount = floatval($row['discount_tk']);
              $discount_label = number_format($row['discount_tk'], 2) . " Tk";
          } elseif ($row['discount_per'] > 0) {
              $discount_amount = $total * ($row['discount_per'] / 100);
              $discount_label = number_format($row['discount_per'], 2) . " %";
          }

          $subTotal = $total - $discount_amount;
          $grand_total += $subTotal;
          $total_discount += $discount_amount;

          echo "<tr>
              <td>{$sl}</td>
              <td>{$sale['product_name']}</td>
              <td>{$row['qty']}</td>
              <td>{$row['unit']}</td>
              <td>{$row['unit_price']}</td>
              <td>{$discount_label}</td>
              <td>" . number_format($subTotal, 2) . "</td>
          </tr>";
          $sl++;
      }
      ?>
    </table>
<?php 
$t_discount = $sale['discount'];
$total_grand = $grand_total - $t_discount ;
$paid = $sale['paid_amount'];
$due = $total_grand - $paid;

?>
    <div class="totals">
      <table>
        <tr>
          <td>Sub Total</td>
          <td class="right"><?= number_format($grand_total, 2) ?></td>
        </tr>
        <tr>
          <td>Total Discount</td>
          <td class="right">-<?= number_format($t_discount, 2) ?></td>
        </tr>
        <tr>
          <td><b>Grand Total</b></td>
          <td class="right"><b><?= number_format($total_grand, 2) ?></b></td>
        </tr>
        <tr>
          <td>Paid</td>
          <td class="right"><?= number_format($paid) ?></td>
        </tr>
        <tr>
          <td><b>Due</b></td>
          <td class="right"><b><?= number_format($due)?></b></td>
        </tr>
      </table>
    </div>

    <div class="note">
      
      <div class="cus_info">
        <table>
          <tr>
            <td>Previous Due:</td>
            <td>0.00</td>
          </tr>
          <tr>
            <td>Current Due:</td>
            <td><?= number_format($due)?></td>
          </tr>
          <tr>
            <td>Total Due:</td>
            <td></td>
          </tr>
        </table>
      </div>
      <span>In Words: <?= convert_number_to_words($due) ?> Taka only</span>
    </div>

    <footer>
      <div>For Customer<br><br>_____________</div>
      <div>Prepared By<br><br>_____________</div>
      <div>For Authority<br><br>_____________</div>
    </footer>
  </div>
</body>
</html>

<?php
// 🔢 সংখ্যা থেকে শব্দে রূপান্তর
function convert_number_to_words($number) {
    $formatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
    return ucfirst($formatter->format($number));
}
?>
