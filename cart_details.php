<?php
	include 'includes/session.php';
	$conn = $pdo->open();

	$output = '';

	if(isset($_SESSION['user'])){
		if(isset($_SESSION['cart'])){
			foreach($_SESSION['cart'] as $row){
				$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM cart WHERE user_id=:user_id AND product_id=:product_id");
				$stmt->execute(['user_id'=>$user['id'], 'product_id'=>$row['productid']]);
				$crow = $stmt->fetch();
				if($crow['numrows'] < 1){
					$stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
					$stmt->execute(['user_id'=>$user['id'], 'product_id'=>$row['productid'], 'quantity'=>$row['quantity']]);
				}
				else{
					$stmt = $conn->prepare("UPDATE cart SET quantity=:quantity WHERE user_id=:user_id AND product_id=:product_id");
					$stmt->execute(['quantity'=>$row['quantity'], 'user_id'=>$user['id'], 'product_id'=>$row['productid']]);
				}
			}
			unset($_SESSION['cart']);
		}

		try{
			$total = 0;
			$stmt = $conn->prepare("SELECT *, cart.id AS cartid FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user");
			$stmt->execute(['user'=>$user['id']]);
			foreach($stmt as $row){
				$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
				$subtotal = $row['price']*$row['quantity'];
				$total += $subtotal;
				$output .= "
					
					<tr>
						<td class='cart-pic first-row'><img src='".$image."'></td>
						<td class='cart-title first-row'>
							<h5>".$row['name']."</h5>
						</td>
						<td class='p-price first-row'>".number_format($row['price'], 2)."</td>
						<td class='qua-col first-row'>
							<div class='quantity'>
								<div class='pro-qty'>
									<span class='minus qtybtn' data-id='".$row['cartid']."'>-</span>
									<input type='text' value='".$row['quantity']."' id='qty_".$row['cartid']."'>
									<span class='add qtybtn' data-id='".$row['cartid']."'>+</span>
								</div>
							</div>
						</td>
						<td class='total-price first-row'>".number_format($subtotal, 2)."</td>
						<td class='close-td first-row'><i class='ti-close cart_delete' data-id='".$row['cartid']."'></i></td>
					</tr>
				";
			}
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
            $total = $total - (($discount/100) * $total);
			$output .= "
				<tr>
					<td colspan='5' align='right'><b>Total Amount After Discount</b></td>
					<td><b>Rs. ".number_format($total, 2)."</b></td>
				<tr>
			";

		}
		catch(PDOException $e){
			$output .= $e->getMessage();
		}

	}
	else{
		if(count($_SESSION['cart']) != 0){
			$total = 0;
			foreach($_SESSION['cart'] as $row){
				$stmt = $conn->prepare("SELECT *,products.id as productid, products.name AS prodname, category.name AS catname FROM products LEFT JOIN category ON category.id=products.category_id WHERE products.id=:id");
				$stmt->execute(['id'=>$row['productid']]);
				$product = $stmt->fetch();
				$image = (!empty($product['photo'])) ? 'images/'.$product['photo'] : 'images/noimage.jpg';
				$subtotal = $product['price']*$row['quantity'];
				$total += $subtotal;
				$output .= "
					
					<tr>
						<td class='cart-pic first-row'><img src='".$image."'></td>
						<td class='cart-title first-row'>
							<h5>".$product['prodname']."</h5>
						</td>
						<td class='p-price first-row'>".number_format($product['price'], 2)."</td>
						<td class='qua-col first-row'>
							<div class='quantity'>
								<div class='pro-qty'>
									<span class='minus qtybtn' data-id='".$row['productid']."'>-</span>
									<input type='text' value='".$row['quantity']."' id='qty_".$row['productid']."'>
									<span class='add qtybtn' data-id='".$row['productid']."'>+</span>
								</div>
							</div>
						</td>
						<td class='total-price first-row'>".number_format($subtotal, 2)."</td>
						<td class='close-td first-row'><i class='ti-close cart_delete' data-id='".$row['productid']."'></i></td>
					</tr>
				";
			}
            //$total = $total - (0.05 * $total);
			$output .= "
				<tr>
					<td colspan='5' align='right'><b>Total</b></td>
					<td><b>Rs. ".number_format($total, 2)."</b></td>
				<tr>
			";
		}

		else{
			$output .= "
				<tr>
					<td colspan='6' align='center'>Shopping cart empty</td>
				<tr>
			";
		}
		
	}

	$pdo->close();
	echo json_encode($output);

?>

