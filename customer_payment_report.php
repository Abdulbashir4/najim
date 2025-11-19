<?php
// customer_payment_history.php
include 'server_connection.php';

$customer_id = isset($_GET['customer_id']) ? (int) $_GET['customer_id'] : 0;
if ($customer_id <= 0) {
    die("Invalid customer id");
}

// কাস্টমার ইনফো
$customer_sql = "SELECT * FROM customers WHERE customer_id = $customer_id";
$customer_res = $conn->query($customer_sql);
$customer = $customer_res->fetch_assoc();

// ইনভয়েস + পেমেন্ট হিস্টোরি
$sql = "
SELECT 
    i.id AS invoice_id,
    i.sale_date,
    i.invoice_no,

    SUM(s.sale_amount) AS invoice_total,

    i.paid_amount AS initial_paid,

    COALESCE((
        SELECT SUM(inst.amount_paid)
        FROM installments inst
        JOIN sales s2 ON s2.sale_id = inst.sale_id
        WHERE s2.invoice_no COLLATE utf8mb4_general_ci = i.invoice_no COLLATE utf8mb4_general_ci
    ), 0) AS installments_paid,

    (
        i.paid_amount +
        COALESCE((
            SELECT SUM(inst.amount_paid)
            FROM installments inst
            JOIN sales s2 ON s2.sale_id = inst.sale_id
            WHERE s2.invoice_no COLLATE utf8mb4_general_ci = i.invoice_no COLLATE utf8mb4_general_ci
        ), 0)
    ) AS total_paid,

    (
        SUM(s.sale_amount) -
        (
            i.paid_amount +
            COALESCE((
                SELECT SUM(inst.amount_paid)
                FROM installments inst
                JOIN sales s2 ON s2.sale_id = inst.sale_id
                WHERE s2.invoice_no COLLATE utf8mb4_general_ci = i.invoice_no COLLATE utf8mb4_general_ci
            ), 0)
        )
    ) AS current_due

FROM invoices i
LEFT JOIN sales s 
    ON s.invoice_no COLLATE utf8mb4_general_ci = i.invoice_no COLLATE utf8mb4_general_ci

WHERE i.customer_id = $customer_id

GROUP BY 
    i.id, i.sale_date, i.invoice_no, i.paid_amount

ORDER BY i.sale_date ASC;

";

$result = $conn->query($sql);

// গ্র্যান্ড টোটাল
$grand_invoice_total = 0;
$grand_total_paid    = 0;
$grand_total_due     = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MS Corporation</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<div class="payment_report">
    <div class="pay_header">
        <div class="pay_logo"><img src="image/logo.jpg" alt=""></div>
        <div class="pay_address">
            <h1>MS Corporation</h1>
        <p> <b>Address:</b> 21/A, Topkhana Road, <br> Mohbub Plaza, Dhaka-1000 <br> <b>Phone:</b> +880 1317-7227718</p>
        </div>
    </div>
    <hr><hr>
    <h1 class="cls07">Customer Payment Report</h1>
    <div class="pay_custo_detail">
        <h1 class="cls08">Customer ID: <?= htmlspecialchars($customer['customer_id'])?></h1>
        <p>Customer Name: <?= htmlspecialchars($customer['name'])?>
         <br> Address: <?= htmlspecialchars($customer['address'])?> <br>
          Phone:<?= htmlspecialchars($customer['phone'])?></p>
    </div>
    <table>
        <tr>
            <td>Date</td>
            <td>Invoice No</td>
            <td>Invoice Amount</td>
            <td>Paid</td>
            <td>Installment</td>
            <td>Due</td>
            <td>Balance</td>
        </tr>
        <?php while ($row = $result->fetch_assoc()): 
            $grand_invoice_total += $row['invoice_total'];
            $grand_total_paid    += $row['total_paid'];
            $grand_total_due     += $row['current_due'];
        ?>
       <tr>
            <td><?php echo htmlspecialchars($row['sale_date']); ?></td>
            <td style="text-align:left;"><?php echo htmlspecialchars($row['invoice_no']); ?></td>
            <td><?php echo number_format($row['invoice_total'], 2); ?></td>
            <td><?php echo number_format($row['initial_paid'], 2); ?></td>
            <td><?php echo number_format($row['installments_paid'], 2); ?></td>
            <td><?php echo number_format($row['total_paid'], 2); ?></td>
            <td><?php echo number_format($row['current_due'], 2); ?></td>
        </tr>
        <?php endwhile; ?>

        <tr>
            <th colspan="2">Total</th>
            <th><?php echo number_format($grand_invoice_total, 2); ?></th>
            <th colspan="2"></th>
            <th><?php echo number_format($grand_total_paid, 2); ?></th>
            <th><?php echo number_format($grand_total_due, 2); ?></th>
        </tr>
        
       
    </table>
    <div class="calculation">
        <div class="word_tk">
        <p>1 lack Tk matro</p>
        </div>
        <div class="some_tk">
            <p>Total Paid:104000 <br> Total Discount:5000 <br> Total Due:250130 <br> Net Balance:125400</p>
        </div>
    </div>
</div>


    <script src="script.js"></script>
</body>
</html>