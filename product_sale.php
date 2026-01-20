<?php
include 'server_connection.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    if (isset($_POST['sale_submit'])) {

        // ✅ সব query একসাথে safe রাখার জন্য Transaction
        $conn->begin_transaction();

        $employee_id  = intval($_POST['sale_by']);
        $branch_id    = intval($_POST['sale_from']);
        $customer_id  = intval($_POST['customer']);
        $sale_date    = date('Y-m-d', strtotime($_POST['sale_date']));
        $paid_amount  = floatval($_POST['paid_amount']);
        $discount_all = floatval($_POST['discount'] ?? 0);
        $desc         = 'Sale entry via form';

        // ✅ Invoice Number Generate
        $year = date('Y');
        $result = $conn->query("SELECT invoice_no FROM invoices WHERE invoice_no LIKE 'MS-$year-%' ORDER BY id DESC LIMIT 1");

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            preg_match('/MS-\d{4}-(\d+)/', $row['invoice_no'], $matches);
            $last = (int)($matches[1] ?? 0);
            $new  = $last + 1;
        } else {
            $new = 1;
        }

        $invoice_no = "MS-$year-" . str_pad($new, 4, '0', STR_PAD_LEFT);

        // ✅ Insert into invoices
        $stmt = $conn->prepare("
            INSERT INTO invoices 
            (invoice_no, employee_id, branch_id, sale_date, customer_id, paid_amount, discount, description)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "siisidds",
            $invoice_no,
            $employee_id,
            $branch_id,
            $sale_date,
            $customer_id,
            $paid_amount,
            $discount_all,
            $desc
        );
        $stmt->execute();
        $invoice_id = $conn->insert_id;

        // ✅ Prepared Statements
        $pnameStmt = $conn->prepare("SELECT product_name FROM products WHERE product_id = ?");

        $itemStmt = $conn->prepare("
            INSERT INTO invoice_items 
            (invoice_id, product_id, qty, unit_price, total_price, discount_tk, discount_per)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $saleStmt = $conn->prepare("
            INSERT INTO sales 
            (customer_id, employee_id, product_name, sale_amount, paid_amount, qty, unit, description, sale_date, invoice_no, branch_id, unit_price, discount_tk, discount_per, discount)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        // ✅ Total sale amount
        $total_sale_amount = 0;

        foreach ($_POST['product_id'] as $i => $product_id) {

            $product_id   = intval($product_id);
            $qty          = floatval($_POST['qty'][$i]);
            $unit_per     = $_POST['unit'][$i];
            $unit_price   = floatval($_POST['price'][$i]);
            $discount_tk  = floatval($_POST['discount_tk'][$i] ?? 0);
            $discount_per = floatval($_POST['discount_per'][$i] ?? 0);

            $base_total = $qty * $unit_price;

            // ✅ Item discount calculate
            $item_discount = 0;
            if ($discount_tk > 0) {
                $item_discount = $discount_tk;
            } elseif ($discount_per > 0) {
                $item_discount = ($base_total * $discount_per / 100);
            }

            $final_total = $base_total - $item_discount;

            // ✅ invoice_items insert
            $itemStmt->bind_param(
                "iiidddd",
                $invoice_id,
                $product_id,
                $qty,
                $unit_price,
                $final_total,
                $discount_tk,
                $discount_per
            );
            $itemStmt->execute();

            // ✅ grand total accumulate
            $total_sale_amount += $final_total;

            // ✅ product name fetch
            $pname = '';
            $pnameStmt->bind_param("i", $product_id);
            $pnameStmt->execute();
            $pnameRes = $pnameStmt->get_result();
            if ($rowP = $pnameRes->fetch_assoc()) {
                $pname = $rowP['product_name'];
            }

            // ✅ sales insert
            $saleStmt->bind_param(
                "iisdddssssidddi",
                $customer_id,
                $employee_id,
                $pname,
                $final_total,
                $paid_amount,
                $qty,
                $unit_per,
                $desc,
                $sale_date,
                $invoice_no,
                $branch_id,
                $unit_price,
                $discount_tk,
                $discount_per,
                $discount_all
            );
            $saleStmt->execute();
        }

        // ✅ Invoice-level discount apply
        $invoice_total_after_discount = $total_sale_amount - $discount_all;
        if ($invoice_total_after_discount < 0) {
            $invoice_total_after_discount = 0;
        }

        // ✅ statements insert (YOUR TABLE: party_type, party_id, created_at, credit, invoice_no)
        $party_type = "customer";

        $statementCredit = $conn->prepare("
            INSERT INTO statements (party_type, party_id, created_at, debit, credit, invoice_no)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $statementCredit->bind_param(
            "sisdds",
            $party_type,
            $customer_id,
            $sale_date,
            $paid_amount,
            $invoice_total_after_discount,
            $invoice_no
        );

        $statementCredit->execute();

        // ✅ সবকিছু ঠিক থাকলে COMMIT
        $conn->commit();

        echo "<script>window.location='invoice.php?invoice={$invoice_no}';</script>";
        exit;
    }

} catch (mysqli_sql_exception $e) {

    // ✅ Error হলে Rollback
    if (isset($conn)) {
        $conn->rollback();
    }

    echo "<h3 style='color:red;'>⚠️ Database Error:</h3><pre>{$e->getMessage()}</pre>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MS Corporation - Sale Entry</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-900">
<div class="max-w-7xl mx-auto px-4 py-6">

  <!-- Header -->
  <div class="flex items-center justify-between gap-3 mb-6">
    <h1 class="text-2xl md:text-3xl font-bold tracking-tight">Product Sale Entry</h1>
    <div class="hidden md:flex items-center gap-2 text-sm text-slate-500">
      <span class="px-3 py-1 bg-white border border-slate-200 rounded-full shadow-sm">MS Corporation</span>
    </div>
  </div>

  <form method="post" id="saleForm" class="space-y-6">

    <!-- ✅ Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

      <!-- LEFT SIDE -->
      <div class="space-y-6">

        <!-- Sale & Customer -->
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Sale & Customer</h3>
            <span class="text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Required</span>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-slate-600 mb-1">Sale By</label>
              <select name="sale_by" required
                class="w-full h-10 rounded-xl border border-slate-200 bg-white px-3 text-sm outline-none focus:ring-2 focus:ring-slate-900/10">
                <option value="">Select Employee</option>
                <?php
                $res = $conn->query("SELECT * FROM employees");
                while ($r = $res->fetch_assoc()) {
                    echo "<option value='{$r['employee_id']}'>{$r['name']}</option>";
                }
                ?>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-600 mb-1">Sale From</label>
              <select name="sale_from" required
                class="w-full h-10 rounded-xl border border-slate-200 bg-white px-3 text-sm outline-none focus:ring-2 focus:ring-slate-900/10">
                <option value="">Select Branch</option>
                <?php
                $br = $conn->query("SELECT * FROM branch");
                while ($r = $br->fetch_assoc()) {
                    echo "<option value='{$r['branch_id']}'>{$r['branch_name']}</option>";
                }
                ?>
              </select>
            </div>

            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-slate-600 mb-1">Customer</label>
              <select name="customer" required
                class="w-full h-10 rounded-xl border border-slate-200 bg-white px-3 text-sm outline-none focus:ring-2 focus:ring-slate-900/10">
                <option value="">Select Customer</option>
                <?php
                $cust = $conn->query("SELECT * FROM customers");
                while ($r = $cust->fetch_assoc()) {
                    echo "<option value='{$r['id']}'>{$r['name']}</option>";
                }
                ?>
              </select>
            </div>
          </div>
        </div>

        <!-- Billing -->
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Billing</h3>
            <span class="text-xs text-slate-500">Invoice meta</span>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label class="block text-sm font-medium text-slate-600 mb-1">Date</label>
              <input type="date" name="sale_date" required
                class="w-full h-10 rounded-xl border border-slate-200 bg-white px-3 text-sm outline-none focus:ring-2 focus:ring-slate-900/10">
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-600 mb-1">Paid Amount</label>
              <input type="number" name="paid_amount" step="0.01" placeholder="0.00"
                class="w-full h-10 rounded-xl border border-slate-200 bg-white px-3 text-sm outline-none focus:ring-2 focus:ring-slate-900/10">
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-600 mb-1">Total Discount</label>
              <input type="number" name="discount" step="0.01" placeholder="0.00"
                class="w-full h-10 rounded-xl border border-slate-200 bg-white px-3 text-sm outline-none focus:ring-2 focus:ring-slate-900/10">
            </div>
          </div>
        </div>

        <!-- Submit -->
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5">
          <button type="submit" name="sale_submit"
            class="w-full h-11 rounded-xl bg-slate-900 text-white font-semibold shadow hover:opacity-95 active:scale-[0.99] transition">
            Submit & Generate Invoice
          </button>
          <p class="text-xs text-slate-500 mt-2 text-center">
            All items will be saved and redirected to invoice page
          </p>
        </div>

      </div>

      <!-- RIGHT SIDE -->
      <div class="space-y-6">

        <!-- Add Product -->
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Add Product</h3>
            <span class="text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Cart</span>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-slate-600 mb-1">Product</label>
              <select id="productSelect"
                class="w-full h-10 rounded-xl border border-slate-200 bg-white px-3 text-sm outline-none focus:ring-2 focus:ring-slate-900/10">
                <option value="">Select Product</option>
                <?php
                $prod = $conn->query("SELECT * FROM products");
                while ($r = $prod->fetch_assoc()) {
                    echo "<option value='{$r['product_id']}' data-name='{$r['product_name']}'>{$r['product_name']}</option>";
                }
                ?>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-600 mb-1">Quantity</label>
              <input type="number" id="qtyInput" min="1" placeholder="1"
                class="w-full h-10 rounded-xl border border-slate-200 bg-white px-3 text-sm outline-none focus:ring-2 focus:ring-slate-900/10">
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-600 mb-1">Unit</label>
              <select id="unitInput"
                class="w-full h-10 rounded-xl border border-slate-200 bg-white px-3 text-sm outline-none focus:ring-2 focus:ring-slate-900/10">
                <option value="pcs">Pcs</option>
                <option value="pack">Pack</option>
                <option value="box">Box</option>
                <option value="carton">Carton</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-600 mb-1">Unit Price</label>
              <input type="number" id="priceInput" step="0.01" placeholder="0.00"
                class="w-full h-10 rounded-xl border border-slate-200 bg-white px-3 text-sm outline-none focus:ring-2 focus:ring-slate-900/10">
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-600 mb-1">Discount Tk</label>
              <input type="number" id="discount_tk" step="0.01" placeholder="0"
                class="w-full h-10 rounded-xl border border-slate-200 bg-white px-3 text-sm outline-none focus:ring-2 focus:ring-slate-900/10">
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-600 mb-1">Discount %</label>
              <input type="number" id="discount_per" step="0.01" placeholder="0"
                class="w-full h-10 rounded-xl border border-slate-200 bg-white px-3 text-sm outline-none focus:ring-2 focus:ring-slate-900/10">
            </div>

            <div class="md:col-span-2">
              <button class="w-full h-11 rounded-xl bg-white border border-slate-200 text-slate-900 font-semibold shadow-sm hover:bg-slate-50 active:scale-[0.99] transition"
                type="button" onclick="addRow()">
                Add To Cart
              </button>
            </div>
          </div>
        </div>

      </div>

      <!-- ✅ Cart Items (FULL WIDTH On Large Screen) -->
      <div class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200">
          <h3 class="text-lg font-semibold">Cart Items</h3>
          <p class="text-xs text-slate-500 mt-1">Added items will appear here before submitting.</p>
        </div>

        <div class="overflow-x-auto">
          <table id="productList" class="min-w-full text-sm">
            <thead class="bg-slate-50 text-slate-700">
              <tr class="text-left">
                <th class="px-4 py-3 font-semibold">Product</th>
                <th class="px-4 py-3 font-semibold">Qty</th>
                <th class="px-4 py-3 font-semibold">Unit</th>
                <th class="px-4 py-3 font-semibold">Price</th>
                <th class="px-4 py-3 font-semibold">Discount (Tk)</th>
                <th class="px-4 py-3 font-semibold">Discount (%)</th>
                <th class="px-4 py-3 font-semibold">Total</th>
                <th class="px-4 py-3 font-semibold text-right">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white"></tbody>
          </table>
        </div>
      </div>

    </div>

    <!-- Hidden inputs (cart থেকে অ্যাপেন্ড হবে) -->
    <div id="hiddenInputs"></div>

  </form>

</div>

<script>
const discountTkInput=document.getElementById("discount_tk");
const discountPerInput=document.getElementById("discount_per");

discountTkInput.addEventListener("input",function(){
  if(parseFloat(this.value)>0){
    discountPerInput.disabled=true; 
    discountPerInput.classList.add("bg-slate-100");
  } else { 
    discountPerInput.disabled=false; 
    discountPerInput.classList.remove("bg-slate-100");
  }
});

discountPerInput.addEventListener("input",function(){
  if(parseFloat(this.value)>0){
    discountTkInput.disabled=true; 
    discountTkInput.classList.add("bg-slate-100");
  } else { 
    discountTkInput.disabled=false; 
    discountTkInput.classList.remove("bg-slate-100");
  }
});

function addRow(){
  let pSel=document.getElementById("productSelect");
  let qty=parseFloat(document.getElementById("qtyInput").value);
  let price=parseFloat(document.getElementById("priceInput").value);
  let unit=document.getElementById("unitInput").value;
  let disTk=parseFloat(document.getElementById("discount_tk").value)||0;
  let disPer=parseFloat(document.getElementById("discount_per").value)||0;

  let tbody=document.querySelector("#productList tbody");
  if(!pSel.value||!qty||!price){ alert("সব ঘর পূরণ করুন!"); return; }

  let base=qty*price, total=base;
  if(disTk>0) total-=disTk; 
  else if(disPer>0) total-=(base*disPer/100);

  let row=document.createElement("tr");
  row.className="hover:bg-slate-50";
  row.innerHTML=`
    <td class="px-4 py-3 font-medium text-slate-900">${pSel.options[pSel.selectedIndex].dataset.name}</td>
    <td class="px-4 py-3">${qty}</td>
    <td class="px-4 py-3">${unit}</td>
    <td class="px-4 py-3">${price}</td>
    <td class="px-4 py-3">${disTk}</td>
    <td class="px-4 py-3">${disPer}</td>
    <td class="px-4 py-3 font-semibold">${total.toFixed(2)}</td>
    <td class="px-4 py-3 text-right">
      <button type="button"
        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-red-200 text-red-700 hover:bg-red-50"
        onclick="removeRow(this)">
        Remove
      </button>
    </td>
  `;
  tbody.appendChild(row);

  let hidden=document.getElementById("hiddenInputs");
  hidden.innerHTML += `
    <input type="hidden" name="product_id[]" value="${pSel.value}">
    <input type="hidden" name="qty[]" value="${qty}">
    <input type="hidden" name="unit[]" value="${unit}">
    <input type="hidden" name="price[]" value="${price}">
    <input type="hidden" name="discount_tk[]" value="${disTk}">
    <input type="hidden" name="discount_per[]" value="${disPer}">
  `;

  pSel.selectedIndex=0;
  document.getElementById("qtyInput").value="";
  document.getElementById("priceInput").value="";
  discountTkInput.value=""; discountPerInput.value="";
  discountTkInput.disabled=false; discountPerInput.disabled=false;
  discountTkInput.classList.remove("bg-slate-100");
  discountPerInput.classList.remove("bg-slate-100");
}

function removeRow(btn){
  btn.closest("tr").remove();
}
</script>

</body>
</html>
