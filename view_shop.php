<?php include 'server_connection.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body >
    <div class="bg-gray-100 p-4 lg:p-10">
<?php
// মোট প্রডাক্ট সংখ্যা
$result = $conn->query("SELECT COUNT(*) AS total_product FROM products");
$row = $result->fetch_assoc();
echo "<p class='text-2xl font-semibold'>Total Product: <b>" . $row['total_product'] . "</b></p>";
?>

<h3 class="flex justify-center text-2xl font-semibold mb-2">Products List</h3>
<div class="hidden lg:block">
<table class="border w-full">
    
    <tr class="bg-gray-200">
        <th class="border px-2 py-1">SL</th>
        <th class="border px-2 py-1">Product Name</th>
        <th class="border px-2 py-1">Model</th>
        <th class="border px-2 py-1">Brand</th>
        <th class="border px-2 py-1">Stock Available</th>
        <th class="border px-2 py-1">Total Sell</th>
        <th class="border px-2 py-1">Total Bye</th>
        <th class="border px-2 py-1">Product Code</th>
        <th class="border px-2 py-1">Action</th>
    </tr>
    <?php
$sql = "
SELECT 
    p.product_id,
    p.product_name,
    p.model,
    p.brand,
    COALESCE(SUM(b.qty), 0) AS total_buy_qty,
    COALESCE(SUM(s.qty), 0) AS total_sale_qty,
    (COALESCE(SUM(b.qty), 0) - COALESCE(SUM(s.qty), 0)) AS current_stock
FROM products p
LEFT JOIN bye_info b ON b.product_name = p.product_id
LEFT JOIN sales s ON s.product_name = p.product_name
GROUP BY p.product_id, p.product_name, p.model, p.brand
ORDER BY p.product_name ASC
";
$result = $conn->query($sql);

$sl = 1;
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td class='border px-2 py-1'>{$sl}</td>
        <td class='border px-2 py-1'>{$row['product_name']}</td>
        <td class='border px-2 py-1'>{$row['model']}</td>
        <td class='border px-2 py-1'>{$row['brand']}</td>
        <td class='border px-2 py-1'><b>{$row['current_stock']}</b></td>
        <td class='border px-2 py-1'>{$row['total_sale_qty']}</td>
        <td class='border px-2 py-1'>{$row['total_buy_qty']}</td>
        <td class='border px-2 py-1'>{$row['product_id']}</td>
        <td class='border px-2 py-1'>
            <button class='px-4 rounded border bg-blue-200 mr-2 py-1' onclick=\"editData('products', '{$row['product_id']}')\">Edit</button>
            <button class='px-4 rounded border bg-red-200 ml-2 py-1' onclick=\"deleteData('products', '{$row['product_id']}')\">Delete</button>
        </td>
    </tr>";
    $sl++;
}
?>
</table>
</div>
<div class="block lg:hidden">
        <?php $sql = "SELECT p.product_id, p.product_name, p.model, p.brand,
    COALESCE(SUM(b.qty), 0) AS total_buy_qty,
    COALESCE(SUM(s.qty), 0) AS total_sale_qty,
    (COALESCE(SUM(b.qty), 0) - COALESCE(SUM(s.qty), 0)) AS current_stock
    FROM products p
    LEFT JOIN bye_info b ON b.product_name = p.product_id
    LEFT JOIN sales s ON s.product_name = p.product_name
    GROUP BY p.product_id, p.product_name, p.model, p.brand
    ORDER BY p.product_name ASC ";
    $result = $conn->query($sql);
            $sl = 1;
        while ($c = $result->fetch_assoc()) {
        echo "
        <table class='w-full border mb-6'>
        <tr>
            <th class='border text-start pl-3 w-3/8 py-1'>SL:</th>
            <td class='border text-start pl-3 w-3/8 py-1'>{$sl}</td>
        </tr>

        <tr>
        <th class='border text-start pl-3 w-3/8 py-1'>Product Name</th>
        <td class='border text-start pl-3 w-3/8 py-1'>{$c['product_name']}</td>
        </tr>

        <tr>
        <th class='border text-start pl-3 w-3/8 py-1'>Model</th>
        <td class='border text-start pl-3 w-3/8 py-1'>{$c['model']}</td>
        </tr>

        <tr>
        <th class='border text-start pl-3 w-3/8 py-1'>Brand</th>
        <td class='border text-start pl-3 w-3/8 py-1'>{$c['brand']}</td>
        </tr>
        <tr>
        <th class='border text-start pl-3 w-3/8 py-1'>Stock Available</th>
        <td class='border text-start pl-3 w-3/8 py-1'>{$c['current_stock']}</td>
        </tr>
        <tr>
        <th class='border text-start pl-3 w-3/8 py-1'>Action:</th>
        <td class='border text-start pl-3 w-3/8 py-1'>
        <button class='px-2 rounded border bg-blue-200 mr-2 py-1' onclick=\"editData('products', '{$c['product_id']}')\">Edit</button>
        <button class='px-2 rounded border bg-red-200 ml-2 py-1' onclick=\"deleteData('products', '{$c['product_id']}')\">Delete</button></td>
        </tr>
        
        ";
        $sl += 1;
    }
        ?>
    </table>
</div>
</div>
</body>
</html>

