<?php
include 'server_connection.php';

$table = $_GET['table'];
$id = $_GET['id'];

// নিরাপত্তা: ইনপুট ক্লিন করা
$table = preg_replace("/[^a-zA-Z0-9_]/", "", $table);
$id = intval($id);

// টেবিলের প্রথম কলাম বের করা
$sql = "SHOW COLUMNS FROM $table";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $firstColumn = $result->fetch_assoc()['Field'];

    // ডিলিট কুয়েরি চালানো
    $deleteQuery = "DELETE FROM $table WHERE $firstColumn = $id";
    if ($conn->query($deleteQuery)) {

        // ✅ আগের পেজে রিডাইরেক্ট করো
        $previousPage = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        header("Location: $previousPage");
        exit;

    } else {
        echo "error: " . $conn->error;
    }
} else {
    echo "error: Unable to fetch table columns.";
}
?>
