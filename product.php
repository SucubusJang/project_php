<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .container {
            width: 960px;
            margin: 0 auto;
            height: auto;
            text-align: center;
        }

        table {
            text-align: center;
            margin: 0 auto;
        }
    </style>
</head>

<body onload="loadContent()">
    <div class="container">
        <h2>จัดการสินค้า</h2>
        <button onclick="show_add()">เพิ่มสินค้า</button>
        <Table>
            <thead>
                <th>รหัสสินค้า</th>
                <th>ชื่อสินค้า</th>
                <th>ราคาสินค้า</th>
                <th>จำนวน</th>
                <th>จัดการ</th>
            </thead>
            <tbody id="show_product">

            </tbody>
        </Table>
        <div id="out" style="margin-top: 50px;"></div>
    </div>
    <script>
        function loadContent() {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                console.log(this.readyState + ", ", this.status);
                if (this.readyState == 4 && this.status == 200) {
                    // console.log(this.responseText);
                    data = JSON.parse(this.responseText);
                    create_Table(data);
                }
            }
            xhttp.open("GET", "product_rest.php?show_pro=show_pro", true);
            xhttp.send();
        }

        function create_Table(data) {
            out = document.getElementById("show_product");
            //console.log(data.length);
            text = "";
            for (i = 0; i < data.length; i++) {
                text += "<tr>";
                for (info in data[i]) {
                    text += "<td>" + data[i][info] + "</td>";
                }
                text += "<td><button onclick='edit_pro(" + data[i].id + ")'>แก้ไข</button> <button onclick='del_pro(" + data[i].id + ")'>ลบสินค้า</button></td>";
                text += "</tr>\n";
            }
            out.innerHTML = text;
        }

        function show_add() {
            out = document.getElementById("out");
            text = "";
            text = "<table border='1'>";
            text += "<tr><td><label>ชื่อสินค้า</label></td>";
            text += "<td><input type='text' name='' id='name'></td></tr>";
            text += "<tr><td><label>ราคาสินค้า</label></td>";
            text += "<td><input type='number' name='' id='price'></td></tr>";
            text += "<tr><td><label>จำนวนสินค้า</label></td>";
            text += "<td><input type='number' name='' id='stock'></td></tr>";
            text += "<tr><td colspan='2'><button onclick='add_pro()'>เพิ่มสินค้า</button></td></tr>";
            text += "</table>";
            out.innerHTML = text;
        }

        function add_pro() {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                // console.log(this.readyState + ", ", this.status);
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                }
            }
            xhttp.open("POST", "product_rest.php", true);
            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            name_pro = document.getElementById("name");
            price_pro = document.getElementById("price");
            stock_pro = document.getElementById("stock");
            xhttp.send("name_pro=" + name_pro.value + "&price_pro=" + price_pro.value + "&stock_pro=" + stock_pro.value);
            name_pro.value = null;
            price_pro.value = null;
            stock_pro.value = null;
            // window.location.href = "product.php";
        }
        function edit_pro(idx) {
           // alert(idx);
            label = ['ชื่อสินค้า', 'ราคา', 'จำนวนสินค้า'];
            Ids = ['name', 'price', 'stock'];
            type = ['text','number','number'];
            out = document.getElementById("out");
            let xhttp = new XMLHttpRequest();
            text = "";
            j = 0;
            xhttp.onreadystatechange = function() {
                // console.log(this.readyState + ", ", this.status);
                if (this.readyState == 4 && this.status == 200) {
                     console.log(this.responseText);
                    data = JSON.parse(this.responseText);
                    text = "<table border='1'>";
                    for (i = 0; i < data.length; i++) {
                        text += "<tr>";
                        for (info in data[i]) {
                            text += "<tr><td>" + label[j] + "</td><td><input type='"+type[j]+"' name='' id='" + Ids[j] + "' value='" + data[i][info] + "'></td></tr>";
                            j++;
                        }
                        text += "</tr>";
                    }
                    text += "<tr><td colspan='2'><button onclick='edit_data(" + idx + ")'>Edit</button></td></tr>";
                    out.innerHTML = text + "</table>";
                }
            }
            xhttp.open("GET", "product_rest.php?edit_Id=" + idx + "", true);
            xhttp.send();
        }

        function edit_data(idx) {
            //  alert(idx);
            name = document.getElementById("name").value;
            price = document.getElementById("price").value;
            stock = document.getElementById("stock").value;
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                // console.log(this.readyState + ", ", this.status);
                console.log(this.responseText);
            }
            xhttp.open("POST", "product_rest.php", true);
            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhttp.send("name=" + name + "&price=" + price + "&stock=" + stock + "&Id=" + idx);
            window.location.href = "product.php";
        }

        function del_pro(idx) {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                     console.log(this.responseText);
                }
            }
            xhttp.open("GET", "product_rest.php?del_Id=" + idx + "", true);
            xhttp.send();
            window.location.href = "product.php";
        }
    </script>
</body>

</html>