<?php include 'server_connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MS Corporation</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">
  <div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">

      <!-- Alerts -->
      <div id="alertBox" class="hidden mb-4 p-3 rounded-lg text-sm font-medium"></div>

      <!-- Filter Section -->
      <div class="bg-white rounded-xl shadow p-5 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">

          <select id="filterPartyType"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="Supplier">Supplier Payment</option>
            <option value="Customer">Customer Payment</option>
          </select>

          <input type="text" id="filterName" placeholder="Search Name"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />

          <input type="date" id="filterFrom"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />

          <input type="date" id="filterTo"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>
      </div>

      <!-- FORM -->
      <form id="paymentForm" class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        <!-- LEFT -->
        <div class="bg-white rounded-xl shadow p-6">
          <h2 class="text-lg font-semibold mb-4">Customer / Supplier Info</h2>

          <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
            <tbody>

              <tr class="border-b">
                <th class="w-20 text-left bg-gray-50 px-4 py-3 font-medium">Party Type</th>
                <td class="px-4 py-3">
                  <select id="party_type" name="party_type"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="Supplier">Supplier</option>
                    <option value="Customer">Customer</option>
                  </select>
                </td>
              </tr>

              <tr class="border-b">
                <th class="text-left bg-gray-50 px-4 py-3 font-medium">Name</th>
                <td class="px-4 py-3">
                  <select id="party_id" name="party_id"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Loading...</option>
                  </select>
                </td>
              </tr>

              <tr class="border-b">
                <th class="text-left bg-gray-50 px-4 py-3 font-medium">Payment Type</th>
                <td class="px-4 py-3">
                  <select name="payment_type"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Select Payment Type</option>
                    <option value="Cash">Cash</option>
                    <option value="Bkash">Bkash</option>
                    <option value="Bank Account">Bank Account</option>
                    <option value="None">No pay</option>
                  </select>
                </td>
              </tr>

              <tr class="border-b">
                <th class="text-left bg-gray-50 px-4 py-3 font-medium">Due</th>
                <td class="px-4 py-3">
                  <input type="text" id="due_amount" name="due_amunt" readonly
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100"
                    placeholder="0.00" />
                </td>
              </tr>

              <tr>
                <th colspan="2" class="text-center bg-blue-50 text-blue-700 px-4 py-3 font-semibold">
                  WelCome TO Supplier Basir
                </th>
              </tr>

            </tbody>
          </table>
        </div>

        <!-- RIGHT -->
        <div class="bg-white rounded-xl shadow p-6">
          <h2 class="text-lg font-semibold mb-4">Payment Info</h2>

          <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
            <tbody>

              <tr class="border-b">
                <th class="w-20 text-left bg-gray-50 px-4 py-3 font-medium">Payment Date</th>
                <td class="px-4 py-3">
                  <input type="date" name="date"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2" />
                </td>
              </tr>

              <tr class="border-b">
                <th class="text-left bg-gray-50 px-4 py-3 font-medium">Description</th>
                <td class="px-4 py-3">
                  <textarea name="description"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2"
                    placeholder="Write description..."></textarea>
                </td>
              </tr>

              <tr class="border-b">
                <th class="text-left bg-gray-50 px-4 py-3 font-medium">Total Amount</th>
                <td class="px-4 py-3">
                  <input type="number" step="0.01" id="total_amount" name="total_amunt"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2" />
                </td>
              </tr>

              <tr class="border-b">
                <th class="text-left bg-gray-50 px-4 py-3 font-medium">Paid Amount</th>
                <td class="px-4 py-3">
                  <input type="number" step="0.01" id="paid_amount" name="paid_amunt" placeholder="0.00"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2" />

                </td>
              </tr>

              <tr>
                <td colspan="2" class="px-4 py-4">
                  <div class="flex gap-3 justify-end">
                    <button type="reset"
                      class="px-5 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition font-medium">
                      Clear
                    </button>
                    <button type="submit"
                      class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 transition text-white font-medium">
                      Submit
                    </button>
                  </div>
                </td>
              </tr>

            </tbody>
          </table>
        </div>

      </form>

      <!-- Transactions Table -->
      <div class="bg-white rounded-xl shadow p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
          <h2 class="text-lg font-semibold">Transactions</h2>

          <button id="reloadBtn"
            class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition font-medium">
            Reload
          </button>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full min-w-[900px] border border-gray-200 rounded-lg overflow-hidden">
            <thead>
              <tr class="bg-gray-100 text-sm uppercase text-gray-600">
                <th class="px-4 py-3 text-left">Name</th>
                <th class="px-4 py-3 text-left">Date</th>
                <th class="px-4 py-3 text-left">Description</th>
                <th class="px-4 py-3 text-left">Payment Type</th>
                <th class="px-4 py-3 text-left">Debit</th>
                <th class="px-4 py-3 text-left">Credit</th>
                <th class="px-4 py-3 text-left">Balance</th>
              </tr>
            </thead>
            <tbody id="paymentsTbody" class="text-sm">
              <tr><td class="px-4 py-4" colspan="7">Loading...</td></tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

  <script src="script.js"></script>
  <script>
