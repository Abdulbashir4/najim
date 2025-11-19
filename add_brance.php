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
<?php include 'header_and_sidebar_for_admin.php'; ?>
    <div class="main">
    <div class="for_content" id="contentArea">

<!-- Add Branch -->
  
    <h3>Add New Branch</h3>
    <form method="POST">
        <div class="for_center">
            <label>Branch Name:</label>
            <input type="text" name="branch_name"  required>
        </div>
       
        <button type="submit" name="save_branch">Save</button>
    </form>
    <?php
    if (isset($_POST['save_branch'])) {
        $name = $_POST['branch_name'];

        $sql = "INSERT INTO branch (branch_name) VALUES ('$name')";
        if ($conn->query($sql)) {
            echo "<script>alert('Branch Added Successfully');window.location='admin.php';</script>";
            exit;
        } else {
            echo "Error: ".$conn->error;
        }
    }
    ?>


</div>
</div>
    <script src="script.js"></script>
</body>
</html>