<?php
    include './config.php'; 
    session_start();
    parse_str($_SERVER['QUERY_STRING'],$pair);
    $id = $pair['product_id']; 
    // echo $id;
    $sql = "SELECT * FROM products WHERE product_id=$id";
    $result = mysqli_query($connection,$sql);
    $product = mysqli_fetch_assoc($result);
    $_SESSION['product'] = $product;
    print_r($product);

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
    <table class="table-dark table-striped">
        <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Price</td>
                <td>Unit</td>
                <td>Stock</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                    foreach($product as $key => $value) {
                        echo "<td>$value</td>";
                    }
                ?>
            </tr>
        </tbody>
    </table>
    <form action="./user.php" method="POST" target="order">
        <input type="number" name="product_quantity" min="1" max="20" required>
        <input type="submit" name="quantity" value="Add to cart">
    </form>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>