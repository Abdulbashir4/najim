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
    <div class="main">
    <div class="for_content" id="contentArea">
    <form method="POST" action="" id="bye_form">
        <div class="cls10"> 
            <h1>Product Bye</h1>
            <hr>
        </div>
        <div class="cls11">
            <div class="cls12">
                <h1>Bye Info</h1>
                <table>
                    <tr>
                        <th>Shop Name:</th>
                        <td><select name="shop_name" id="">
                        <option value="">Select Shop</option>
                        <?php 
                        $shop_name = $conn->query("SELECT * FROM shops");
                        while($s = $shop_name->fetch_assoc()){
                            echo "
                            <option value='{$s['id']}'>{$s['shop_name']}</option>
                            ";
                        }
                        ?>
                    </select></td>
                    </tr>
                    <tr>
                        <th>Date:</th>
                        <td><input type="date" name="date"></td>
                    </tr>
                    <tr>
                        <th>Paid Amount</th>
                        <td><input type="text" name="paid_amount"></td>
                    </tr>
                    <tr>
                        <th>Total DIscount</th>
                        <td><input type="text" name="t_discount"></td>
                    </tr>
                </table>
                <div class="cls13"><button type="submit" name="bye_product_btn">Submit & Invoice</button></div>
            </div>
            <div class="cls12">
                <h1>Product Info</h1>
                <table>
                    <tr>
                        <th>Prooduct Name:</th>
                        <td> <select name="product_name" id="productSelect">
                            <option value="">Select Product</option>
                            <?php 
                            $product = $conn->query("SELECT * FROM products");
                            while($p = $product->fetch_assoc()){
                                echo "
                                <option value='{$p['product_id']}' data-name='{$p['product_name']}'>{$p['product_name']}</option>
                                ";
                            }
                            ?>
                        </select> </td>
                    </tr>
                    <tr>
                        <th>Quantity:</th>
                        <td><input type="text" name="qty" id="qtyInput"></td>
                    </tr>
                    <tr>
                        <th>Unit</th>
                        <td><select name="unit" id="unitInput">
                            <option value="pcs">Pcs</option>
                            <option value="box">Box</option>
                            <option value="carton">Carton</option>
                            <option value="pack">Pack</option>
                        </select></td>
                    </tr>
                    <tr>
                        <th>Unit Price</th>
                        <td><input type="text" name="unit_price" id="priceInput"></td>
                    </tr>
                    <tr>
                        <th>Discount TK:</th>
                        <td><input type="text" name="dis_tk" id="discount_tk"></td>
                    </tr>
                    <tr>
                        <th>Discount %</th>
                        <td><input type="text" name="dis_per" id="discount_per"></td>
                    </tr>
                </table>
                <div class="cls13"><button onclick="addRow()" type="button">Add More Product</button></div>
                
            </div>
            
        </div>
        <div id="hiddenInputs"></div>

    </form>
    <?php 
    if(isset($_POST['bye_product_btn'])){
    $shop_name = $_POST['shop_name'];
    $date = $_POST['date'];
    $paid_amount = $_POST['paid_amount'];
    $total_discount = $_POST['t_discount'];

    // ইনভয়েস নম্বর জেনারেট
    $year = date('Y');
    $result = $conn->query("SELECT invoice_no FROM invoices WHERE invoice_no LIKE 'MS-$year-%' ORDER BY id DESC LIMIT 1");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        preg_match('/MS-\d{4}-(\d+)/', $row['invoice_no'], $matches);
        $last = (int)($matches[1] ?? 0);
        $new = $last + 1;
    } else { $new = 1; }
    $invoice_no = "MS-$year-" . str_pad($new, 4, '0', STR_PAD_LEFT);

    // ✅ একাধিক প্রোডাক্ট থেকে টোটাল হিসাব করা
    $grand_total = 0;
    if (!empty($_POST['product_id'])) {
        foreach($_POST['product_id'] as $index => $pid) {
            $qty = $_POST['qty'][$index];
            $unit_price = $_POST['price'][$index];
            $discount_tk = $_POST['discount_tk'][$index];
            $discount_per = $_POST['discount_per'][$index];

            $base_total = $qty * $unit_price;
            if ($discount_tk > 0) {
                $base_total -= $discount_tk;
            } elseif ($discount_per > 0) {
                $base_total -= ($base_total * $discount_per / 100);
            }
            $grand_total += $base_total; // সব প্রোডাক্টের যোগফল
        }
    }

    // ✅ invoices টেবিলে ইনসার্ট (now with total_amount)
    $stmt = $conn->prepare("INSERT INTO invoices (invoice_no, sale_date, customer_id, paid_amount, discount, total_amount)
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siiidd", $invoice_no, $date, $shop_name, $paid_amount, $total_discount, $grand_total);
    $stmt->execute();
    $invoice_id = $conn->insert_id;

    // ✅ প্রতিটি প্রোডাক্ট ইনসার্ট
    foreach($_POST['product_id'] as $index => $pid) {
        $qty = $_POST['qty'][$index];
        $unit = $_POST['unit'][$index];
        $unit_price = $_POST['price'][$index];
        $discount_tk = $_POST['discount_tk'][$index];
        $discount_per = $_POST['discount_per'][$index];

        $conn->query("INSERT INTO bye_info (shop_name, invoice_no, sale_date, product_name, qty, unit, unit_price, discount_tk, discount_per)
                      VALUES ('$shop_name', '$invoice_no', '$date', '$pid', '$qty', '$unit', '$unit_price', '$discount_tk', '$discount_per')");
    }

    echo "<script>alert('Invoice created successfully with total = {$grand_total} TK'); window.location='bye_invoice.php?invoice={$invoice_no}';</script>";
}
    
    ?>
    <div class="cls14">
    <table id="productList">
        <thead>
            <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Unit Price</th>
            <th>Discount TK</th>
            <th>Discount %</th>
            <th>Total TK</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    </div>
</div>
</div>
<script>
const discountTkInput=document.getElementById("discount_tk");
const discountPerInput=document.getElementById("discount_per");
discountTkInput.addEventListener("input",function(){
 if(parseFloat(this.value)>0){
  discountPerInput.disabled=true; discountPerInput.style.background="#eee";
 } else { discountPerInput.disabled=false; discountPerInput.style.background=""; }
});
discountPerInput.addEventListener("input",function(){
 if(parseFloat(this.value)>0){
  discountTkInput.disabled=true; discountTkInput.style.background="#eee";
 } else { discountTkInput.disabled=false; discountTkInput.style.background=""; }
});

function addRow(){
 let pSel=document.getElementById("productSelect");
 let qty=parseFloat(document.getElementById("qtyInput").value);
 let price=parseFloat(document.getElementById("priceInput").value);
 let unit = document.getElementById("unitInput").value;
 let disTk=parseFloat(document.getElementById("discount_tk").value)||0;
 let disPer=parseFloat(document.getElementById("discount_per").value)||0;
 let tbody=document.querySelector("#productList tbody");
 if(!pSel.value||!qty||!price){ alert("সব ঘর পূরণ করুন!"); return; }

 let base=qty*price, total=base;
 if(disTk>0) total-=disTk; else if(disPer>0) total-=(base*disPer/100);

 let row=document.createElement("tr");
 row.innerHTML=`<td>${pSel.options[pSel.selectedIndex].dataset.name}</td>
 <td>${qty}</td> <td>${unit}</td> <td>${price}</td><td>${disTk}</td><td>${disPer}</td>
 <td>${total.toFixed(2)}</td>
 <td><button type='button' class='btn-danger' onclick='removeRow(this)'>Remove</button></td>`;
 tbody.appendChild(row);

 let hidden=document.getElementById("hiddenInputs");
 hidden.innerHTML += `
 <input type="hidden" name="product_id[]" value="${pSel.value}">
 <input type="hidden" name="qty[]" value="${qty}">
 <input type="hidden" name="unit[]" value="${unit}">
 <input type="hidden" name="price[]" value="${price}">
 <input type="hidden" name="discount_tk[]" value="${disTk}">
 <input type="hidden" name="discount_per[]" value="${disPer}">`;

 pSel.selectedIndex=0;
 document.getElementById("qtyInput").value="";
 document.getElementById("priceInput").value="";
 discountTkInput.value=""; discountPerInput.value="";
 discountTkInput.disabled=false; discountPerInput.disabled=false;
 discountTkInput.style.background=""; discountPerInput.style.background="";
}
function removeRow(btn){ btn.closest("tr").remove(); }
</script>
    <script src="script.js"></script>
</body>
</html>