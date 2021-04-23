<?php include_once("head.php"); ?>

<body onload="loadContent()" style="margin: 0px; font-family: 'Kanit', sans-serif;">
    <?php
    include_once("nav.php");
    ?>
    <div class="container">
        
        <div class="text-header">
            <h2>Manage Product</h2>
        </div>
        <button onclick="show_add()" class="btn btn-success" style="margin-bottom: 10px; margin-top: 10px"><i class="far fa-plus-square"></i> เพิ่มสินค้า</button>
        <table class="table table-striped" style="margin-top: 20px">
            <thead class="table-dark">
                <th>รหัสสินค้า</th>
                <th>ภาพสินค้า</th>
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
            text = "";
            for (i = 0; i < data.length; i++) {
                text += "<tr>";
                text += "<td>"+data[i].id+"</td>";
                text += "<td><img  src='" + data[i].image + "' style='width: 100px;' height='auto'></td>";
                text += "<td>"+data[i].name+"</td>";
                text += "<td>"+data[i].price+"</td>";
                text += "<td>"+data[i].stock+"</td>";
                text += "<td><button class='btn btn-warning' onclick='edit_pro(" + data[i].id + ")'><i class='fas fa-edit'></i> แก้ไข</button> <button class='btn btn-danger' onclick='del_pro(" + data[i].id + ")'><i class='fas fa-trash-alt'></i> ลบสินค้า</button></td>";
                text += "</tr>";
                // text += "<tr>";
                // for (info in data[i]) {
                //     text += "<td>" + data[i][info] + "</td>";
                // }
               
                // text += "</tr>\n";
            }
            out.innerHTML = text;
        }

        function show_add() {
            out = document.getElementById("out");
            text = "";
            text += `<table class="table table-striped" style="margin-top: 20px">
                     <tr><td colspan="2">
                        <div class="mx-auto" style="width: 200px;">
                        <img id="preview" src="https://placehold.co/200x200" alt="" width="200px">
                     </div></td></tr>
                     <tr><td><label>ชื่อสินค้า</label></td>
                     <td><input class="form-control" type="text" name="" id="name"></td></tr>
                     <tr><td><label>ราคาสินค้า</label></td>
                     <td><input class="form-control" type="number" name="" id="price"></td></tr>
                     <tr><td><label>จำนวนสินค้า</label></td>
                     <td><input class="form-control" type="number" name="" id="stock"></td></tr>
                     <tr><td>เพิ่มรูปภาพ</td>
                     <td><div class="input-group">
                        <input type="file" class="form-control" id="img" onchange="previewImage(this)">
                     </div></td></tr>
                     <tr><td colspan="2"><button type="submit" class="btn btn-success" onclick="add_pro()"><i class="far fa-plus-square"></i> เพิ่มสินค้า</button></td></tr>
                     </table>`;
            out.innerHTML = text;
        }
        let img_data = "";

        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result)
                    img_data = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function add_pro() {
            var formdata = new FormData();
            formdata.append('img', img_data);
            formdata.append('name_pro', document.getElementById("name").value);
            formdata.append('price_pro', document.getElementById("price").value);
            formdata.append('stock_pro',document.getElementById("stock").value);
            out = document.getElementById("out");
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText == 1) {
                        alert(`เพิ่มสินค้าสำเร็จ`);
                        out.innerHTML = "";
                        loadContent();
                    } else {
                        alert('เพ่ิมสินค้าไม่สำเร็จ');
                    }
                }
            }
            xhttp.open("POST", "product_rest.php", true);
            // xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhttp.send(formdata);
           
        }

        function edit_pro(idx) {
            label = ['ชื่อสินค้า', 'ราคา', 'จำนวนสินค้า'];
            Ids = ['name', 'price', 'stock'];
            type = ['text', 'number', 'number'];
            out = document.getElementById("out");
            let xhttp = new XMLHttpRequest();
            text = "";
            j = 0;
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    data = JSON.parse(this.responseText);
                    text = "<table class='table table-striped' style='margin-top: 20px'>";
                    for (i = 0; i < data.length; i++) {
                        text += "<tr>";
                        for (info in data[i]) {
                            text += "<tr><td>" + label[j] + "</td><td><input class='form-control' type='" + type[j] + "' name='' id='" + Ids[j] + "' value='" + data[i][info] + "'></td></tr>";
                            j++;
                        }
                        text += "</tr>";
                    }
                    text += "<tr><td colspan='2'><button class='btn btn-warning' onclick='edit_data(" + idx + ")'><i class='fas fa-edit'></i> แก้ไข</button></td></tr>";
                    out.innerHTML = text + "</table>";
                }
            }
            xhttp.open("GET", "product_rest.php?edit_Id=" + idx + "", true);
            xhttp.send();
        }

        function edit_data(idx) {
            out = document.getElementById("out");
            name = document.getElementById("name").value;
            price = document.getElementById("price").value;
            stock = document.getElementById("stock").value;
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText == 1) {
                        alert(`แก้ไขสินค้าสำเร็จ`);
                        out.innerHTML = "";
                        loadContent();
                    } else {
                        alert(`แก้ไขสินค้าไม่สำเร็จ`);
                    }
                }
            }
            xhttp.open("POST", "product_rest.php", true);
            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhttp.send("name=" + name + "&price=" + price + "&stock=" + stock + "&Id=" + idx);
        }

        function del_pro(idx) {
            out = document.getElementById("out");
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText == 1) {
                        alert("ลบสินค้าสำเร็จ");
                        out.innerHTML = "";
                        loadContent();
                    } else {
                        alert("ลบสินค้าไม่สำเร็จ");
                    }
                }
            }
            xhttp.open("GET", "product_rest.php?del_Id=" + idx + "", true);
            xhttp.send();
        }
    </script>
</body>

</html>