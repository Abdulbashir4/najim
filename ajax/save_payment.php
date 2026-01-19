<?php
include '../server_connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit;
}

$party_type   = trim($_POST['party_type'] ?? '');
$party_id     = intval($_POST['party_id'] ?? 0);
$payment_type = trim($_POST['payment_type'] ?? '');
$date         = trim($_POST['date'] ?? '');
$description  = trim($_POST['description'] ?? '');
$total_amunt  = floatval($_POST['total_amunt'] ?? 0);
$paid_amunt_raw = trim($_POST['paid_amunt'] ?? '');
$paid_amunt = ($paid_amunt_raw === '') ? 0 : floatval($paid_amunt_raw);


$due_amunt = $total_amunt - $paid_amunt;
if ($due_amunt < 0) $due_amunt = 0;

if ($party_type === '' || $party_id === 0 || $payment_type === '' || $date === '') {
    echo json_encode(["success" => false, "message" => "Please fill all required fields"]);
    exit;
}


// name find from DB
if ($party_type === 'Customer') {
    $stmt = $conn->prepare("SELECT name FROM customers WHERE id=? LIMIT 1");
} else {
    $stmt = $conn->prepare("SELECT name FROM suppliers WHERE id=? LIMIT 1");
}

$stmt->bind_param("i", $party_id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

if (!$row) {
    echo json_encode(["success" => false, "message" => "Invalid party selected"]);
    exit;
}

$cus_or_supp_name = $row['name'];

$sql = "INSERT INTO payment_account
        (party_type, party_id, cus_or_supp_name, payment_type, date, description, total_amunt, paid_amunt, due_amunt)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt2 = $conn->prepare($sql);
$stmt2->bind_param(
    "sissssddd",
    $party_type,
    $party_id,
    $cus_or_supp_name,
    $payment_type,
    $date,
    $description,
    $total_amunt,
    $paid_amunt,
    $due_amunt
);

if ($stmt2->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Insert failed"]);
}
