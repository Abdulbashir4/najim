<?php
// login.php
session_start();
include 'server_connection.php';

// যদি আগে থেকে লগডইন থাকে -> role অনুযায়ী redirect
if (isset($_SESSION['employee_id'])) {
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        header('Location: admin.php');
        exit;
    } else {
        header('Location: user.php');
        exit;
    }
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // sanitize input
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Username and password are required.';
    } else {
        // prepared statement (SQL injection safe)
        $stmt = $conn->prepare("SELECT employee_id, name, password, role FROM employees WHERE name = ? LIMIT 1");
        if (!$stmt) {
            // DB prepare error
            $error = "Database error: " . $conn->error;
        } else {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res && $res->num_rows === 1) {
                $row = $res->fetch_assoc();
                $hash = $row['password'];

                // Verify hashed password
                if (password_verify($password, $hash)) {
                    // login success
                    session_regenerate_id(true); // prevent session fixation
                    $_SESSION['employee_id'] = $row['employee_id'];
                    $_SESSION['employee_name'] = $row['name'];
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['LAST_ACTIVITY'] = time();

                    // optional: rehash if needed (keeps DB updated)
                    if (password_needs_rehash($hash, PASSWORD_DEFAULT)) {
                        $newHash = password_hash($password, PASSWORD_DEFAULT);
                        $up = $conn->prepare("UPDATE employees SET password = ? WHERE employee_id = ?");
                        if ($up) {
                            $up->bind_param("si", $newHash, $row['employee_id']);
                            $up->execute();
                            $up->close();
                        }
                    }

                    // Redirect based on role
                    if ($row['role'] === 'admin') {
                        header('Location: admin.php');
                        exit;
                    } else {
                        header('Location: user.php');
                        exit;
                    }
                } else {
                    $error = 'Invalid username or password.';
                }
            } else {
                $error = 'Invalid username or password.';
            }
            $stmt->close();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MS Corporation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="body">
<form id="l_form" method="post">
  <h2 class="gb_title">Please Login Here</h2>
  <input type="text" name="username" placeholder="Username" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Login</button>

</form>
<?php if ($error): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>
</div>
<script src="script.js"></script>
</body>
</html>

