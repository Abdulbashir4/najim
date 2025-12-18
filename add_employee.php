<?php include'server_connection.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MS Corporation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main">
    <div class="for_content" id="contentArea">
<div class="for_emp" id="add_employee">
 <h3>Add New Employee</h3>
    <form method="POST">
        <div class="for_center">
            <label>Name:</label>
            <input type="text" name="name"  required>
        </div>
        <div class="for_center">
            <label>Password:</label>
            <input type="text" name="password"  required>
        </div>
        <div class="for_center">
            <label>Role:</label>
            <select name="role">
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
            </select>
        </div>
        <button type="submit" name="save_employee">Save</button>
    </form>
    <?php
if (isset($_POST['save_employee'])) {
    // sanitize inputs
    $name = trim($_POST['name'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = trim($_POST['role'] ?? 'user');

    // basic validation
    $allowed_roles = ['admin', 'user'];
    if ($name === '' || $password === '') {
        echo "<script>alert('Name and password are required');window.history.back();</script>";
        exit;
    }
    if (!in_array($role, $allowed_roles)) {
        $role = 'user';
    }
    if (strlen($password) < 6) {
        echo "<script>alert('Password must be at least 6 characters');window.history.back();</script>";
        exit;
    }

    // check duplicate username
    $chk = $conn->prepare("SELECT employee_id FROM employees WHERE name = ? LIMIT 1");
    if (!$chk) {
        echo "Prepare failed: " . $conn->error;
        exit;
    }
    $chk->bind_param("s", $name);
    $chk->execute();
    $res = $chk->get_result();
    if ($res && $res->num_rows > 0) {
        echo "<script>alert('Employee with this name already exists');window.history.back();</script>";
        $chk->close();
        exit;
    }
    $chk->close();

    // hash password
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // insert using prepared statement
    $stmt = $conn->prepare("INSERT INTO employees (name, password, role) VALUES (?, ?, ?)");
    if (!$stmt) {
        echo "Prepare failed: " . $conn->error;
        exit;
    }
    $stmt->bind_param("sss", $name, $hashed, $role);

    if ($stmt->execute()) {
        // success — redirect to admin page
        echo "<script>alert('Employee Added Successfully');window.location='admin.php';</script>";
        $stmt->close();
        exit;
    } else {
        // error
        echo "Error: " . htmlspecialchars($stmt->error);
        $stmt->close();
        exit;
    }
}
?>

</div>
</div>
</div>
    <script src="script.js"></script>
</body>
</html>