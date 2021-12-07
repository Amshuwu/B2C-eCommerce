<?php
	include 'includes/session.php';

	if(isset($_POST['upload'])){
		$id = $_POST['id'];
		$filename = $_FILES['picture']['name'];

		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT * FROM category WHERE id=:id");
		$stmt->execute(['id'=>$id]);
		$row = $stmt->fetch();

		if(!empty($filename)){
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$new_filename = $row['id'].'_'.time().'.'.$ext;
			move_uploaded_file($_FILES['picture']['tmp_name'], '../images/'.$new_filename);	
		}
		
		try{
			$stmt = $conn->prepare("UPDATE category SET picture=:picture WHERE id=:id");
			$stmt->execute(['picture'=>$new_filename, 'id'=>$id]);
			$_SESSION['success'] = 'Category picture updated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();

	}
	else{
		$_SESSION['error'] = 'Select Category to update picture first';
	}

	header('location: category.php');
?>