<?php
    session_start();
    
    if( isset($_POST['clear']) ) {
        echo "order has been deleted...";
        session_unset();
    }
    
    if( isset($_POST['delete'])  ) {
        echo "seleted item has been delted...";
        parse_str($_SERVER['QUERY_STRING'],$pair);
        $deleteID = $pair['delete_id']; 
        echo $deleteID;
        foreach($_SESSION['products'] as $key => $product) {
            if($product['product_id'] == $deleteID) {
                unset($_SESSION['products'][$key]);//从缓存中删除
            }
        }
    }

    
    if( isset($_POST['product_quantity'])) {
        // echo $_POST['product_quantity'];
        // print_r($_SESSION['product']);
        $needToUpdate = false;
        $product = $_SESSION['product'];
        $_SESSION['product'] += array("product_quantity" => $_POST['product_quantity']);
        if(!isset($_SESSION['products'])){
            //如果没有之前的订单信息，创建并加⼊第⼀项商品
            $_SESSION['products'][0] = $_SESSION['product'];
            $totalAmount = $totalAmount+1;
            echo "The item ". $_SESSION['product']['product_name']. " has been added...<br/>";
        } else {
            print_r($_SESSION['products']);
           foreach($_SESSION['products'] as $key => $item) {
               // 遍历全部商品，打印每一个商品id
              if($item['product_id'] == $_SESSION['product']['product_id']){ 
                $needToUpdate = true;
                $item['product_quantity'] = $item['product_quantity'] + $_SESSION['product']['product_quantity'];
                echo "should update".$item["product_name"]." to ".$item['product_quantity'];
                $_SESSION['products'][$key] = $item;
              }else {
                  echo "don't need to update...";
              }
           }
           //如果已经有之前的订单信息，直接加入缓存
           if(!$needToUpdate) {
            $_SESSION['products'][] = $_SESSION['product']; 
           }
           
            // echo "The item ". $_SESSION['product']['product_name']. " has been added...<br/>";
        }
    } 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <table class="table table-striped">
        <thead>
            <td>id</td>
            <td>name</td>
            <td>unit</td>
            <td>price</td>
            <td>stock</td>
            <td>quantity</td>
            <td>delete</td>
        </thead>
        <tbody>
            <?php
                $totalPrice = 0; 
                foreach($_SESSION['products'] as $pro){
                    echo "<tr id=\"product-row\">";
                        foreach($pro as $key=>$value) {
                            echo "<td>$value</td>";
                            if($key=="product_id") {
                                $deleteID = $value;
                            }
                            echo $pro['unit_price'];
                        } 
                        //注意累加的时候要放在商品循环而不是商品属性循环中
                        $totalPrice = $totalPrice + $pro['unit_price'] * $pro['product_quantity'];
                    echo "<td><form action=\"user.php?delete_id=$deleteID\" method=\"POST\"><input type=\"submit\" name=\"delete\" value=\"x\"></form></td></tr>";
                }
                echo "<tr><td>Number of products:</td><td>".count($_SESSION['products'])."</td></tr>";
                echo "<tr><td>Total Price:</td><td>". $totalPrice ."</td></tr>";
            ?>
        </tbody>
    </table>
    <form action="user.php" method="POST">
        <input type="submit" name="clear" value="clear">
    </form>

    <form target="order" action="confirm.php" method="POST">
            <input type="submit" name="checkout" value="order">
    </form>
    <script>
        //找到table下面的<tr>
        var rowsOfTable = document.querySelectorAll('#product-row');
        var btn = document.querySelector('[name="checkout"]')
        btn.addEventListener("click", function(e){
            // 如果rowsOfTable.length 为0， 就是用户没有添加商品
            if( rowsOfTable.length == 0) {
                // 弹出提示信息
                alert("please select something first...")
                // 阻止页面跳转
                btn.parentElement.addEventListener("submit", function(e){
                    e.preventDefault();
                })
            }
        }); 
    </script>


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>