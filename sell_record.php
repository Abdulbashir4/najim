<?php include 'server_connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invoice List | MS Corporation</title>
<link rel="stylesheet" href="style.css">
<style>
/* 🔹 Compact & Clean UI */
.search-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
  gap: 10px;
}
.filter-group {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 5px;
}
input {
  padding: 5px 8px;
  border: 1px solid #bbb;
  border-radius: 4px;
  font-size: 14px;
}
.small-input {
  width: 130px;
}
#exactDate{
    width: 90%;
}
#fromDate{
width: 50%;
}
#toDate{
width: 50%;
}
button {
  padding: 6px 10px;
  border: none;
  background-color: #007bff;
  color: white;
  border-radius: 4px;
  cursor: pointer;
}
button:hover {
  background-color: #0056b3;
}
</style>
</head>
<body>

<div class="main">
<div class="for_content" id="contentArea">
    <?php
$cou = $conn->query("SELECT * FROM invoices")->num_rows;
?>


<h2><?= htmlspecialchars($cou) ?>  Invoices Record Found</h2>

<!-- 🔍 Search & Date Filters -->
<div class="search-container">
  <div class="filter-group">
    <input type="text" id="nameSearch" class="small-input" placeholder="Customer Name">
    <input type="text" id="invoiceSearch" class="small-input" placeholder="Invoice No">
    <input type="date" id="exactDate" class="small-input" title="Search by exact date">
  </div>
  <div class="filter-group">
    From: <input type="date" id="fromDate" class="small-input">
    To: <input type="date" id="toDate" class="small-input">
  </div>
</div>

<table id="invoiceTable">
  <thead>
    <tr>
      <th>SL</th>
      <th>Customer Name</th>
      <th>Invoice No</th>
      <th>Paid Amount</th>
      <th>Date</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
<?php
$sql = "SELECT i.*, c.name AS customer_name
        FROM invoices i
        LEFT JOIN customers c ON i.customer_id = c.id
        ORDER BY i.id DESC";
$result = $conn->query($sql);
$sl = 1;
while ($row = $result->fetch_assoc()) {
    // Convert date to DD-MM-YYYY
    $formatted_date = date("d-m-Y", strtotime($row['sale_date']));
    echo "
    <tr>
      <td>{$sl}</td>
      <td>{$row['customer_name']}</td>
      <td><a href='invoice.php?invoice={$row['invoice_no']}' style='text-decoration:none;color:#007bff;font-weight:bold;'>{$row['invoice_no']}</a></td>
      <td>{$row['paid_amount']}</td>
      <td>{$formatted_date}</td>
      <td>
        <button onclick=\"deleteData('invoices', '{$row['id']}')\">Delete</button>
      </td>
    </tr>
    ";
    $sl++;
}
?>
  </tbody>
</table>

</div>
</div>

<script>
// 🧠 Levenshtein (Typo tolerance for Name)
function levenshtein(a, b) {
  const matrix = Array.from({ length: a.length + 1 }, (_, i) => [i]);
  for (let j = 0; j <= b.length; j++) matrix[0][j] = j;
  for (let i = 1; i <= a.length; i++) {
    for (let j = 1; j <= b.length; j++) {
      matrix[i][j] = a[i - 1] === b[j - 1]
        ? matrix[i - 1][j - 1]
        : Math.min(
            matrix[i - 1][j - 1] + 1,
            matrix[i][j - 1] + 1,
            matrix[i - 1][j] + 1
          );
    }
  }
  return matrix[a.length][b.length];
}

// 🔹 Typo tolerant match (for name)
function smartMatch(a, b) {
  if (!a || !b) return false;
  a = a.toLowerCase();
  b = b.toLowerCase();
  if (b.length <= 1) return a.startsWith(b);
  if (b.length <= 3) return a.includes(b);
  if (b.length <= 6) return a.includes(b) || levenshtein(a, b) <= 1;
  return a === b || levenshtein(a, b) <= 2;
}

// 🔹 Invoice exact match only
function exactMatch(a, b) {
  if (!a || !b) return false;
  a = a.toLowerCase();
  b = b.toLowerCase();
  return a.startsWith(b) || a === b;
}

// 🔹 Convert DD-MM-YYYY ↔ YYYY-MM-DD
function normalizeDate(str) {
  if (!str) return '';
  const parts = str.split('-');
  if (parts.length === 3 && parts[0].length === 2) {
    return `${parts[2]}-${parts[1]}-${parts[0]}`; // convert to ISO
  }
  return str;
}
function toDisplayFormat(str) {
  if (!str) return '';
  const parts = str.split('-');
  if (parts.length === 3 && parts[0].length === 4) {
    return `${parts[2]}-${parts[1]}-${parts[0]}`; // convert YYYY-MM-DD → DD-MM-YYYY
  }
  return str;
}

// 🔹 Filter Function
function filterRows() {
  const nameValue = document.getElementById('nameSearch').value.toLowerCase().trim();
  const invoiceValue = document.getElementById('invoiceSearch').value.toLowerCase().trim();
  const exactDate = document.getElementById('exactDate').value.trim(); // ISO format from date picker
  const fromDate = document.getElementById('fromDate').value.trim();
  const toDate = document.getElementById('toDate').value.trim();

  const rows = document.querySelectorAll('#invoiceTable tbody tr');

  rows.forEach(row => {
    const name = row.cells[1].textContent.toLowerCase();
    const invoice = row.cells[2].textContent.toLowerCase();
    const displayDate = row.cells[4].textContent.trim();
    const date = normalizeDate(displayDate);

    const matchName = !nameValue || smartMatch(name, nameValue);
    const matchInvoice = !invoiceValue || exactMatch(invoice, invoiceValue);
    const matchExactDate = !exactDate || date === exactDate;

    let matchRange = true;
    if (fromDate && toDate) {
      matchRange = date >= fromDate && date <= toDate;
    }

    if (matchName && matchInvoice && matchExactDate && matchRange) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
}

// 🔄 Live Search Events
['nameSearch', 'invoiceSearch', 'exactDate', 'fromDate', 'toDate'].forEach(id => {
  document.getElementById(id).addEventListener('input', filterRows);
});
</script>

<script src="script.js"></script>
</body>
</html>
