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
                <table id="id02">
                    <tr>
                        <th>Transsaction Type</th>
                        <td> <select name="" id="">
                            <option value="">Payment</option>
                            <option value="">bill</option>
                        </select> </td>
                    </tr>
                    <tr>
                        <th>Payment Type</th>
                        <td><select name="" id="">
                            <option value="">Cash</option>
                            <option value="">Bkash</option>
                            <option value="">Bank Account</option>
                        </select> </td>
                    </tr>
                    <tr>
                        <th>Supplier</th>
                        <td><select name="" id="">
                            <option value="">Supplier</option>
                            <option value="">Customer</option>
                        </select></td>
                    </tr>
                    <tr>
                        <th>Due</th>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <th colspan="2">WelCome TO Supplier Basir</th>
                        
                    </tr>
                </table>
                <table id="id02">
                    <tr>
                        <th>Payment Date</th>
                        <td><input type="date"></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><input type="textarea"></td>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><button id="id01">Clear</button> <button id="id01">submit</button></td>
                    </tr>
                </table>

            </div>
            <div class="contant">
                <table>
                    <tr>
                        <th>Invoice ID</th>
                        <th>Date</th>
                        <th>Supplier ID</th>
                        <th>Trans: Type</th>
                        <th>Paid by</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Save By</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td>MS-2025001</td>
                        <td>11/08/2025</td>
                        <td>MS-0095</td>
                        <td>Payment</td>
                        <td>Cash</td>
                        <td>10000</td>
                        <td>reagent purcher cash paid by basir</td>
                        <td>Basir</td>
                        <td>Delete</td>

                    </tr>
                    <tr>
                        <td>MS-2025001</td>
                        <td>11/08/2025</td>
                        <td>MS-0095</td>
                        <td>Payment</td>
                        <td>Cash</td>
                        <td>10000</td>
                        <td>reagent purcher cash paid by basir</td>
                        <td>Basir</td>
                        <td>Delete</td>

                    </tr>
                    <tr>
                        <td>MS-2025001</td>
                        <td>11/08/2025</td>
                        <td>MS-0095</td>
                        <td>Payment</td>
                        <td>Cash</td>
                        <td>10000</td>
                        <td>reagent purcher cash paid by basir</td>
                        <td>Basir</td>
                        <td>Delete</td>

                    </tr>
                    <tr>
                        <td>MS-2025001</td>
                        <td>11/08/2025</td>
                        <td>MS-0095</td>
                        <td>Payment</td>
                        <td>Cash</td>
                        <td>10000</td>
                        <td>reagent purcher cash paid by basir</td>
                        <td>Basir</td>
                        <td>Delete</td>

                    </tr>
                    <tr>
                        <td>MS-2025001</td>
                        <td>11/08/2025</td>
                        <td>MS-0095</td>
                        <td>Payment</td>
                        <td>Cash</td>
                        <td>10000</td>
                        <td>reagent purcher cash paid by basir</td>
                        <td>Basir</td>
                        <td>Delete</td>

                    </tr>
                    <tr>
                        <td>MS-2025001</td>
                        <td>11/08/2025</td>
                        <td>MS-0095</td>
                        <td>Payment</td>
                        <td>Cash</td>
                        <td>10000</td>
                        <td>reagent purcher cash paid by basir</td>
                        <td>Basir</td>
                        <td>Delete</td>

                    </tr>
                </table>
            </div>

</div>
</div>
    <script src="script.js"></script>
</body>
</html>