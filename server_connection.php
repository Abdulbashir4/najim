<?php
// server_connection.php
// No closing PHP tag at end of file (prevents accidental trailing whitespace)

// Turn on mysqli exceptions (helps catch errors during development)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "najiullah";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    // set proper charset
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    // In development you may want to see the error; in production log it instead
    error_log("Database connection error: " . $e->getMessage());
    // Optionally display a user-friendly message or stop execution
    // die("Database connection failed. Please try again later.");
    // For debugging uncomment next line (not for production):
    // die("Connection failed: " . $e->getMessage());
}



// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "najiullah";

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }


// $servername = "localhost";
// $username   = "mscorporation_bashir";
// $password   = "kx[};#6aXBnjBfV;";
// $dbname     = "mscorporation_mscorporation";

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }


