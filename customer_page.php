<?php include'server_connection.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MS Corporation</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
 
</head>
<body>
<?php include 'header_and_sidebar_for_admin.php'; ?>
    <div class="main">
    <div class="for_content" id="contentArea">
    <div class="cls05">
        <div onclick="loadPage('desbord.php')" class="cls06">
            <img src="image/customers.png" alt="">
            <span>View Customer</span>
        </div>
        <div class="cls06" onclick="hide_show()">
            <img src="image/customers.png" alt="">
            <span>Payment Report</span>
        </div>
        <div class="cls06 cls15 cls16" id="alert_box" >
            <input id="customer_id" class="form-control" type="text" placeholder="Customer ID">
            <button onclick="search_customer()" class = "btn btn-primary shadow px-10">Search</button>
        </div>
        
        
         
    </div>


</div>
</div>
    <script src="script.js"></script>
</body>
</html>