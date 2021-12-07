<?php
	include 'includes/session.php';

	$conn = $pdo->open();

	$id = $_POST['productId'];
	$rating = $_POST['rating'];
	$review = $_POST['message'];

	if(isset($_SESSION['user'])){
        $stmt = $conn->prepare("INSERT INTO reviews (productid, userid, rating, review, date) VALUES (:id, :userid, :rating, :review, :date)");
        $stmt->execute(['userid'=>$user['id'], 'id'=>$id, 'rating'=>$rating, 'review'=>$review, 'date'=>date('Y-m-d')]);
	}

	$pdo->close();
    header('location: product.php?id='.$id);
?>