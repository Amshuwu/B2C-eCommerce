<?php
include 'includes/session.php';

$PaymentMethod = $_POST['PaymentMethod'];
$Name = $_POST['Name'];
$Email = $_POST['Email'];
$Phone = $_POST['Phone'];
$Address = $_POST['Address'];
$Id = $_POST['OrderId'];
$Status = "PENDING";

$conn = $pdo->open();

$stmt = $conn->prepare("SELECT * FROM orders where id=:OrderId");
$stmt->execute(['OrderId'=>$Id]);
$discount = 0;
if(!isset($_SESSION['user']) || $user['numberoforders'] < 50){
	if($_POST['PaymentMethod'] == "ESEWA"){
		$discount = 5;
}
}
$row = $stmt->fetch();
$total = $row['orderTotal'];
$total = $total - (($discount / 100) * $total);

$stmt = $conn->prepare("UPDATE orders set fullname=:name, email=:email, phone=:phone, address=:address, paymentMethod=:paymentMethod, status=:status, orderTotal=:total where id=:OrderId");
$stmt->execute(['name'=>$Name, 'email'=>$Email, 'phone'=>$Phone, 'address'=>$Address, 'paymentMethod'=>$PaymentMethod, 'status'=>$Status, 'total'=>$total, 'OrderId'=>$Id]);
$pdo->close();

if($_POST['PaymentMethod'] == "COD"){
    $_SESSION['success'] = 'Created an order';
}
?>
