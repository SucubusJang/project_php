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
            let xhttp = new XMLHttpRequest();
            out = document.getElementById("show_listproduct"); 
            text = "";
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // console.log(this.responseText);
                    data = JSON.parse(this.responseText);
                   
                    text = "<table border='1'>";
                    for(i=0;i<data.length;i++){
                        text += "<tr>";
                        for(info in data[i]){
                            text += "<td>"+data[i][info]+"</td>";
                        }   
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