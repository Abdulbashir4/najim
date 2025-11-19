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
    <title>Customer Payment History</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 900px; margin: 0 auto; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: right; }
        th { background: #f0f0f0; }
        td:first-child, th:first-child { text-align: left; }
        h2, h3 { margin: 5px 0; }
    </style>
</head>
<body>
<div class="container">
    <h2>Customer Payment History</h2>

    <h3>Customer Info</h3>
    <p>
        <strong>Name:</strong> <?= htmlspecialchars($customer['name']); ?><br>
        <strong>Address:</strong> <?php echo htmlspecialchars($customer['address']); ?><br>
        <strong>Phone:</strong> <?php echo htmlspecialchars($customer['phone']); ?>
    </p>

    <table>
        <tr>
            <th>Date</th>
            <th>Invoice No</th>
            <th>Invoice Amount</th>
            <th>Initial Paid</th>
            <th>Installments Paid</th>
            <th>Total Paid</th>
            <th>Current Due</th>
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

    <p>
        <strong>Final Due (Customer Balance):</strong>
        <?php echo number_format($grand_total_due, 2); ?>
    </p>
</div>
</body>
</html>
