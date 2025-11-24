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
     <div class="cls17">
        <select name="" id="">
            <option value="">Supplier Payment</option>
            <option value="">Customer Payment</option>
        </select>
        <input type="text" placeholder="Invoice no">
        <input type="date" placeholder="From Date">
        <input type="date" placeholder="To Date">
     </div>
        <div class="cls18">
                <table>
                    <tr>
                        <th>Transsaction Type</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Payment Type</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Supplier</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Due</th>
                        <td></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Payment Date</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Due</th>
                        <td></td>
                    </tr>
                </table>
            </div>

</div>
</div>
    <script src="script.js"></script>
</body>
</html>