<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$name = $_POST['name'];
		$category = $_POST['category'];
		$price = $_POST['price'];
		$description = $_POST['description'];
		$stock = $_POST['stock'];
		$filename = $_FILES['photo']['name'];

		$conn = $pdo->open();

		if(!empty($filename)){
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$new_filename = time().'.'.$ext;
			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$new_filename);	
		}
		else{
			$new_filename = '';
		}

		try{
			$stmt = $conn->prepare("INSERT INTO products (category_id, name, description, price, photo, stock) VALUES (:category, :name, :description, :price, :photo, :stock)");
			$stmt->execute(['category'=>$category, 'name'=>$name, 'description'=>$description, 'price'=>$price, 'photo'=>$new_filename, 'stock'=> $stock]);
			$_SESSION['success'] = 'User added successfully';

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up product form first';
	}

	header('location: products.php');

?>