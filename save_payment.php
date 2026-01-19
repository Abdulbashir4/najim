<?php
include 'server_connection.php'; // এখানে $conn থাকবে ধরে নিচ্ছি

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Receive POST data
    $cus_or_supp_name = trim($_POST['cus_or_supp_name'] ?? '');
    $payment_type     = trim($_POST['payment_type'] ?? '');
    $cus_or_sup       = trim($_POST['cus_or_sup'] ?? '');
    $date             = trim($_POST['date'] ?? '');
    $description      = trim($_POST['description'] ?? '');
    $total_amunt      = floatval($_POST['total_amunt'] ?? 0);
    $paid_amunt       = floatval($_POST['paid_amunt'] ?? 0);

    // Due Calculation (Server-side নিরাপত্তার জন্য)
    $due_amunt = $total_amunt - $paid_amunt;
    if ($due_amunt < 0) $due_amunt = 0;

    // Basic validation
    if ($cus_or_supp_name === '' || $payment_type === '' || $cus_or_sup === '' || $date === '') {
        header("Location: index.php?error=1");
        exit;
    }

    // Insert Query (Prepared Statement)
    $sql = "INSERT INTO payment_account 
            (cus_or_supp_name, payment_type, cus_or_sup, date, description, total_amunt, paid_amunt, due_amunt)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if(!$stmt){
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "sssssddd",
        $cus_or_supp_name,
        $payment_type,
        $cus_or_sup,
        $date,
        $description,
        $total_amunt,
        $paid_amunt,
        $due_amunt
    );

    if ($stmt->execute()) {
        header("Location: index.php?success=1");
        exit;
    } else {
        die("Execute failed: " . $stmt->error);
    }
}
?>
