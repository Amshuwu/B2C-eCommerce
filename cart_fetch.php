<?php
	include 'includes/session.php';
	$conn = $pdo->open();

	$output = array('list'=>'','count'=>0);
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
				$output['list'] .= '
				<tr>
				<td class="si-pic"><img src="'.$image.'" alt=""></td>
				<td class="si-text">
					<div class="product-selected">
					<p>Rs. '.$row['price'].' x '.$row['quantity'].'</p>
					<h6>'.$productname.'</h6>
					</div>
				</td>
				</tr>';
			}
		}
		catch(PDOException $e){
			$output['message'] = $e->getMessage();
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
		$output['list'] =
		'
		<a href="/cart.php">
		<i class="icon_bag_alt"></i>
		<span>'.$output['count'].'</span>
		</a>
		<div class="cart-hover">
		<div class="select-items">
			<table>
			<tbody>
			'.$output['list'].'
			</tbody>
			</table>
		</div>
		<div class="select-total">
			<span>total:</span>
			<h5>Rs '.$total.'</h5>
		</div>
		<div class="select-button">
			<a href="/cart.php" class="primary-btn checkout-btn">Go To Cart</a>
		</div>
		</div>';
	}
	else{
		if(!isset($_SESSION['cart'])){
			$_SESSION['cart'] = array();
		}

		if(empty($_SESSION['cart'])){
			$output['count'] = 0;
		}
		else{
			foreach($_SESSION['cart'] as $row){
				$output['count']++;
				$stmt = $conn->prepare("SELECT *, products.name AS prodname, products.id as prodid, category.name AS catname FROM products LEFT JOIN category ON category.id=products.category_id WHERE products.id=:id");
				$stmt->execute(['id'=>$row['productid']]);
				$product = $stmt->fetch();
				$image = (!empty($product['photo'])) ? 'images/'.$product['photo'] : 'images/noimage.jpg';
				$total += $product['price']*$row['quantity'];
				$output['list'] .= '
					<tr>
					<td class="si-pic"><img src="'.$image.'" alt=""></td>
					<td class="si-text">
						<div class="product-selected">
						<p>Rs '.$product['price'].' x '.$row['quantity'].'</p>
						<h6>'.$product['prodname'].'</h6>
						</div>
					</td>
					</tr>';
			}
            //$total = $total - (0.05 * $total);
			$output['list'] =
			'
            <a href="/cart.php">
			<i class="icon_bag_alt"></i>
			<span>'.$output['count'].'</span>
			</a>
			<div class="cart-hover">
			<div class="select-items">
				<table>
				<tbody>
				'.$output['list'].'
					
				</tbody>
				</table>
			</div>
			<div class="select-total">
				<span>total:</span>
				<h5>Rs '.$total.'</h5>
			</div>
			<div class="select-button">
				<a href="/cart.php" class="primary-btn checkout-btn">Go To Cart</a>
			</div>
			</div>';
		}
	}
	$pdo->close();
	echo json_encode($output);

?>

