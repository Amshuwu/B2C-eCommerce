<?php
include 'includes/session.php';
function generateRandomString($length = 9) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$conn = $pdo->open();
$id=generateRandomString(9);
echo $id;
try{
    $stmt = $conn->prepare("INSERT INTO orders (id,date) VALUES (:id,:date)");
$stmt->execute(['id'=>$id,'date'=>date("Y-m-d H:i:s")]);
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }

$total = 0;

if(isset($_SESSION['user'])){
    try{
        $stmt = $conn->prepare("SELECT *, products.name AS prodname, products.id as prodid, category.name AS catname FROM cart LEFT JOIN products ON products.id=cart.product_id LEFT JOIN category ON category.id=products.category_id WHERE user_id=:user_id");
        $stmt->execute(['user_id'=>$user['id']]);
        foreach($stmt as $row){
            $output['count']++;
            $image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
            $productname = (strlen($row['prodname']) > 30) ? substr_replace($row['prodname'], '...', 27) : $row['prodname'];
            $total += $row['price']*$row['quantity'];

            
            $stmt = $conn->prepare("insert into orderitems(orderid, productid, productprice, quantity, total) values(:orderid, :productid, :price, :quantity, :total)");
            $stmt->execute(['orderid'=>$id, 'productid'=>$row['prodid'], 'price'=>$row['price'], 'quantity'=>$row['quantity'], 'total'=>$row['price']*$row['quantity']]);
        }
        
        $stmt = $conn->prepare("delete from cart WHERE user_id=:user_id");
        $stmt->execute(['user_id'=>$user['id']]);
    
        $stmt = $conn->prepare("update users set numberoforders=IFNULL(numberoforders,0)+1 where id=:user_id");
        $stmt->execute(['user_id'=>$user['id']]);
        $discount = 0;
        if($user['numberoforders'] >= 500){
            $discount = 25;
        }
        else if($user['numberoforders'] >= 100){
            $discount = 20;
        }
        else if($user['numberoforders'] >= 50){
            $discount = 10;
        }
    }
    catch(PDOException $e){
        echo $e->getMessage();
        
    }
}
else{
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = array();
    }
    if(empty($_SESSION['cart'])){
    }
    else{
        foreach($_SESSION['cart'] as $row){
            $output['count']++;
            $stmt = $conn->prepare("SELECT *, products.name AS prodname, products.id as prodid, category.name AS catname FROM products LEFT JOIN category ON category.id=products.category_id WHERE products.id=:id");
            $stmt->execute(['id'=>$row['productid']]);
            $product = $stmt->fetch();
            $image = (!empty($product['photo'])) ? 'images/'.$product['photo'] : 'images/noimage.jpg';
            $total += $product['price']*$row['quantity'];
            
            $stmt = $conn->prepare("insert into orderitems(orderid, productid, productprice, quantity, total) values(:orderid, :productid, :price, :quantity, :total)");
            $stmt->execute(['orderid'=>$id, 'productid'=>$product['prodid'], 'price'=>$product['price'], 'quantity'=>$row['quantity'], 'total'=>$product['price']*$row['quantity']]);
        }
    }
    unset($_SESSION['cart']);
}
//need to calculate discount here too save. uh user ko gold silver status ka dekhaune ho like its literally 50+ orders so idk. admin le herne ho ki user le aafaaid pmainni admin le

    $stmt = $conn->prepare("UPDATE orders set status='PENDING', orderTotal=:total where id=:orderid");
$stmt->execute(['total'=>$total, 'orderid'=>$id]);
$pdo->close();

header('location: checkout.php?id='.$id);
?>
