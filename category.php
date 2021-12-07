<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body>

    <!-- Page Preloder -->
<div id="preloder">
	<div class="loader"></div>
</div>

<?php include 'includes/navbar.php'; ?>
<?php
    $availableMin = 0;
    $availableMax = 10000;
    $conn = $pdo->open();
	$catid=$_GET['id'];
    {
        $stmt = $conn->prepare("SELECT min(price) as minprice, max(price) as maxprice FROM products where category_id=:catid");
        $stmt->execute(['catid'=>$catid]);
    }
    foreach($stmt as $row){
         $availableMin = $row['minprice'];
         $availableMax = $row['maxprice'];
    }
    $pdo->close();
?>
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="/"><i class="fa fa-home"></i> Home</a>
                        <span>Category</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Product Shop Section Begin -->
    <section class="product-shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
                    <div class="filter-widget">
						<?php
							$conn = $pdo->open();
							{
								$stmt = $conn->prepare("SELECT * FROM category where id=:catid");
								$stmt->execute(['catid'=>$catid]);
							}
							foreach($stmt as $row){
								echo '<h4 class="fw-title">'.$row['name'].'</h4>';
							}
							$pdo->close();
						?>
                        <h4 class="fw-title">Categories</h4>
                    </div>
                    <form action="shop.php" class="filter-widget">
                        <h4 class="fw-title">Price</h4>
                        <div class="filter-range-wrap">
                            <div class="range-slider">
                                <div class="price-input">
                                    <input type="text" id="minamount" name="minPrice">
                                    <input type="text" id="maxamount" name="maxPrice">
                                </div>
                            </div>
                            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content" data-min="<?php echo $availableMin; ?>" data-max="<?php echo $availableMax; ?>">
                                <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                            </div>
                        </div>
                        <button type="submit" class="filter-btn">Filter</button>
                    </form>
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
				
                    <div class="product-list">
                        <div class="row">
                            <?php
                                $conn = $pdo->open();
                                $availableMin = 0;
                                $availableMax = 10000;
                                if(isset($_GET['minPrice'])){
                                    $availableMin = (int)$_GET['minPrice'];
                                }
                                if(isset($_GET['maxPrice'])){
                                    $availableMax = (int)$_GET['maxPrice'];
                                }
								$stmt = $conn->prepare("SELECT * FROM products where category_id=:catid and price between :availableMin and :availableMax");
								$stmt->execute(['catid'=>$catid,'availableMin'=>$availableMin, 'availableMax'=>$availableMax]);

                                $stmt->execute();
                                foreach($stmt as $row){
                                    $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/noimage.jpg';
                            ?>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="product-item">
                                        <div class="pi-pic">
                                            <img src="<?php echo $image;?>" alt="">
                                            <ul>
                                                <li class="w-icon active"><a href="#" class="addToCart" data-id="<?php echo $row['id'] ?>"><i class="icon_bag_alt"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="pi-text">
                                            <a href="/product.php?id=<?php echo $row2['id'] ?>">
                                                <h5><?php echo $row['name'];?></h5>
                                            </a>
                                            <div class="product-price">
                                                रू  <?php echo $row['price'];?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                }
                                $pdo->close();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Shop Section End -->

<?php include 'includes/footer.php'; ?>
<?php include 'includes/scripts.php'; ?>
</body>
</html>