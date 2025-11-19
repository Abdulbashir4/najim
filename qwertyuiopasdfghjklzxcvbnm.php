<?php
// create_admin.php
// Warning: Run once, then delete this file for security.

include 'server_connection.php';

// change these as you like
$name = "basir";
$plain_password = "000000";
$role = "admin";

// safety: check connection
if (!$conn) {
    die("DB connection error");
}

// prevent duplicate admin
$stmt = $conn->prepare("SELECT employee_id FROM employees WHERE name = ? LIMIT 1");
$stmt->bind_param("s", $name);
$stmt->execute();
$res = $stmt->get_result();

if ($res && $res->num_rows > 0) {
    echo "User '{$name}' already exists. No changes made.";
    $stmt->close();
    exit;
}
$stmt->close();

// create hash and insert
$pass = password_hash($plain_password, PASSWORD_DEFAULT);

$ins = $conn->prepare("INSERT INTO employees (name, password, role) VALUES (?, ?, ?)");
if (!$ins) {
    die("Prepare failed: " . $conn->error);
}
$ins->bind_param("sss", $name, $pass, $role);
if ($ins->execute()) {
    echo "Admin user created successfully. Username: {$name}  Password: {$plain_password}";
} else {
    echo "Insert failed: " . $ins->error;
}
$ins->close();
$conn->close();
?>
