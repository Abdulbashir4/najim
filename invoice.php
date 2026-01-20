<?php
include 'server_connection.php';

$invoice = trim($_GET['invoice'] ?? '');
if (!$invoice) die("❌ No invoice number provided!");

// ✅ Sale + Customer + Employee (Prepared)
$sql = "SELECT s.*, c.name AS customer_name, c.address AS customer_address, c.phone AS customer_phone,
        e.name AS employee_name
        FROM sales s
        LEFT JOIN customers c ON s.customer_id = c.id
        LEFT JOIN employees e ON s.employee_id = e.employee_id
        WHERE TRIM(s.invoice_no) = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $invoice);
$stmt->execute();
$sale_result = $stmt->get_result();

$sale = $sale_result->fetch_assoc();
if (!$sale) {
    die("❌ No sale found with invoice $invoice");
}

// ✅ Sales Items (Prepared + TRIM)
$items_sql = "SELECT * FROM sales WHERE TRIM(invoice_no) = ?";
$item_stmt = $conn->prepare($items_sql);
$item_stmt->bind_param("s", $invoice);
$item_stmt->execute();
$sales_items = $item_stmt->get_result();

/* ============================================================
   ✅ 100% Accurate Due System (Statements ভিত্তিক)
   ------------------------------------------------------------
   Previous Due = আগের সব credit - আগের সব debit (এই invoice বাদে)
   Current Due  = এই invoice credit - এই invoice debit
   Total Due    = Previous + Current
   ============================================================ */

// ⚠️ আপনার statements টেবিলে invoice column নাম: invoide_no
$invoiceCol  = "invoice_no";
$customer_id = intval($sale['customer_id']);

