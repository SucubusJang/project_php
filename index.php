<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body onload="show_product()">
    <div class="container">
        <div class="text-header">
            <h2>Shopping Cart</h2>
        </div>
        <div id="show_listproduct"></div>
        <a href="#" id="btnEmpty">Empty Cart</a>
        <div class="text-header">
            <h2>Product Catalog</h2>
        </div>
        <div id="show_product"></div>
    </div>
    
    <script>
        function show_product() {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                console.log(this.readyState + ", ", this.status);
                if (this.readyState == 4 && this.status == 200) {
                    // console.log(this.responseText);
                    data = JSON.parse(this.responseText);
                    out = document.getElementById("show_product");
                    // console.log(data.length);
                    text = "";
                    text += "<div class='row'>";
                    for (i = 0; i < data.length; i++) {
                        text += "<div class='column'>";
                        text += "<div class='card'>";
                        text += "<img src='img/img.png' alt='Girl in a jacket'><br>";
                        text += data[i].name+"<br>";
                        text += "฿ "+data[i].price+" <input type='number' name='' id='"+i+"' size='4' max='"+data[i].stock+"' min='1' value='1'>";
                        text += " <button onclick='add_product("+data[i].id+","+i+")'>Add to Cart</button>";
                        text += "</div>";
                        text += "</div>";
                    }
                    text += "</div>";
                    out.innerHTML = text;
                    show_orderList();
                }

            }
            xhttp.open("GET", "product_rest.php?show_pro=show_pro", true);
            xhttp.send();
        }
        function add_product(idx,qtyId){
            for(i=0;i<=qtyId;i++){
                if(i == qtyId){
                    qty = document.getElementById(""+qtyId+"").value;
                }
            }
            // alert(qty);
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                console.log(this.responseText);
            }
            xhttp.open("POST","order_rest.php",true);
            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhttp.send("Id="+idx+"&qty="+qty);
            for(i=0;i<=qtyId;i++){
                document.getElementById(""+qtyId+"").value = 1;
            }
        }
        function show_orderList(){
            lable = ['ชื่อสินค้า','รหัสสินค้า','จำนวน','ราคา','ราคารวม','ลบรายการ'];
            let xhttp = new XMLHttpRequest();
            out = document.getElementById("show_listproduct"); 
            text = "";
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // console.log(this.responseText);
                    data = JSON.parse(this.responseText);
                    text = "<table>";
                    for(i=0;i<lable.length;i++){
                        text += "<th>"+lable[i]+"</th>";
                    }
                    for(i=0;i<data.length;i++){
                        text += "<tr>";
                        text += "<td>"+data[i].name+"</td>";
                        text +=  "<td>"+data[i].id+"</td>";
                        text +=  "<td>"+data[i].amount+"</td>";
                        text +=  "<td>"+data[i].price+"</td>";
                        text +=  "<td>"+data[i].price * data[i].amount+"</td>";
                        text +=  "<td><button>ลบรายการ</button></td>";
                        text += "</tr>";
                    }
                    text += "</table>";
                    out.innerHTML = text;
                }
            }
            xhttp.open("GET","order_rest.php?showlist=showlist",true);
            xhttp.send();
        }
    </script>
</body>

</html>

<!-- 
<table class="tbl-cart" cellpadding="10" cellspacing="1">
<tbody>
<tr>
<th style="text-align:left;">Name</th>
<th style="text-align:left;">Code</th>
<th style="text-align:right;" width="5%">Quantity</th>
<th style="text-align:right;" width="10%">Price<br>( in $)</th>
<th style="text-align:right;" width="10%">Total<br>( in $)</th>
<th style="text-align:center;" width="5%">Remove</th>
</tr>
                <tr>
                <td><img src="product-images/external-hard-drive.jpg" class="cart-item-image">EXP Portable Hard Drive</td>
                <td>USB02</td>
                <td style="text-align:right;">1</td>
                <td style="text-align:right;">800.00</td>
                <td style="text-align:right;">800.00</td>
                <td style="text-align:center;"><a href="index.php?action=remove&amp;code=USB02" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item"></a></td>
                </tr>
                
<tr>
<td colspan="2" align="right">Total:</td>
<td align="right">1</td>
<td align="right" colspan="2"><strong>800.00</strong></td>
<td></td>
</tr>
</tbody>
</table> -->