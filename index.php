<?php include_once("head.php"); ?>

<body onload="show_product()" style="margin: 0px; font-family: 'Kanit', sans-serif;">
    <?php
    include_once("nav.php");
    ?>
    <div class="container">

        <div class="text-header">
            <h1>Shopping Cart</h1>
        </div>
        <!-- <div class="card-header" style="height: 70px; background-color: black; margin-top: 20px; margin-bottom: 10px; ">
            <h1 style="color: white; font-weight: bold;">Shopping Cart</h1>
        </div> -->
        <div class="row">
            <div class="col-md-3">
                <label for="exampleFormControlInput1" class="form-label">เลขที่รายการ</label>
                <input type="text" class="form-control" id="or_Id" placeholder="เลขที่รายการ" readonly>
            </div>
            <div class="col-md-3">
                <label for="exampleFormControlInput1" class="form-label">สถานะรายการ</label>
                <input type="text" class="form-control" id="or_st" placeholder="สถานะรายการ" readonly>
            </div>
            <div class="col">

            </div>
        </div>
        <div id="show_listproduct"></div>
        <div id="pay"></div>
    </div>
    <div class="container">
        <div class="text-header">
            <h1>Product Catacories</h1>
        </div>
        <!-- <div class="card-header" style="height: 70px; background-color:black; margin-top: 20px; margin-bottom: 10px;">
            <h1 style="color: white; font-weight: bold;">Product Catacories</h1>
        </div> -->
        <div id="show_product"></div>

    </div>
    </div>
    <script>
        function show_product() {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                console.log(this.readyState + ", ", this.status);
                if (this.readyState == 4 && this.status == 200) {
                    data = JSON.parse(this.responseText);
                    out = document.getElementById("show_product");
                    text = "";
                    text += "<div class='row g-4'>";
                    for (i = 0; i < data.length; i++) {
                        text += ` 
                                    <div class="col-md-3"">
                                        <div class="card">
                                             <img src="img/photo.png" class="card-img-top">
                                            <div class="card-body">
                                            <h5 class="card-title">${data[i].name}</h5>
                                            <p class="card-text">฿ ${data[i].price}</p>
                                            <div class="row">
                                                <div class="col-md-7"><input type="number" size="4" max="${data[i].stock}" min="1" value="1" class="form-control" id="${data[i].id}"></div>
                                                <div class="col-md-5" style="padding-left: 0"><button style="width: 100%" onclick="add_product(${data[i].id})" class="btn btn-success"><i class="fas fa-shopping-cart"></i> เพิ่มสินค้า</button></div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>`;
                    }
                    text += "</div>";
                    out.innerHTML = text;
                    show_orderList();
                }

            }
            xhttp.open("GET", "product_rest.php?show_pro=show_pro", true);
            xhttp.send();
        }

        function add_product(idx) {
            orId = document.getElementById("or_Id").value;
            qty = document.getElementById(idx).value;
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert(`เพิ่มสินค้าสำเร็จ`);
                    show_product();
                }
            }
            xhttp.open("POST", "order_rest.php", true);
            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhttp.send("Id=" + idx + "&qty=" + qty + "&orId=" + orId);
            qty.value = 1;
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
                    data = JSON.parse(this.responseText);
                    text = "<table class='table table-striped' style='margin-top: 10px'>";
                    text += "<thead class='table-dark'>";
                    for (j = 0; j < lable.length; j++) {
                        text += "<th>" + lable[j] + "</th>";
                    }
                    text += "</thead>";
                    for (i = 0; i < data.length; i++) {
                        text += "<tr>";
                        text += "<td>" + data[i].name + "</td>";
                        text += "<td>" + data[i].id + "</td>";
                        text += "<td align='right'>" + data[i].amount + "</td>";
                        text += "<td>" + data[i].price + "</td>";
                        text += "<td>" + data[i].price * data[i].amount + "</td>";
                        text += "<td><button type='button' class='btn btn-danger' onclick='del_order(" + data[i].id + "," + data[i].or_id + "," + data[i].amount + ")'><i class='fas fa-trash-alt'></i> ลบรายการ</button></td>";
                        text += "</tr>";
                        net += data[i].price * data[i].amount;
                        total = data[i].total;
                        status = data[i].status;
                        orId.value = data[i].or_id;
                        if (status == 0) {
                            or_st.value = "รายการยังไม่เสร็จสิ้น";
                        } else {
                            or_st.value = "รายการเสร็จสิ้น";
                        }
                    }
                    text += "<th colspan='2' align='right'>Total</th>";
                    text += "<td align='right'>" + total + "</td>";
                    text += "<td colspan='2' align='right'></td>";
                    text += "<td></td>";
                    text += "</table>";
                }
                out.innerHTML = text;
                pay = document.getElementById("pay");
                pay.innerHTML = "<div style='text-align: center'><button style='width: 20%;' class='btn btn-success' onclick='payment(" + orId.value + ")'><i class='fas fa-coins'></i> ชำระเงิน</button></div>";
            }
            xhttp.open("GET", "order_rest.php?showlist=showlist", true);
            xhttp.send();
        }

        function del_order(idx, orId, qty) {

            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert("ลบรายการสำเร็จ");
                    show_product();
                }
            }
            xhttp.open("GET", "order_rest.php?Id=" + idx + "&del_order=del_order&orId=" + orId + "&qty=" + qty + "", true);
            xhttp.send();
        }

        function payment(idx) {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert("ชำระเงินสำเร็จ");
                    show_orderList();
                }
            }
            xhttp.open("POST", "order_rest.php", true);
            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhttp.send("Id=" + idx + "&update_order=update_order");
            out = document.getElementById("show_listproduct");
            orId = document.getElementById("or_Id");
            or_st = document.getElementById("or_st");
            pay = document.getElementById("pay");
            out.innerHTML = null;
            orId.value = null;
            or_st.value = null;
            pay.innerHTML = "";
        }
    </script>
</body>
</html>