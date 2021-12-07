<?php
include 'includes/session.php';

$OrderId = $_GET['oid'];
$Amount = $_GET['amt'];
$RefId = $_GET['refId'];

$conn = $pdo->open();

$stmt = $conn->prepare("UPDATE orders set status='PAID', refId=:refid where id=:OrderId");
$stmt->execute(['OrderId'=>$OrderId, 'refid'=>$RefId]);
$_SESSION['success']="Successfully made the order. Buy more?";
$pdo->close();
header("location: index.php");
?>
