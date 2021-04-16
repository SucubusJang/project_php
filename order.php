<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body onload="loadContent()" style="margin: 0px;">
    <ul>
        <li><a class="active" href="index.php">Home</a></li>
        <li><a href="product.php">product</a></li>
        <li><a href="order.php">orderlist</a></li>
    </ul>
    <div class="container">
        <div class="text-header">
            <h2>Manage Order</h2>
        </div>
        <Table style="margin-top: 20px;">
            <thead>
                <th>รหัสรายการ</th>
                <th>วันที่ขาย</th>
                <th>จำนวนที่ขาย</th>
                <th>สถานะ</th>
                <th>จัดการ</th>
            </thead>
            <tbody id="show_order">

            </tbody>
        </Table>
    </div>
    <script>
        function loadContent() {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                // console.log(this.responseText);
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
            //console.log(data.length);
            text = "";
            for (i = 0; i < data.length; i++) {
                text += "<tr>";
                text += "<td>" + data[i].id + "</td>";
                text += "<td>" + data[i].date_purchase + "</td>";
                text += "<td>" + data[i].total + "</td>";
                if(data[i].status == 1){
                     text += "<td> รายการเสร็จสิ้น </td>";
                     text += "<td><button class='btn btn-success' onclick='edit_pro(" + data[i].id + ")'>แสดงรายการ</button></td>";
                }else{
                    text += "<td> กำลังดำเนินการ </td>";
                    text += "<td><button class='btn btnEmpty' onclick='edit_pro(" + data[i].id + " disabled)'>แสดงรายการ</button></td>";
                }
                text += "</tr>\n";
            }
            out.innerHTML = text;
        }
    </script>
</body>

</html>