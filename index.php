<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <!-- <link rel="stylesheet" href="css.css"> -->
</head>
<style>
    .basic-slide {
        display: inline-block;
        width: 215px;
        padding: 10px 0 10px 15px;
        font-family: "Open Sans", sans;
        font-weight: 400;
        color: #377D6A;
        background: #efefef;
        border: 0;
        border-radius: 3px;
        outline: 0;
        text-indent: 70px;
        transition: all .3s ease-in-out;
    }
</style>

<body onload="show_product()">
    <div class="container">
        <div class="text-header">
            <h2>Shopping Cart</h2>
        </div>
        <div class="row">
            <div class="column">
                <label for="text">เลขที่รายการ</label>
                <input type="text" id="or_Id" readonly style="text-align: center;">
            </div>
            <div class="column">
                <label for="text">สถานะรายการ</label>
                <input type="text" id="or_st" readonly style="text-align: center;">
            </div>
            <div class="column">
                <div id="pay"></div>
            </div>
        </div>
        <div id="show_listproduct"></div>
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
                        text += data[i].name + "<br>";
                        text += "฿ " + data[i].price + " <input type='number' name='' id='" + i + "' size='4' max='" + data[i].stock + "' min='1' value='1'>";
                        text += " <button onclick='add_product(" + data[i].id + "," + i + ")'>Add to Cart</button>";
                        text += "</div>";
                        text += "</div>";
                    }
                    text += "</div>";
                    out.innerHTML = text;

                }
                show_orderList();
            }
            xhttp.open("GET", "product_rest.php?show_pro=show_pro", true);
            xhttp.send();
        }

        function add_product(idx, qtyId) {
            orId = document.getElementById("or_Id").value;
            for (i = 0; i <= qtyId; i++) {
                if (i == qtyId) {
                    qty = document.getElementById("" + qtyId + "").value;
                }
            }
            // alert(idx);
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                console.log(this.responseText);
            }
            xhttp.open("POST", "order_rest.php", true);
            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhttp.send("Id=" + idx + "&qty=" + qty + "&orId=" + orId);
            for (i = 0; i <= qtyId; i++) {
                document.getElementById("" + qtyId + "").value = 1;
            }

        }

        function show_orderList() {
            lable = ['ชื่อสินค้า', 'รหัสสินค้า', 'จำนวน', 'ราคา', 'ราคารวม', 'ลบรายการ'];
            let xhttp = new XMLHttpRequest();
            out = document.getElementById("show_listproduct");
            orId = document.getElementById("or_Id");
            or_st = document.getElementById("or_st");
            text = "";
            total = 0;
            net = 0;
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // console.log(this.responseText);
                    data = JSON.parse(this.responseText);
                    text = "<table border='1' width='100%'>";
                    for (i = 0; i < lable.length; i++) {
                        text += "<th>" + lable[i] + "</th>";
                    }
                    for (i = 0; i < data.length; i++) {
                        text += "<tr>";
                        text += "<td>" + data[i].name + "</td>";
                        text += "<td>" + data[i].id + "</td>";
                        text += "<td align='right'>" + data[i].amount + "</td>";
                        text += "<td>" + data[i].price + "</td>";
                        text += "<td>" + data[i].price * data[i].amount + "</td>";
                        text += "<td><button class='btnEmpty' onclick='del_order(" + data[i].id + "," + data[i].or_id + ")'>ลบรายการ</button></td>";
                        text += "</tr>";
                        net += data[i].price * data[i].amount;
                        total += parseInt(data[i].amount);
                        id = data[i].or_id;
                        status = data[i].status;

                    }
                    text += "<td colspan='2' align='right'>Total:</td>";
                    text += "<td align='right'>" + total + "</td>";
                    text += "<td colspan='2' align='right'>" + net + "</td>";
                    text += "<td></td>";
                    text += "</table>";
                    orId.value = id;
                    out.innerHTML = text;

                    pay = document.getElementById("pay");
                    orId = document.getElementById("or_Id").value;
                    pay.innerHTML = "<button class='btnsuccess' onclick='payment(" + orId + ")'>ชำระเงิน</button>";

                    if (status == 0) {
                        or_st.value = "รายการยังไม่เสร็จสิ้น";
                    } else {
                        or_st.value = "รายการเสร็จสิ้น";
                    }
                }
            }
            xhttp.open("GET", "order_rest.php?showlist=showlist", true);
            xhttp.send();
        }

        function del_order(idx, orId) {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                }
            }
            xhttp.open("GET", "order_rest.php?Id=" + idx + "&del_order=del_order&orId=" + orId + "", true);
            xhttp.send();
        }

        function payment(idx) {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                // console.log(this.readyState + ", ", this.status);
                console.log(this.responseText);
            }
            xhttp.open("POST", "order_rest.php", true);
            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhttp.send("Id=" + idx + "&update_order=update_order");
        }
    </script>
</body>

</html>