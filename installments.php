<?php include 'server_connection.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Installments</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        table, th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
        a { text-decoration: none; color: blue; }
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
            transition: opacity 0.5s ease, background-color 0.5s ease;
        }
    </style>
</head>
<body>
<?php include 'header_and_sidebar_for_admin.php' ?>
<div class="main">
<div class="for_content" id="contentArea">
<div class="for_pc">

<h2>Installments History</h2>

<table>
    <tr>
        <th>No</th>
        <th>Amount Paid</th>
        <th>Payment Date</th>
        <th>Notes</th>
        <th>Action</th>
    </tr>
    <?php
    $sale_id = $_GET['sale_id'];
    $sql = "SELECT * FROM installments WHERE sale_id=$sale_id ORDER BY installment_no ASC";
    $installments = $conn->query($sql);

    $inst_sql = "SELECT SUM(amount_paid) as total_paid FROM installments WHERE sale_id=$sale_id";
    $inst_res = $conn->query($inst_sql);
    $inst_row = $inst_res->fetch_assoc();
    $total_paid = $inst_row['total_paid'] ?? 0;

    while ($i = $installments->fetch_assoc()) {
        echo "<tr id='row_{$i['installment_id']}'>
            <td>{$i['installment_no']}</td>
            <td>{$i['amount_paid']}</td>
            <td>{$i['payment_date']}</td>
            <td>{$i['notes']}</td>
            <td>
                <button class='edit btn' onclick=\"editData('installments', '{$i['installment_id']}')\">Edit</button>
                <button class='delete btn' onclick=\"deleteData('installments', '{$i['installment_id']}')\">Delete</button>
            </td>
        </tr>";
    }
    ?>
</table>

<h2><?php echo "Total Paid: " . $total_paid; ?></h2>
</div>
<div class="for_phone">
    <?php 
    $sale_id = $_GET['sale_id'];

    $sql = "SELECT * FROM installments WHERE sale_id=$sale_id ORDER BY installment_no ASC";
    $installments = $conn->query($sql);

    $inst_sql = "SELECT SUM(amount_paid) as total_paid FROM installments WHERE sale_id=$sale_id";
    $inst_res = $conn->query($inst_sql);
    $inst_row = $inst_res->fetch_assoc();
    $total_paid = $inst_row['total_paid'] ?? 0;


    while ($i = $installments->fetch_assoc()) {
        echo "
        <table>
        <tr id='row_{$i['installment_id']}'>
        <th>NO</th>
        <td>{$i['installment_no']}</td>
        </tr>
        <tr>
        <th>Amount Paid</th>
        <td>{$i['amount_paid']}</td>
        </tr>
        <tr>
        <th>Payment Date</th>
        <td>{$i['payment_date']}</td>
        </tr>
        <tr>
        <th>Notes</th>
        <td>{$i['notes']}</td>
        </tr id='row_{$i['installment_id']}'>
        <th>Notes</th>
        <td>
            <button class='edit btn' onclick=\"editData('installments', '{$i['installment_id']}')\">Edit</button>
            <button class='delete btn' onclick=\"deleteData('installments', '{$i['installment_id']}')\">Delete</button>
        </td>
        </tr>
        </table>";
    }

    ?>
</div>
</div>
</div>
<script>
function editData(table, id) {
    window.location = 'edit.php?table=' + table + '&id=' + id;
}

function deleteData(table, id) {
    if(confirm("Are you sure you want to delete this record?")) {
        // AJAX দিয়ে ডিলিট রিকোয়েস্ট পাঠানো হচ্ছে
        fetch('delete.php?table=' + table + '&id=' + id)
        .then(response => response.text())
        .then(result => {
            if(result.trim() === 'success') {
                const row = document.getElementById('row_' + id);
                row.classList.add('deleted-row');
                setTimeout(() => row.remove(), 500); // fade-out effect
            } else {
                alert('❌ Delete failed: ' + result);
            }
        })
        .catch(err => alert('Error: ' + err));
    }
}
</script>

</body>
</html>
