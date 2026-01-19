<?php
require_once __DIR__ . "/../server_connection.php";

$party_type = $_GET['party_type'] ?? '';
$party_id   = $_GET['party_id'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date   = $_GET['end_date'] ?? '';

if (empty($party_type) || empty($party_id)) {
  die("Missing party_type or party_id");
}

/**
 * ✅ Party Info (Name/Phone/Address)
 * NOTE: আপনার customers/suppliers table এ phone,address না থাকলে,
 * নিচের query থেকে field বাদ দিয়ে দিন।
 */
$party = [
  "name" => "Unknown",
  "phone" => "",
  "address" => ""
];

if ($party_type === "customer") {
  $stmtP = $conn->prepare("SELECT name, phone, address FROM customers WHERE id=?");
  $stmtP->bind_param("i", $party_id);
  $stmtP->execute();
  $r = $stmtP->get_result()->fetch_assoc();
  if ($r) {
    $party["name"] = $r["name"] ?? "Unknown";
    $party["phone"] = $r["phone"] ?? "";
    $party["address"] = $r["address"] ?? "";
  }
  $stmtP->close();
} elseif ($party_type === "supplier") {
  $stmtP = $conn->prepare("SELECT name, phone, address FROM suppliers WHERE id=?");
  $stmtP->bind_param("i", $party_id);
  $stmtP->execute();
  $r = $stmtP->get_result()->fetch_assoc();
  if ($r) {
    $party["name"] = $r["name"] ?? "Unknown";
    $party["phone"] = $r["phone"] ?? "";
    $party["address"] = $r["address"] ?? "";
  }
  $stmtP->close();
}

$hasDate = (!empty($start_date) && !empty($end_date));
$startDT = $hasDate ? ($start_date . " 00:00:00") : "";
$endDT   = $hasDate ? ($end_date . " 23:59:59") : "";

/**
 * ✅ Opening Balance (Only when date filter)
 */
$opening_balance = 0;
if ($hasDate) {
  $stmtOpen = $conn->prepare("
    SELECT 
      COALESCE(SUM(debit),0) AS td,
      COALESCE(SUM(credit),0) AS tc
    FROM statements
    WHERE party_type=? AND party_id=? AND created_at < ?
  ");
  $stmtOpen->bind_param("sis", $party_type, $party_id, $startDT);
  $stmtOpen->execute();
  $openRow = $stmtOpen->get_result()->fetch_assoc();
  $stmtOpen->close();

  $opening_balance = ((float)$openRow["td"]) - ((float)$openRow["tc"]);
}

/**
 * ✅ Statement Rows load
 */
$sql = "
  SELECT id, created_at, pay_type, trx_type, debit, credit, description
  FROM statements
  WHERE party_type=? AND party_id=?
";
if ($hasDate) {
  $sql .= " AND created_at BETWEEN ? AND ? ";
}
$sql .= " ORDER BY created_at ASC, id ASC";

$stmt = $conn->prepare($sql);

if ($hasDate) {
  $stmt->bind_param("siss", $party_type, $party_id, $startDT, $endDT);
} else {
  $stmt->bind_param("si", $party_type, $party_id);
}

$stmt->execute();
$result = $stmt->get_result();

$total_debit = 0;
$total_credit = 0;
$running_balance = $opening_balance;

function money($n)
{
  return number_format((float)$n, 2, '.', '');
}
function dmy($dt)
{
  return date("d/m/Y", strtotime($dt));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Statement</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- ✅ A4 Multi-page Print CSS -->
  <style>
    @page{
      size: A4;
      margin: 12mm;
    }

    @media print{
      html, body{
        background: white !important;
        margin: 0 !important;
        padding: 0 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }

      .print-wrapper{
        margin: 0 !important;
        box-shadow: none !important;
        border: none !important;
        width: 100% !important;
      }

      .no-print{
        display: none !important;
      }

      table{
        width: 100% !important;
        border-collapse: collapse !important;
        page-break-after: auto;
      }

      thead{
        display: table-header-group; /* ✅ header repeat each page */
      }

      tfoot{
        display: table-footer-group;
      }

      tr{
        page-break-inside: avoid !important; /* ✅ row cut হবে না */
        break-inside: avoid !important;
      }

      td, th{
        page-break-inside: avoid !important;
        break-inside: avoid !important;
      }
    }
  </style>
</head>

<body class="bg-gray-100">

  <!-- ✅ Design SAME + print-wrapper added -->
  <div class="mx-20 my-10 border border-1 border-gray-200 shadow-xl bg-white print-wrapper">

    <div class="flex justify-between">
      <div class="p-10 ">
        <h1 class="block text-xl font-bold">MS Corporation</h1>
        <p>Address: 21/A, Topkhana Road,<br>
          Mohbub Plaza, Dhaka-1000 <br>
          Phone: +880 1317-227718</p>
      </div>

      <div class=" flex items-center h-40 w-80">
        <img class="h-full w-full" src="../image/logo.jpg" alt="">
      </div>

      <div class="p-10">
        <h1 class="block">Name : <?= htmlspecialchars($party["name"]) ?></h1>
        <h1>Phone: <?= htmlspecialchars($party["phone"]) ?></h1>
        <p><?= nl2br(htmlspecialchars($party["address"])) ?></p>

        <?php if ($hasDate): ?>
          <p class="text-sm mt-2 text-gray-700">
            Date: <?= htmlspecialchars($start_date) ?> to <?= htmlspecialchars($end_date) ?>
          </p>
        <?php else: ?>
          <p class="text-sm mt-2 text-gray-700">
            All Time Statement
          </p>
        <?php endif; ?>
      </div>
    </div>

    <hr class="border border-gray-400 mb-2 w-[95%] mx-auto">
    <hr class="border border-gray-400 w-[95%] mx-auto">

    <div class="flex p-10">

      <!-- ✅ thead/tbody used for multi-page header repeat -->
      <table class="w-screen">

        <thead>
          <tr>
            <th class="border border-1 border-gray-300 p-2">Date</th>
            <th class="border border-1 border-gray-300 p-2">Voucher Type</th>
            <th class="border border-1 border-gray-300 p-2">Debit</th>
            <th class="border border-1 border-gray-300 p-2">Credit</th>
            <th class="border border-1 border-gray-300 p-2">Balance</th>
          </tr>
        </thead>

        <tbody>

          <!-- ✅ Opening Balance row (Only when date filter) -->
          <?php if ($hasDate): ?>
            <tr class="bg-yellow-50 font-semibold">
              <td class="border border-1 border-gray-300 p-2" colspan="4">Opening Balance</td>
              <td class="border border-1 border-gray-300 p-2"><?= money($opening_balance) ?></td>
            </tr>
          <?php endif; ?>

          <?php while ($row = $result->fetch_assoc()):
            $debit = (float)$row["debit"];
            $credit = (float)$row["credit"];

            $total_debit += $debit;
            $total_credit += $credit;

            // ✅ Running Balance
            $running_balance = $running_balance + $debit - $credit;

            // ✅ Voucher Type text
            $voucher = $row["trx_type"] ?: ($row["pay_type"] ?: "Transaction");
          ?>
            <tr>
              <td class="border border-1 border-gray-300 p-2"><?= dmy($row["created_at"]) ?></td>
              <td class="border border-1 border-gray-300 p-2"><?= htmlspecialchars($voucher) ?></td>
              <td class="border border-1 border-gray-300 p-2"><?= money($debit) ?></td>
              <td class="border border-1 border-gray-300 p-2"><?= money($credit) ?></td>
              <td class="border border-1 border-gray-300 p-2"><?= money($running_balance) ?></td>
            </tr>
          <?php endwhile; ?>

        </tbody>

        <tfoot>
          <?php
            $closing_balance = $opening_balance + $total_debit - $total_credit;
          ?>
          <tr class="bg-gray-100 font-bold">
            <td class="border border-1 border-gray-300 p-2" colspan="2">Total</td>
            <td class="border border-1 border-gray-300 p-2"><?= money($total_debit) ?></td>
            <td class="border border-1 border-gray-300 p-2"><?= money($total_credit) ?></td>
            <td class="border border-1 border-gray-300 p-2"><?= money($closing_balance) ?></td>
          </tr>
        </tfoot>

      </table>
    </div>

    <!-- ✅ Buttons (will not show in print/pdf) -->
    <div class="px-10 pb-10 flex justify-end gap-3 no-print">
      <a href="payment.php" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold">
        ← Back
      </a>
      <button onclick="window.print()" class="px-4 py-2 rounded-lg bg-gray-800 hover:bg-gray-900 text-white font-bold">
        Print
      </button>
    </div>

  </div>

</body>
</html>

<?php
$stmt->close();
?>
