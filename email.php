<?php
    session_start();
    if( isset($_POST['confirm']) && !empty($_SESSION['products']) ) {
        echo "can send email";
        $name = $_POST['first_name']." ".$_POST['last_name'];
            $email = $_POST['email'];
            $delivery = $_POST['address']." ".$_POST['suburb']." ".$_POST['state']." ".$_POST['post_code']." ".$_POST['country'];
            $info = $name."\t".$email."\t".$delivery."\t\n";
            echo $info;
            //从缓存中获取订单信息
            $msg = "<table>
            <thead>
            <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Unit</td>
            <td>Price</td>
            <td>Stock</td>
            <td>Quantity</td>
            </tr>
            </thead>
            <tbody>";
            foreach($_SESSION['products'] as $product) {
            $msg .= "<tr>";
            foreach($product as $value){
            $msg .="<td>$value</td>";
            }
            $msg .= "</tr>";
            }
            $msg .= "</tbody></table>";
            //定义联系⼈邮件地址，邮件主题等
            $to_email = "13118157@student.uts.edu.au";
            $subject = "Order from a customer";
            $headers = "MIME-Version:1.0". "\r\n";
            $headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";//因为发送的是⽂本形式的邮件
            $msg = $msg.$info;
            $msg .=
            "<div>
            <p>Above is the summary of your order..Another email will be sent to you once your order has been processed.</p>
            <br/><br/><br/><br/><br/>
            <p>Yours, </p>
            <p>Wei Wang</p>
            </div>";
            $msg = "<p>Dear $name, </p>". $msg;
            echo $msg;
            if( mail($to_email, $subject,$msg, $headers) ) {
            //这⾥发送两封邮件，⼀封给⽤户，⼀封给联系⼈；
            mail($to_email, $subject,$msg, $headers);
            mail($email, $subject,$msg, $headers);
            echo "order submitted...";
            } else {
            echo "sry, email disabled...";
            }
            session_destroy();//记得要清楚缓存

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>