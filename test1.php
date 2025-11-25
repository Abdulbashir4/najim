<?php include'server_connection.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MS Corporation</title>
    
    <style>
        /* ==== MAIN AREA ==== */
.main {
    margin-left: 220px; /* sidebar space */
    padding: 20px;
    background: #f2f6ff;
    min-height: 100vh;
    font-family: Arial, Helvetica, sans-serif;
}

.for_content {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 25px rgba(0,0,0,0.1);
}

/* ==== TOP FILTER BAR ==== */
.cls17 {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
}

.cls17 select, 
.cls17 input {
    padding: 10px 12px;
    border: 1px solid #bbb;
    border-radius: 8px;
    outline: none;
    font-size: 14px;
    transition: .3s;
}

.cls17 select:focus,
.cls17 input:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px #007bff;
}

/* ==== FORM TABLES SECTION ==== */
.cls18 {
    display: flex;
    gap: 25px;
    flex-wrap: wrap;
    margin-bottom: 25px;
}

#id02 {
    width: 350px;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(8px);
    padding: 18px 20px;
    border-radius: 12px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.12);
}

#id02 th {
    text-align: left;
    padding: 10px 0;
    font-size: 15px;
    color: #333;
}

#id02 td {
    padding: 8px 0;
}

#id02 select,
#id02 input {
    width: 100%;
    padding: 8px 10px;
    font-size: 14px;
    border-radius: 6px;
    border: 1px solid #ccc;
    outline: none;
    transition: .3s;
}

#id02 input:focus,
#id02 select:focus {
    border-color: #007bff;
    box-shadow: 0 0 4px #007bff;
}

/* ==== BUTTONS ==== */
#id01 {
    padding: 8px 20px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    margin: 3px;
}

button#id01:nth-child(1) {
    background: #ff4d4d;
    color: #fff;
}

button#id01:nth-child(2) {
    background: #007bff;
    color: #fff;
}

button#id01:hover {
    opacity: .85;
}

/* ==== DATA TABLE ==== */
.contant table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.contant th {
    background: #007bff;
    color: white;
    padding: 12px;
    text-align: left;
}

.contant td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.contant tr:hover {
    background: #f0f7ff;
}

.contant td:last-child {
    color: red;
    cursor: pointer;
    font-weight: bold;
}

/* Responsive */
@media(max-width: 768px){
    .cls17 {
        flex-direction: column;
    }
    .cls18 {
        flex-direction: column;
    }
    .main {
        margin-left: 0;
    }
}

    </style>
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