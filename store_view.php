<?php
 include 'server_connection.php';
// ডিলিট অপারেশন
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM store WHERE id=$id");
    header("Location: store_view.php");
    exit();
}

// ডেটা রিড
$sql = "SELECT * FROM store ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <title>স্টোর ডেটা</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f9;
      padding: 30px;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      border-radius: 10px;
      overflow: hidden;
    }
    th, td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
      text-align: center;
    }
    th {
      background: #4CAF50;
      color: white;
    }
    tr:hover {
      background: #f1f1f1;
    }
    a.btn {
      padding: 6px 12px;
      border-radius: 6px;
      text-decoration: none;
      color: white;
    }
    .edit {
      background: #2196F3;
    }
    .delete {
      background: #f44336;
    }
  </style>
</head>
<body>
    <div class="page-content">
  <h2>স্টোর ডেটা লিস্ট</h2>
  <table>
    <tr>
      <th>ID</th>
      <th>প্রোডাক্ট নাম</th>
      <th>পিস</th>
      <th>দর</th>
      <th>দোকান নাম</th>
      <th>তারিখ ও সময়</th>
      <th>দেওয়া টাকা</th>
      <th>বাকি টাকা</th>
      <th>নোট</th>
      <th>অ্যাকশন</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['product_name']}</td>
                    <td>{$row['quantity']}</td>
                    <td>{$row['price']}</td>
                    <td>{$row['shop_name']}</td>
                    <td>{$row['purchase_datetime']}</td>
                    <td>{$row['paid_amount']}</td>
                    <td>{$row['due_amount']}</td>
                    <td>{$row['note']}</td>
                    <td>
                        <a class='btn edit' href='store_edit.php?id={$row['id']}'>Edit</a>
                        <a class='btn delete' href='store_view.php?delete={$row['id']}' onclick=\"return confirm('আপনি কি ডিলিট করতে চান?');\">Delete</a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='10'>কোনো ডেটা পাওয়া যায়নি</td></tr>";
    }
    ?>
  </table>
  </div>
</body>
</html>
<?php $conn->close(); ?>
