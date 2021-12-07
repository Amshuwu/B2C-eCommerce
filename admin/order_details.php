<?php
	include 'includes/session.php';

	$id = $_POST['id'];

	$conn = $pdo->open();

	$output = array('list'=>'');
	
	$stmt = $conn->prepare("SELECT * FROM orders where id=:id");
	$stmt->execute(['id'=>$id]);
	$res = $stmt->fetch();

	$output['transaction'] = $res["id"];
	$total = $res["orderTotal"];
	$output['date'] = $res["date"];

	$stmt = $conn->prepare("SELECT * FROM orderitems INNER JOIN products ON products.id=orderitems.productid WHERE orderitems.orderid=:id");
	$stmt->execute(['id'=>$id]);
	foreach($stmt as $row){
		$output['list'] .= "
			<tr class='prepend_items'>
				<td>".$row['name']."</td>
				<td>Rs. ".number_format($row['price'], 2)."</td>
				<td>".$row['quantity']."</td>
				<td>Rs. ".number_format($row['total'], 2)."</td>
			</tr>
		";
	}
    //$totam = (0.05 * $totam);
	$output['total'] = '<b>Rs. '.number_format($total, 2).'</b>';
	$pdo->close();
	echo json_encode($output);

?>
