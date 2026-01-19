<?php
include '../server_connection.php';
header('Content-Type: application/json');

$type = $_GET['type'] ?? 'Supplier';

if ($type === 'Customer') {
    $sql = "SELECT id, name FROM customers ORDER BY name ASC";
} else {
    $sql = "SELECT id, name FROM suppliers ORDER BY name ASC";
}

$result = $conn->query($sql);

$data = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode(["success" => true, "data" => $data]);
} else {
    echo json_encode(["success" => false, "message" => "DB Error"]);
}
