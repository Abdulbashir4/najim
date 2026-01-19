<?php
require_once __DIR__ . "/../server_connection.php";

header('Content-Type: application/json');

$start_date = $_GET['start_date'] ?? '';
$end_date   = $_GET['end_date'] ?? '';
$party_type = $_GET['party_type'] ?? '';
$party_id   = $_GET['party_id'] ?? '';

if(empty($party_type) || empty($party_id)){
  echo json_encode([
    "ok" => false,
    "message" => "Missing party_type or party_id"
  ]);
  exit;
}

$sql = "
  SELECT 
    COALESCE(SUM(debit),0) AS total_debit,
    COALESCE(SUM(credit),0) AS total_credit
  FROM statements
  WHERE party_type = ? AND party_id = ?
";

$hasDateFilter = (!empty($start_date) && !empty($end_date));
if($hasDateFilter){
  $sql .= " AND created_at BETWEEN ? AND ? ";
}

$stmt = $conn->prepare($sql);

if($hasDateFilter){
  $start = $start_date . " 00:00:00";
  $end   = $end_date . " 23:59:59";
  $stmt->bind_param("siss", $party_type, $party_id, $start, $end);
} else {
  $stmt->bind_param("si", $party_type, $party_id);
}

// ✅ execute
$stmt->execute();

// ✅ fetch result
$result = $stmt->get_result();
$res = $result->fetch_assoc();

$stmt->close();

$total_debit  = (float)($res["total_debit"] ?? 0);
$total_credit = (float)($res["total_credit"] ?? 0);
$balance = $total_debit - $total_credit;

echo json_encode([
  "ok" => true,
  "total_debit" => $total_debit,
  "total_credit" => $total_credit,
  "balance" => $balance
]);
