<?php
include 'server_connection.php';

// Database check
$db_check = $conn->query("SELECT DATABASE()")->fetch_row()[0];
if (!$db_check) {
    die("Database connection error!");
}

// GET প্যারামিটার নিন
$table = $_GET['table'] ?? '';
$id    = $_GET['id'] ?? 0;

$table = $conn->real_escape_string($table);
$id    = (int)$id;

if (!$table || !$id) {
    die("Invalid request!");
}

// Allowed tables এবং primary key mapping
$allowed_tables = [
    'installments' => 'installment_id',
    'customers' => 'customer_id',
    'invoices' => 'id',
    // প্রয়োজনমতো আরও টেবিল এখানে যোগ করো
];

if (!array_key_exists($table, $allowed_tables)) {
    die("This table is not allowed!");
}

$primary_key = $allowed_tables[$table];

// টেবিল চেক
$check_table = $conn->query("SHOW TABLES LIKE '$table'");
if ($check_table->num_rows == 0) {
    die("Table '$table' does not exist!");
}

// Record বের করা
$sql = "SELECT * FROM `$table` WHERE `$primary_key` = $id";
$result = $conn->query($sql);

if (!$result) {
    die("SQL Error: " . $conn->error);
}

$data = $result->fetch_assoc();
if (!$data) {
    die("No record found!");
}

// POST হলে ডাটা আপডেট
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $update_fields = [];
    foreach ($_POST as $key => $value) {
        $value = $conn->real_escape_string($value);
        $update_fields[] = "`$key`='$value'";
    }

    $update_sql = "UPDATE `$table` SET " . implode(", ", $update_fields) . " WHERE `$primary_key`=$id";

    if ($conn->query($update_sql)) {
        echo "<script>
                alert('Record updated successfully!');
                window.history.back();
              </script>";
        exit;
    } else {
        die("Update Error: " . $conn->error);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Record</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        form { max-width: 400px; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0; }
        button { padding: 8px 12px; background: #3498db; border: none; border-radius: 5px; color: #fff; cursor: pointer; }
        button:hover { background: #2980b9; }
    </style>
</head>
<body>

<h2>Edit <?php echo ucfirst($table); ?> Record</h2>

<form method="POST">
    <?php
    foreach ($data as $column => $value) {
        if ($column === $primary_key) continue; // ID দেখাবে না
        if (strpos($column, 'date') !== false) {
            echo "<label>" . ucfirst(str_replace('_',' ',$column)) . "</label>";
            echo "<input type='date' name='$column' value='" . htmlspecialchars($value) . "' required>";
        } elseif (strlen($value) > 50 || strpos($column,'notes')!==false) {
            echo "<label>" . ucfirst(str_replace('_',' ',$column)) . "</label>";
            echo "<textarea name='$column'>" . htmlspecialchars($value) . "</textarea>";
        } else {
            echo "<label>" . ucfirst(str_replace('_',' ',$column)) . "</label>";
            echo "<input type='text' name='$column' value='" . htmlspecialchars($value) . "' required>";
        }
    }
    ?>
    <button type="submit">Update</button>
</form>

</body>
</html>
