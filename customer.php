<?php include 'server_connection.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Details</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        table, th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
        button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
        }
        .deleted-row {
            background-color: #ffb6b6;
            opacity: 0;
            transition: opacity 0.5s ease-out;
        }
    </style>
</head>
<body>
<?php include 'header_and_sidebar_for_admin.php'; ?>

<div class="main">
<div class="for_content" id="contentArea">

    <!-- 🖥️ For PC -->
    <div class="for_pc">
    <?php
    $id = $_GET['id'];
    $customer = $conn->query("SELECT * FROM customers WHERE customer_id=$id")->fetch_assoc();

    echo "<h2>{$customer['name']} - Details</h2>";
    echo "<p>Contact Person: {$customer['contact_person']} <br> <br> Phone: {$customer['phone']}</p>";
    ?>

    <h3>Sales History</h3>
    <table id="salesTable">
        <tr>
            <th>Sale ID</th>
            <th>Machine</th>
            <th>Total</th>
            <th>Paid</th>
            <th>Due</th>
            <th>Quantity</th>
            <th>Sale Date</th>
            <th>Details</th>
            <th>Action</th>
        </tr>
        <?php
        $sql = "SELECT * FROM sales WHERE customer_id=$id";
        $sales = $conn->query($sql);

        while ($s = $sales->fetch_assoc()) {
            echo "<tr id='row_{$s['sale_id']}'>
                <td>{$s['sale_id']}</td>
                <td>{$s['product_name']}</td>
                <td>{$s['sale_amount']}</td>
                <td>{$s['paid_amount']}</td>
                <td>{$s['due_amount']}</td>
                <td>{$s['qty']}</td>
                <td>{$s['sale_date']}</td>
                <td><a href='installments.php?sale_id={$s['sale_id']}'>More Details..</a></td>
                <td>
                    <button class='edit btn' onclick=\"editData('sales', '{$s['sale_id']}')\">Edit</button>
                    <button class='delete btn' onclick=\"deleteData('sales', '{$s['sale_id']}')\">Delete</button>
                </td>
            </tr>";
        }
        ?>
    </table>
    </div>

    <!-- 📱 For Phone -->
    <div class="for_phone">
    <?php
    echo "<h2>{$customer['name']} Statement</h2>
          <p>Contact Person: {$customer['contact_person']} <br> Phone: {$customer['phone']}</p><hr>";

    $sql = "SELECT * FROM sales WHERE customer_id=$id";
    $sales = $conn->query($sql);

    while ($s = $sales->fetch_assoc()) {
        echo "
        <table id='salesTable_{$s['sale_id']}' style='margin-bottom:30px; border:1px solid #ccc; border-collapse:collapse; width:100%;'>
            <tr><th>Sale ID</th><td>{$s['sale_id']}</td></tr>
            <tr><th>Product Name</th><td>{$s['product_name']}</td></tr>
            <tr><th>Paid</th><td>{$s['paid_amount']}</td></tr>
            <tr><th>Total</th><td>{$s['sale_amount']}</td></tr>
            <tr><th>Due</th><td>{$s['due_amount']}</td></tr>
            <tr><th>Quantity</th><td>{$s['qty']}</td></tr>
            <tr><th>Sale Date</th><td>{$s['sale_date']}</td></tr>
            <tr><th>More Btn</th><td><a href='installments.php?sale_id={$s['sale_id']}'>More Details..</a></td></tr>
            <tr><th>Action BTN</th>
                <td>
                    <button class='edit btn' onclick=\"editData('sales', '{$s['sale_id']}')\">Edit</button>
                    <button class='delete btn' onclick=\"deleteData('sales', '{$s['sale_id']}')\">Delete</button>
                </td>
            </tr>
        </table>";
    }
    ?>
    </div>

</div>
</div>

<script>
// 🧩 Edit বোতাম
function editData(table, id) {
    window.location = 'edit.php?table=' + table + '&id=' + id;
}

// 🧩 Delete বোতাম (দুই ভিউ-এর জন্য একটাই ফাংশন)
function deleteData(table, id) {
    if (confirm("Are you sure you want to delete this record?")) {
        fetch('delete.php?table=' + table + '&id=' + id)
        .then(response => response.text())
        .then(result => {
            if (result.trim() === 'success') {
                // ✅ ১️⃣ প্রথমে PC ভিউর টেবিল থেকে রো খুঁজে মুছো
                const row = document.getElementById('row_' + id);
                if (row) {
                    row.classList.add('deleted-row');
                    setTimeout(() => row.remove(), 500);
                }

                // ✅ ২️⃣ তারপর ফোন ভিউর আলাদা টেবিল খুঁজে মুছো
                const phoneTable = document.getElementById('salesTable_' + id);
                if (phoneTable) {
                    phoneTable.classList.add('deleted-row');
                    setTimeout(() => phoneTable.remove(), 500);
                }

            } else {
                alert('❌ Delete failed: ' + result);
            }
        })
        .catch(err => alert('⚠️ Error: ' + err));
    }
}
</script>

</body>
</html>
