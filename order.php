<?php include_once("head.php"); ?>
<body onload="loadContent()" style="margin: 0px; font-family: 'Kanit', sans-serif;">
    <?php
    include_once("nav.php");
    ?>
    <div class="container">
        <div class="text-header">
            <h2>Manage Order</h2>
        </div>
        <table class="table table-striped" style="margin-top: 20px">
            <thead class="table-dark">
                <th>รหัสรายการ</th>
                <th>วันที่ขาย</th>
                <th>จำนวนที่ขาย</th>
                <th>สถานะ</th>
                <th>จัดการ</th>
            </thead>
            <tbody id="show_order">
            </tbody>
        </Table>
        <div id="show_listproduct"></div>
    </div>
    <script>
        function loadContent() {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status) {
                    data = JSON.parse(this.responseText);
                    create_Table(data);
                }
            }
            xhttp.open("GET", "order_rest.php?showOrder", true);
            xhttp.send();
        }

        function create_Table(data) {
            out = document.getElementById("show_order");
            text = "";
            for (i = 0; i < data.length; i++) {
                text += "<tr>";
                text += "<td>" + data[i].id + "</td>";
                text += "<td>" + data[i].date_purchase + "</td>";
                text += "<td>" + data[i].total + "</td>";
                if (data[i].status == 1) {
                    text += "<td> รายการเสร็จสิ้น </td>";
                    text += "<td><button class='btn btn-success' onclick='show_list(" + data[i].id + ")'>แสดงรายการ</button></td>";
                } else {
                    text += "<td> กำลังดำเนินการ </td>";
                    text += "<td><button class='btn btn-danger' onclick='show_list(" + data[i].id + " disabled)'>แสดงรายการ</button></td>";
                }
                text += "</tr>\n";
            }
            out.innerHTML = text;
        }

        function show_list(idx) {
            lable = ['ชื่อสินค้า', 'รหัสสินค้า', 'จำนวน', 'ราคา', 'ราคารวม'];
            out = document.getElementById("show_listproduct");
            let xhttp = new XMLHttpRequest();
            text = "";
            total = 0;
            net = 0;
            xhttp.onreadystatechange = function() {
                console.log(this.responseText);
                if (this.readyState == 4 && this.status) {
                    console.log(this.responseText);
                    data = JSON.parse(this.responseText);
                    text += `<div class="text-header" style="margin-bottom: 20px">
                                <h2>Order Detail</h2>
                            </div>`;
                    text += "<table class='table table-striped' style='margin-top: 20px'>";
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
                        text += "</tr>";
                        net += data[i].price * data[i].amount;
                        total = data[i].total;
                        id = data[i].or_id;
                        status = data[i].status;
                    }
                    text += "<td colspan='2' align='right'>Total:</td>";
                    text += "<td align='right'>" + total + "</td>";
                    text += "<td></td>";
                    text += "<td colspan='2' align='left'>"+ net +"</td>";
                    text += "</table>";
                    out.innerHTML = text;
                }
            }
            xhttp.open("GET", "order_rest.php?list&idx=" + idx + "", true);
            xhttp.send();
        }
    </script>
</body>

</html>