// ✅ Previous Due (excluding this invoice)
$prevStmt = $conn->prepare("
    SELECT 
        COALESCE(SUM(credit),0) AS total_credit,
        COALESCE(SUM(debit),0)  AS total_debit
    FROM statements
    WHERE party_type='customer'
      AND party_id = ?
      AND TRIM($invoiceCol) <> ?
");
$prevStmt->bind_param("is", $customer_id, $invoice);
$prevStmt->execute();
$prevRow = $prevStmt->get_result()->fetch_assoc();

$previous_due = floatval($prevRow['total_debit']) - floatval($prevRow['total_credit']);
if ($previous_due < 0) $previous_due = 0;

// ✅ Current Due (only this invoice)
$curStmt = $conn->prepare("
    SELECT 
        COALESCE(SUM(credit),0) AS inv_credit,
        COALESCE(SUM(debit),0)  AS inv_debit
    FROM statements
    WHERE party_type='customer'
      AND party_id = ?
      AND TRIM($invoiceCol) = ?
");
$curStmt->bind_param("is", $customer_id, $invoice);
$curStmt->execute();
$curRow = $curStmt->get_result()->fetch_assoc();

$current_credit = floatval($curRow['inv_credit']);
$current_debit  = floatval($curRow['inv_debit']);

$current_due = $current_credit - $current_debit;
if ($current_due < 0) $current_due = 0;

$total_due = $previous_due + $current_due;

// ✅ Paid amount (Invoice wise) -> statements debit থেকে
$paid_amount = $current_debit;

// Totals used for display (items থেকে)
$grand_total = 0;
$total_discount = 0;
$all_discount = 0; // invoice level discount (sales.discount থেকে ধরছি)
?>

<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <title>Invoice</title>
  <style>
    html, body { height: 100%; }
    body { display: flex; flex-direction: column; min-height: 100vh; }

    /* footer সবসময় নিচে থাকবে */
    footer { display: flex; position: absolute; gap: 82%; bottom: 50px; }

    .invoice-box {
      max-width: 900px;
      height: max-content;
      margin: auto;
      flex: 1;
      padding: 20px;
      border: 1px solid #ddd;
      background: #fff;
      position: relative;
    }
    .invoice-box hr{ margin-top:-20px; margin-bottom: 25px; }

    header { display: flex; margin-bottom: 20px; }
    header .logo img{ height:150px; width: 300px; }

    .company { font-size: 35px; font-weight: bold; }
    .details { text-align: left; padding: 15px 20px; }

    table { width: 100%; border-collapse: collapse; }
    table, th, td { border: 1px solid #444; }
    th, td { padding: 8px; text-align: left; }
    th { background: #f2f2f2; }
    .right { text-align: right; }

    .totals { float: right; width: 350px; }
    .totals table { border: 1px solid #444; }

    .note { width: 50%; font-weight: bold; }
    .cus_info{ margin-bottom: 15px; }
    .cus_info table{ max-width: 70%; min-width: 50%; margin-top: 32px; }

    .print-btn { margin-bottom:20px; text-align: center; }
    .print-btn button {
      padding: 10px 20px;
      font-size: 16px;
      background: #0b6ea6;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .print-btn button:hover { background: #094f77; }

    .col1{ width: 300px; }

    @media print {
      body { margin: 0; background: #fff; }
      .invoice-box {
        border: none; box-shadow: none;
        margin: 0; padding: 20mm;
        width: 210mm; min-height: 297mm;
      }
      .print-btn { display: none; }
    }

    @page { size: A4; margin: 10mm; }
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
        <img src="image/logo.jpg" alt="logo">
      </div>

      <div class="details">
        <div><strong>Invoice No:</strong> <?= htmlspecialchars($invoice) ?></div>
        <div><strong>Date:</strong> <?= htmlspecialchars($sale['sale_date']) ?></div>
        <div><strong>Bill By:</strong> <?= htmlspecialchars($sale['employee_name']) ?></div>
        <div><strong>Sale By:</strong> <?= htmlspecialchars($sale['employee_name']) ?></div>
      </div>
    </header>

    <hr><hr>

    <section style="margin-bottom:20px;">
      <strong>Bill To:</strong><br>
      <b> Name: </b><?= htmlspecialchars($sale['customer_name']) ?><br>
      <b>Address: </b><?= htmlspecialchars($sale['customer_address']) ?><br>
      <b>Phone:</b> <?= htmlspecialchars($sale['customer_phone']) ?>
    </section>

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

      while ($row = $sales_items->fetch_assoc()) {
          $qty        = floatval($row['qty']);
          $unit_price = floatval($row['unit_price']);
          $total      = $qty * $unit_price;

          // invoice-level discount (same value repeated থাকে, তাই একবার রাখছি)
          $all_discount = floatval($row['discount'] ?? 0);

          // item discount
          $discount_amount = 0;
          $discount_label = '0';

          if (floatval($row['discount_tk']) > 0) {
              $discount_amount = floatval($row['discount_tk']);
              $discount_label = number_format($discount_amount, 2) . " Tk";
          } elseif (floatval($row['discount_per']) > 0) {
              $discount_amount = $total * (floatval($row['discount_per']) / 100);
              $discount_label = number_format($row['discount_per'], 2) . " %";
          }

          $subTotal = $total - $discount_amount;

          $grand_total += $subTotal;
          $total_discount += $discount_amount;

          echo "<tr>
              <td>{$sl}</td>
              <td>" . htmlspecialchars($row['product_name']) . "</td>
              <td>" . htmlspecialchars($row['qty']) . "</td>
              <td>" . htmlspecialchars($row['unit']) . "</td>
              <td>" . number_format($row['unit_price'], 2) . "</td>
              <td>{$discount_label}</td>
              <td>" . number_format($subTotal, 2) . "</td>
          </tr>";

          $sl++;
      }

      // invoice net total from items
      $net_total = $grand_total - $all_discount;
      if ($net_total < 0) $net_total = 0;
      ?>
    </table>

    <div class="totals">
      <table>
        <tr>
          <td>Sub Total</td>
          <td class="right"><?= number_format($grand_total, 2) ?></td>
        </tr>
        <tr>
          <td>Total Discount</td>
          <td class="right">- <?= number_format($all_discount, 2) ?></td>
        </tr>
        <tr>
          <td><b>Grand Total</b></td>
          <td class="right"><b><?= number_format($net_total, 2) ?></b></td>
        </tr>
        <tr>
          <td>Paid</td>
          <td class="right"><?= number_format($paid_amount, 2) ?></td>
        </tr>
        <tr>
          <td><b>Due</b></td>
          <td class="right"><b><?= number_format($current_due, 2) ?></b></td>
        </tr>
      </table>
    </div>

    <div class="note">
      <div class="cus_info">
        <table>
          <tr>
            <td>Previous Due:</td>
            <td><?= number_format($previous_due, 2) ?></td>
          </tr>
          <tr>
            <td>Current Due:</td>
            <td><?= number_format($current_due, 2) ?></td>
          </tr>
          <tr>
            <td>Total Due:</td>
            <td><?= number_format($total_due, 2) ?></td>
          </tr>
        </table>
      </div>

      <span>In Words: <?= convert_number_to_words($total_due) ?> Taka only</span>
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
function convert_number_to_words($number) {
    $formatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
    return ucfirst($formatter->format($number));
}
?>
