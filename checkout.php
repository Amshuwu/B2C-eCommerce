<?php include 'includes/session.php'; ?>
<?php 
	$orderId = $_GET['id'];
	$conn = $pdo->open();

	$stmt = $conn->prepare("SELECT * FROM orders WHERE id = :id");
	$stmt->execute(['id' => $orderId]);
	$order = $stmt->fetch();
	$pdo->close();
	$total = $order['orderTotal'];
	if(!isset($_SESSION['user']) || $user['numberoforders'] < 50){
		$total = $total - (0.05 * $total);
	}
?>
<?php include 'includes/header.php'; ?>
<body>

    <!-- Page Preloder -->
<div id="preloder">
	<div class="loader"></div>
</div>

<?php include 'includes/navbar.php'; ?>

    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="/index.php"><i class="fa fa-home"></i> Home</a>
                        <a href="/shop.php">Shop</a>
                        <span>Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
			<div class="row">
				<h2>Due Amount: Rs. <?php echo $order['orderTotal'] ?></h2>
			</div>
            <div class="row">
                <div class="col-lg-6">
					<div class="form-group">
						<p>Payment Method</p>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="PaymentMethod" id="PaymentMethodCOD" value="COD" checked>
							<label class="form-check-label" for="PaymentMethodCOD">
								Cash On Delivery
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="PaymentMethod" id="PaymentMethodEsewa" value="ESEWA">
							<label class="form-check-label" for="PaymentMethodEsewa">
								Esewa
								<?php
									if(!isset($_SESSION['user']) || $user['numberoforders'] < 50){
										echo " (get 5% off on payment with esewa)";

									}
								?>
							</label>
						</div>
					</div>
                </div>
				<div class="col-lg-6">
					<h3>Shipping Info</h3>
					<br />
					<div class="form-group">
						<label for="Name">Name</label>
						<input type="text" class="form-control" id="Name" name="Name">
					</div>
					<div class="form-group">
						<label for="Email">Email</label>
						<input type="email" class="form-control" id="Email" name="Email">
					</div>
					<div class="form-group">
						<label for="Phone">Phone</label>
						<input type="text" class="form-control" id="Phone" name="Phone">
					</div>
					<div class="form-group">
						<label for="Address">Address</label>
						<input type="text" class="form-control" id="Address" name="Address">
					</div>
				</div>
            </div>
			<form action="https://uat.esewa.com.np/epay/main" method="POST" id="esewaform" style="display: none;">
			<input value="<?php echo $total ?>" name="tAmt" type="hidden">
			<input value="<?php echo $total ?>" name="amt" type="hidden">
			<input value="0" name="txAmt" type="hidden">
			<input value="0" name="psc" type="hidden">
			<input value="0" name="pdc" type="hidden">
			<input value="EPAYTEST" name="scd" type="hidden">
			<input value="<?php echo $orderId; ?>" name="pid" type="hidden">
			<input value="http://127.0.0.1/esewa_success.php" type="hidden" name="su">
			<input value="http://127.0.0.1/esewa_failure.php" type="hidden" name="fu">
			</form>
			<div class="row">
				<div class="col-md-4">
					<button type="button" class="btn btn-primary" id="continue">Continue</button>
				</div>
			</div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->


<?php include 'includes/footer.php'; ?>
<?php include 'includes/scripts.php'; ?>
<script>
$("#continue").on('click', function(){
	var params = {
		PaymentMethod: $("#PaymentMethodCOD").is(":checked") ? "COD" : "ESEWA",
		Name: $("#Name").val(),
		Email: $("#Email").val(),
		Phone: $("#Phone").val(),
		Address: $("#Address").val(),
		OrderId: "<?php echo $orderId; ?>"
	};
	$.ajax({
		url: "/continue_checkout.php",
		data: params,
		method: "POST",
		success: function(){
			if($("#PaymentMethodEsewa").is(":checked")){
				$("#esewaform").submit();
			}else{
				location.href = "/";
			}
		},
		error: function(err){
			console.log(err);
			alert("Some error occured");
		}
	})
});
</script>
</body>
</html>