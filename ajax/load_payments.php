<?php
include '../server_connection.php';
header('Content-Type: application/json');

$party_type = $_GET['party_type'] ?? '';
$name = $_GET['name'] ?? '';
$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';

$where = "WHERE 1=1 ";
$params = [];
$types = "";

// party_type filter
if ($party_type !== '') {
    $where .= " AND party_type = ? ";
    $types .= "s";
    $params[] = $party_type;
}

// name search
if ($name !== '') {
    $where .= " AND cus_or_supp_name LIKE ? ";
    $types .= "s";
    $params[] = "%" . $name . "%";
}

// from/to date
if ($from !== '') {
    $where .= " AND date >= ? ";
    $types .= "s";
    $params[] = $from;
}
if ($to !== '') {
    $where .= " AND date <= ? ";
    $types .= "s";
    $params[] = $to;
}

$sql = "SELECT cus_or_supp_name, date, description, payment_type, total_amunt, paid_amunt
        FROM payment_account
        $where
        ORDER BY date ASC, id ASC
        LIMIT 200";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Prepare failed: " . $conn->error
    ]);
    exit;
}

if ($types !== "") {
    $stmt->bind_param($types, ...$params);
}

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode(["success" => true, "data" => $data]);
} else {
    echo json_encode(["success" => false, "message" => "Query failed: " . $stmt->error]);
}

exit;
