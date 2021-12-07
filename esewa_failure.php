<?php
include 'includes/session.php';

$OrderId = $_GET['oid'];
$Amount = $_GET['amt'];
$RefId = $_GET['refId'];

$_SESSION['error']="failure while payment";
header("location: index.php");//save
?>
