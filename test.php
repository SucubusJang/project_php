<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <style>
        .button2 {
            display: inline-block;
            border-radius: 4px;
            background-color: rgb(243, 103, 103);
            border: none;
            color: #FFFFFF;
            text-align: center;
            font-size: 15px;
            padding: 10px;
            width: 90%;
            transition: all 0.5s;
            cursor: pointer;
            margin: 5px;
        }

        .button2 span {
            cursor: pointer;
            display: inline-block;
            position: relative;
            transition: 0.5s;
        }

        .button2 span:after {
            content: '\00bb';
            position: absolute;
            opacity: 0;
            top: 0;
            right: -20px;
            transition: 0.5s;
        }

        .button2:hover span {
            padding-right: 25px;
        }

        .button2:hover span:after {
            opacity: 1;
            right: 0;
        }

        .button2:hover {
            background-color: red;
        }
    </style>
</head>

<body onload="productList()" style="margin: 0;">
    <div class="mx-auto" style="width: 200px;">
        <img id="preview" src="https://placehold.co/200x200" alt="" width="200px">
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01">Image</span>
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="img" onchange="previewImage(this)">
            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm  bg-white rounded fixed-top">
        <a class="navbar-brand" href="product_list.php"><span class="text-primary" style="font-weight: bold;">ITI</span> <span class="badge bg-primary">SHOP</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link active" aria-current="page" href="product_list.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
                            <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z" />
                        </svg>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="order_list.php"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
                            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                            <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
                        </svg></a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <a class="nav-link " style="color: black;" href="order.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                    </svg>
                    <span class="badge bg-danger" style="color: white;" id="num"></span>
                </a>
            </form>
        </div>
    </nav>
    <div class="container" style="width: 70%;margin-top:100px">
        <div>
            <h1 style="font-weight: bold;">รายการสินค้า <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">เพิ่มสินค้า</button>
            </h1>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="mx-auto" style="width: 200px;">
                                <img id="preview" src="https://placehold.co/200x200" alt="" width="200px">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Image</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="img" onchange="previewImage(this)">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="ชื่อ" id="pname">
                                </div>
                            </div>
                            <div class="form-row" style="margin-top: 10px;">
                                <div class="col">
                                    <input type="number" class="form-control" placeholder="จำนวน" id="number">
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" placeholder="ราคา" id="price">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="insertProduct()">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="product" style="text-align: center;">
        </div>
    </div>
    <script>
        let data;

        function productList() {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                text = "";
                if (this.readyState == 4 && this.status == 200) {
                    data = JSON.parse(this.responseText);
                    for (i = 0; i < data.length; i++) {
                        text += "<div class='col-sm-12 col-md-6 col-lg-3' style='padding:10px'>";
                        text += '<div class="card shadow-sm p-3 mb-5 bg-white rounded" style="width: 15rem;border:none; ">';
                        text += '<img  src="' + data[i].image + '" class="card-img-top rounded mx-auto d-block" style="width: 100px;">';
                        text += '<div class="card-body">';
                        text += '<h5 class="card-title">' + data[i].name + '</h5>';
                        text += "       ราคา ฿ " + data[i].cost;
                        text += " <input type='number' class='form-control' name='' id='n" + i + "' size='4' max='" + data[i].stock + "' min='1' value='1'>";
                        text += "       <button class='button2' style='vertical-align:middle' onclick='addProduct(" + i + ")'><span>เพิ่มไปยังรถเข็น</span></button>";
                        text += "   </div>";
                        text += "</div>";
                        text += "</div>";
                        text += "</div>";
                    }
                    document.getElementById("product").innerHTML = text;
                }
            }
            xhttp.open("GET", "rest.php?productList", true);
            xhttp.send();
        }

        function addProduct(id) {
            qty = document.getElementById("n" + id);
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText == 1) {
                        alert("เพิ่มสำเร็จ");
                        numProductInOrder();
                    } else alert("เพิ่มสินค้าไม่สำเร็จ");
                }
            }
            xhttp.open("POST", "rest.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("addOrder&id=" + data[id].productID + "&qty=" + qty.value + "&price=" + data[id].cost);
        }
        numProductInOrder();

        function numProductInOrder() {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    json = JSON.parse(this.responseText);
                    document.getElementById("num").innerHTML = json[0].num;
                }
            }
            xhttp.open("GET", "rest.php?numOrderProductByOrderId", true);
            xhttp.send();
        }
        let img_data = "";

        function previewImage(input) {
            alert(input);
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result)
                    img_data = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function insertProduct() {
            var formdata = new FormData();
            formdata.append('insertProuct', "");
            formdata.append('img', img_data);
            formdata.append('name', document.getElementById("pname").value);
            formdata.append('number', document.getElementById("number").value);
            formdata.append('price', document.getElementById("price").value);
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText) {
                        productList();
                        alert("เพิ่มสำเร็จ");
                        $('#exampleModal').modal('hide');
                    } else alert("เพิ่มสินค้าไม่สำเร็จ");
                }
            }
            xhttp.open("POST", "rest.php", true);
            //xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(formdata);
        }
    </script>
</body>

</html>