document.addEventListener("DOMContentLoaded", () => {

  // Elements
  const partyType = document.getElementById("party_type");
  const partyId = document.getElementById("party_id");

  const total = document.getElementById("total_amount");
  const paid = document.getElementById("paid_amount");
  const due = document.getElementById("due_amount");

  const form = document.getElementById("paymentForm");
  const alertBox = document.getElementById("alertBox");
  const tbody = document.getElementById("paymentsTbody");

  const filterPartyType = document.getElementById("filterPartyType");
  const filterName = document.getElementById("filterName");
  const filterFrom = document.getElementById("filterFrom");
  const filterTo = document.getElementById("filterTo");
  const reloadBtn = document.getElementById("reloadBtn");

  // ===== Alert helper =====
  function showAlert(msg, type = "success") {
    alertBox.classList.remove(
      "hidden",
      "bg-green-100",
      "text-green-700",
      "bg-red-100",
      "text-red-700"
    );

    if (type === "success") alertBox.classList.add("bg-green-100", "text-green-700");
    if (type === "error") alertBox.classList.add("bg-red-100", "text-red-700");

    alertBox.textContent = msg;
    setTimeout(() => alertBox.classList.add("hidden"), 2500);
  }

  // ===== Due calculate =====
  function calcDue() {
    const t = parseFloat(total.value) || 0;
    const p = parseFloat(paid.value) || 0;
    let d = t - p;
    if (d < 0) d = 0;
    due.value = d.toFixed(2);
  }

  total.addEventListener("input", calcDue);
  paid.addEventListener("input", calcDue);

  // ===== Load parties from DB =====
  async function loadParties(type) {
    partyId.innerHTML = `<option value="">Loading...</option>`;

    try {
      const res = await fetch(`ajax/load_parties.php?type=${encodeURIComponent(type)}`);
      const data = await res.json();

      if (!data.success) {
        partyId.innerHTML = `<option value="">Error loading</option>`;
        return;
      }

      const opts = data.data
        .map(row => `<option value="${row.id}">${row.name}</option>`)
        .join("");

      partyId.innerHTML = `<option value="">Select Name</option>${opts}`;
    } catch (err) {
      partyId.innerHTML = `<option value="">Error loading</option>`;
    }
  }

  // party type change => load list
  partyType.addEventListener("change", () => {
    loadParties(partyType.value);
  });

  // ===== Load transactions table =====
  async function loadPayments() {
    tbody.innerHTML = `<tr><td class="px-4 py-4" colspan="7">Loading...</td></tr>`;

    const params = new URLSearchParams({
      party_type: filterPartyType.value,
      name: filterName.value,
      from: filterFrom.value,
      to: filterTo.value
    });

    try {
      const res = await fetch(`ajax/load_payments.php?${params.toString()}`);
      const data = await res.json();

      if (!data.success) {
        tbody.innerHTML = `<tr><td class="px-4 py-4 text-red-600" colspan="7">${data.message}</td></tr>`;
        return;
      }

      if (!data.data || data.data.length === 0) {
        tbody.innerHTML = `<tr><td class="px-4 py-4" colspan="7">No data found</td></tr>`;
        return;
      }

      // ✅ Running Balance
      let runningBalance = 0;

      tbody.innerHTML = data.data
        .map(r => {
          const debit = parseFloat(r.total_amunt) || 0;
          const credit = parseFloat(r.paid_amunt) || 0;

          runningBalance = runningBalance + debit - credit;

          return `
            <tr class="border-t hover:bg-gray-50 transition">
              <td class="px-4 py-3 whitespace-nowrap">${r.cus_or_supp_name}</td>
              <td class="px-4 py-3 whitespace-nowrap">${r.date}</td>
              <td class="px-4 py-3">${r.description ?? ""}</td>
              <td class="px-4 py-3">${r.payment_type}</td>
              <td class="px-4 py-3 font-semibold">${debit.toFixed(2)}</td>
              <td class="px-4 py-3 font-semibold">${credit.toFixed(2)}</td>
              <td class="px-4 py-3 font-semibold ${runningBalance >= 0 ? "text-green-600" : "text-red-600"}">
                ${runningBalance.toFixed(2)}
              </td>
            </tr>
          `;
        })
        .join("");

    } catch (err) {
      tbody.innerHTML = `<tr><td class="px-4 py-4 text-red-600" colspan="7">Fetch error</td></tr>`;
    }
  }

  // filter inputs => auto reload
  [filterPartyType, filterName, filterFrom, filterTo].forEach(el => {
    el.addEventListener("input", loadPayments);
    el.addEventListener("change", loadPayments);
  });

  reloadBtn.addEventListener("click", loadPayments);

  // ===== AJAX Submit Payment =====
  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const fd = new FormData(form);

    // ✅ paid empty => 0
    if (paid.value.trim() === "") {
      fd.set("paid_amunt", "0");
    }

    // ✅ due set
    fd.set("due_amunt", due.value);

    try {
      const res = await fetch("ajax/save_payment.php", {
        method: "POST",
        body: fd
      });

      const data = await res.json();

      if (data.success) {
        showAlert("✅ Payment saved successfully!", "success");
        form.reset();
        due.value = "0.00";
        loadParties(partyType.value);
        loadPayments();
      } else {
        showAlert("❌ " + (data.message || "Something went wrong"), "error");
      }
    } catch (err) {
      showAlert("❌ Server error / Network error", "error");
    }
  });

  // ===== Initial Load =====
  loadParties(partyType.value);
  loadPayments();
});
</script>

</body>
</html>
