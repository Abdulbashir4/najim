<?php
require_once __DIR__ . "/../server_connection.php";

$err = "";

// dropdown data
$customers = [];
$suppliers = [];

$customer_q = $conn->query("SELECT id, name FROM customers ORDER BY name ASC");
while($row = $customer_q->fetch_assoc()){
  $customers[] = $row;
}

$supplier_q = $conn->query("SELECT id, name FROM suppliers ORDER BY name ASC");
while($row = $supplier_q->fetch_assoc()){
  $suppliers[] = $row;
}

// save
if($_SERVER["REQUEST_METHOD"] === "POST"){

  $party_type  = $_POST["party_type"] ?? "";   // customer/supplier
  $party_id    = $_POST["party_id"] ?? "";
  $pay_type    = $_POST["pay_type"] ?? "";
  $trx_type    = $_POST["trx_type"] ?? "";     // paid/due
  $amount      = $_POST["amount"] ?? "";
  $description = $_POST["description"] ?? "";

  // ✅ Auto Debit / Credit
  $debit = 0;
  $credit = 0;

  if($trx_type === "paid"){
    $debit = $amount;
    $credit = 0;
  }elseif($trx_type === "due"){
    $credit = $amount;
    $debit = 0;
  }

  // validation
  $allowed_party = ["customer","supplier"];
  $allowed_trx   = ["paid","due"];
  $allowed_pay   = ["Cash","Bkash","Bank Account"];

  if(!in_array($party_type, $allowed_party)){
    $err = "Invalid party type!";
  }elseif(empty($party_id)){
    $err = "Please select Customer/Supplier name.";
  }elseif(!in_array($trx_type, $allowed_trx)){
    $err = "Invalid transaction type!";
  }elseif(!in_array($pay_type, $allowed_pay)){
    $err = "Invalid payment type!";
  }elseif(!is_numeric($amount) || $amount <= 0){
    $err = "Amount must be greater than 0!";
  }else{

    $stmt = $conn->prepare("
      INSERT INTO statements (party_type, party_id, pay_type, trx_type, debit, credit, description) 
      VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sissdds", $party_type, $party_id, $pay_type, $trx_type, $debit, $credit, $description);

    if($stmt->execute()){
    }else{
      $err = "Insert Failed: " . $stmt->error;
    }
    $stmt->close();
  }
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Payment Form</title>
</head>

<body class="bg-gray-100">
<div class=" mx-auto p-6 mt-6 mb-10 flex justify-between">
  <div class="bg-white border border-gray-300 rounded-2xl p-6 w-7/12">
    <h1 class="text-2xl font-bold text-gray-800 mb-4 flex justify-center">Payment Form</h1>

    <?php if(!empty($err)): ?>
      <div class="mb-4 p-3 rounded-xl bg-red-100 text-red-800 font-semibold">
        <?= htmlspecialchars($err) ?>
      </div>
    <?php endif; ?>

    <form action="" method="POST" class="space-y-4">

      <!-- Party Type -->
      <div>
        <label class="text-sm font-semibold text-gray-700">Customer Or Supplier</label>
        <select class="mt-1 w-full border rounded-xl px-3 py-2" name="party_type" id="party_type" required>
          <option value="customer">Customer</option>
          <option value="supplier">Supplier</option>
        </select>
      </div>

      <!-- Party Name -->
      <div class="flex gap-3 items-end">
  <div class="w-1/2">
    <label class="text-sm font-semibold text-gray-700" id="party_label">Customer Name</label>
    <select name="party_id" id="party_id" required class="mt-1 w-full border rounded-xl px-3 py-2"></select>
  </div>

  <div class="w-1/2">
    <label class="text-sm font-semibold text-gray-700">Customer Search</label>
    <input type="text" id="party_search"
      class="mt-1 w-full border rounded-xl px-3 py-2"
      placeholder="Search customer/supplier...">
  </div>
</div>


      <!-- Transaction Type Paid / Due -->
      <div>
        <select name="trx_type" id="trx_type" required class="hidden">
          <option value="paid"></option>
        </select>
      </div>

      <!-- Payment Type -->
      <div>
        <label class="text-sm font-semibold text-gray-700">Payment Type</label>
        <select name="pay_type" required class="mt-1 w-full border rounded-xl px-3 py-2">
          <option value="">-- Select Pay Method --</option>
          <option value="Cash">Cash</option>
          <option value="Bkash">Bkash</option>
          <option value="Bank Account">Bank Account</option>
        </select>
      </div>

      <!-- Amount -->
      <div>
        <label class="text-sm font-semibold text-gray-700" id="amount_label">Amount</label>
        <input type="number" name="amount" id="amount" required min="1" class="mt-1 w-full border rounded-xl px-3 py-2">
        <p class="text-xs text-gray-500 mt-1" id="amount_hint">Select Paid or Due first</p>
      </div>

      <!-- Description -->
      <div>
        <label class="text-sm font-semibold text-gray-700">Description</label>
        <textarea name="description" class="mt-1 w-full h-32 border rounded-xl px-3 py-2"></textarea>
      </div>

      <button class="w-full px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold">
        Save
      </button>
    </form>
  </div>
  <!-- Balance Box -->
<div class="p-4 rounded-2xl border bg-gray-50 space-y-2 w-4/12">
  <div class="flex justify-between text-sm">
    <span class="font-semibold text-gray-700">Total Paid :</span>
    <span id="total_debit" class="font-bold text-gray-800">0</span>
  </div>

  <div class="flex justify-between text-sm">
    <span class="font-semibold text-gray-700">Total Due :</span>
    <span id="total_credit" class="font-bold text-gray-800">0</span>
  </div>

  <div class="h-px bg-gray-200"></div>

  <div class="flex justify-between text-sm">
    <span class="font-semibold text-gray-700">Current Balance:</span>
    <span id="current_balance" class="font-bold">0</span>
  </div>

  <div class="flex justify-between text-sm">
    <span class="font-semibold text-gray-700">New Balance (After Entry):</span>
    <span id="new_balance" class="font-bold">0</span>
  </div>

  <p class="text-xs text-gray-500" id="balance_note">Select party to view balance</p>

  <div class="grid grid-cols-2 gap-3 mt-3">
  <div>
    <label class="text-sm font-semibold text-gray-700">Start Date</label>
    <input type="date" id="start_date" class="mt-1 w-full border rounded-xl px-3 py-2">
  </div>
  <div>
    <label class="text-sm font-semibold text-gray-700">End Date</label>
    <input type="date" id="end_date" class="mt-1 w-full border rounded-xl px-3 py-2">
  </div>
</div>

<a id="view_statement_btn"
  class="block mt-4 text-center px-4 py-2 rounded-xl bg-gray-800 hover:bg-gray-900 text-white font-bold"
  href="statement.php">
  View Statement
</a>

</div>


<script>
  const customers = <?= json_encode($customers, JSON_UNESCAPED_UNICODE); ?>;
  const suppliers = <?= json_encode($suppliers, JSON_UNESCAPED_UNICODE); ?>;

  const partyType = document.getElementById("party_type");
  const partyId = document.getElementById("party_id");
  const partyLabel = document.getElementById("party_label");

  const trxType = document.getElementById("trx_type");
  const amountInput = document.getElementById("amount");
  const amountLabel = document.getElementById("amount_label");
  const amountHint = document.getElementById("amount_hint");

  // Balance UI
  const totalDebitEl = document.getElementById("total_debit");
  const totalCreditEl = document.getElementById("total_credit");
  const currentBalanceEl = document.getElementById("current_balance");
  const newBalanceEl = document.getElementById("new_balance");
  const balanceNoteEl = document.getElementById("balance_note");

  const partySearch = document.getElementById("party_search");
  const startDateEl = document.getElementById("start_date");
  const endDateEl = document.getElementById("end_date");
  const viewBtn = document.getElementById("view_statement_btn");

  let currentBalance = 0;

  function loadPartyOptions(type){
    partyId.innerHTML = "";

    const defaultOpt = document.createElement("option");
    defaultOpt.value = "";
    defaultOpt.textContent = type === "customer"
      ? "-- Select Customer Name --"
      : "-- Select Supplier Name --";
    partyId.appendChild(defaultOpt);

    partyLabel.textContent = type === "customer" ? "Customer Name" : "Supplier Name";
    const list = type === "customer" ? customers : suppliers;

    list.forEach(item => {
      const opt = document.createElement("option");
      opt.value = item.id;
      opt.textContent = item.name;
      partyId.appendChild(opt);
    });

    resetBalanceUI();
    buildStatementURL(); // ✅ party type change হলে statement url update হবে
  }

  function handleTrxUI(){
    if(trxType.value === "paid"){
      amountLabel.textContent = "Paid Amount";
      amountHint.textContent = "This amount will be saved as DEBIT (Paid)";
    } else if(trxType.value === "due"){
      amountLabel.textContent = "Due Amount";
      amountHint.textContent = "This amount will be saved as CREDIT (Due)";
    } else {
      amountLabel.textContent = "Amount";
      amountHint.textContent = "Enter amount";
    }
    updateNewBalance();
  }

  function resetBalanceUI(){
    totalDebitEl.textContent = "0";
    totalCreditEl.textContent = "0";
    currentBalanceEl.textContent = "0";
    newBalanceEl.textContent = "0";
    balanceNoteEl.textContent = "Select party to view balance";
    currentBalance = 0;
  }

  function formatMoney(num){
    return Number(num).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }

  function setBalanceColor(el, balance){
    el.classList.remove("text-green-700", "text-red-700", "text-gray-700");
    if(balance > 0){
      el.classList.add("text-green-700");
    }else if(balance < 0){
      el.classList.add("text-red-700");
    }else{
      el.classList.add("text-gray-700");
    }
  }

  async function fetchBalance(){
    const type = partyType.value;
    const id = partyId.value;

    if(!id){
      resetBalanceUI();
      return;
    }

    balanceNoteEl.textContent = "Loading balance...";

    try{
      // ✅ Date Filter send to balance_fetch.php (optional)
      const s = startDateEl ? startDateEl.value : "";
      const e = endDateEl ? endDateEl.value : "";

      let url = `balance_fetch.php?party_type=${encodeURIComponent(type)}&party_id=${encodeURIComponent(id)}`;
      if(s && e){
        url += `&start_date=${encodeURIComponent(s)}&end_date=${encodeURIComponent(e)}`;
      }

      const res = await fetch(url);
      const data = await res.json();

      if(!data.ok){
        resetBalanceUI();
        balanceNoteEl.textContent = "Failed to load balance";
        return;
      }

      totalDebitEl.textContent = formatMoney(data.total_debit);
      totalCreditEl.textContent = formatMoney(data.total_credit);

      currentBalance = Number(data.balance);

      currentBalanceEl.textContent = formatMoney(currentBalance);
      setBalanceColor(currentBalanceEl, currentBalance);

      if(currentBalance > 0){
        balanceNoteEl.textContent = "Receivable: party will pay you";
      }else if(currentBalance < 0){
        balanceNoteEl.textContent = "Payable: you will pay party";
      }else{
        balanceNoteEl.textContent = "Balanced: no due";
      }

      updateNewBalance();

    }catch(err){
      resetBalanceUI();
      balanceNoteEl.textContent = "Error loading balance";
      console.error(err);
    }
  }

  function updateNewBalance(){
    const amt = Number(amountInput.value || 0);
    let newBal = currentBalance;

    // Paid => + , Due => -
    if(trxType.value === "paid"){
      newBal = currentBalance + amt;
    }else if(trxType.value === "due"){
      newBal = currentBalance - amt;
    }

    newBalanceEl.textContent = formatMoney(newBal);
    setBalanceColor(newBalanceEl, newBal);
  }

  // ✅ Customer Search option filter
  if(partySearch){
    partySearch.addEventListener("input", function(){
      const keyword = this.value.toLowerCase().trim();
      const options = partyId.querySelectorAll("option");

      options.forEach((opt, index) => {
        if(index === 0) return; // placeholder skip
        opt.hidden = !opt.textContent.toLowerCase().includes(keyword);
      });
    });
  }

  // ✅ View Statement URL Builder
  function buildStatementURL(){
    if(!viewBtn) return;

    const type = partyType.value;
    const id = partyId.value;
    const s = startDateEl ? startDateEl.value : "";
    const e = endDateEl ? endDateEl.value : "";

    if(!id){
      viewBtn.href = "#";
      viewBtn.classList.add("opacity-50", "pointer-events-none");
      viewBtn.textContent = "Select party first";
      return;
    }

    viewBtn.classList.remove("opacity-50", "pointer-events-none");
    viewBtn.textContent = "View Statement";

    // ✅ IMPORTANT: absolute path (Not Found problem fix)
    const base = "/najim/bill%20and%20account/statement.php";

    const params = new URLSearchParams();
    params.set("party_type", type);
    params.set("party_id", id);
    if(s) params.set("start_date", s);
    if(e) params.set("end_date", e);

    viewBtn.href = `${base}?${params.toString()}`;
  }

  // ✅ click করলে iframe এর ভিতরে open হবে (admin.php এর content_frame)
  if(viewBtn){
    viewBtn.addEventListener("click", function(e){
      e.preventDefault();
      if(viewBtn.href && viewBtn.href !== "#"){
        window.location.href = viewBtn.href; // ✅ iframe এর ভিতরেই লোড হবে
      }
    });
  }

  // initial
  loadPartyOptions(partyType.value);
  handleTrxUI();
  buildStatementURL();

  // events
  partyType.addEventListener("change", () => loadPartyOptions(partyType.value));

  partyId.addEventListener("change", () => {
    fetchBalance();
    buildStatementURL();
  });

  trxType.addEventListener("change", handleTrxUI);
  amountInput.addEventListener("input", updateNewBalance);

  if(startDateEl) startDateEl.addEventListener("change", () => { fetchBalance(); buildStatementURL(); });
  if(endDateEl) endDateEl.addEventListener("change", () => { fetchBalance(); buildStatementURL(); });
</script>



</body>
</html>
