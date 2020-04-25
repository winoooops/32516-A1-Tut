<?php
    include './config.php'; 
    parse_str($_SERVER['QUERY_STRING'],$pair);
    $id = $pair['product_id']; 
    // echo $id;
    $sql = "SELECT * FROM products WHERE product_id=$id";
    $result = mysqli_query($connection,$sql);
    $product = mysqli_fetch_assoc($result);
    print_r($product);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    this is the cart page..
</body>
</html>