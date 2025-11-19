<!DOCTYPE html>
<html>
<head>
    <title>Send URL Parameter</title>
    <style>
        #inputBox {
            display: none;
            margin-top: 15px;
        }
        .clickDiv {
            width: 200px;
            padding: 15px;
            background: #3498db;
            color: white;
            text-align: center;
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="clickDiv" onclick="showInputBox()">
    Click Here to Enter Customer ID
</div>

<div id="inputBox">
    <input type="text" id="customerID" placeholder="Enter Customer ID">
    <button onclick="goToPage()">Submit</button>
</div>

<script>
function showInputBox() {
    document.getElementById("inputBox").style.display = "block";
}

function goToPage() {
    let id = document.getElementById("customerID").value;

    if(id === "") {
        alert("Please enter a Customer ID");
        return;
    }

    // অন্য পেজে parameter পাঠানো
    window.location.href = "customer_report.php?customer_id=" + id;
}
</script>

</body>
</html>
