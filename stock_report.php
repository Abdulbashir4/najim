<div class="page-content">

<?php include 'server_connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stock Report</title>
    
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3 class="mb-4">📊 Stock Report</h3>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Product Name</th>
                <th>Total In (Products)</th>
                <th>Total Out (Sales)</th>
                <th>Remaining Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT 
                        p.product_name,
                        p.qty AS total_in,
                        IFNULL(SUM(s.qty), 0) AS total_out,
                        (p.qty - IFNULL(SUM(s.qty),0)) AS remaining_stock
                    FROM products p
                    LEFT JOIN sales s ON p.product_name = s.product_name
                    GROUP BY p.product_name, p.qty";

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['product_name']}</td>
                            <td>{$row['total_in']}</td>
                            <td>{$row['total_out']}</td>
                            <td>{$row['remaining_stock']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>No Data Found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
</div>