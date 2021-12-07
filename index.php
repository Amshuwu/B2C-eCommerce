<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body>

    <!-- Page Preloder -->
<div id="preloder">
	<div class="loader"></div>
</div>

<?php include 'includes/navbar.php'; ?>
<?php 

if(isset($_SESSION['error'])){
    echo "
      <div class='callout callout-danger text-center'>
        <p>".$_SESSION['error']."</p> 
      </div>
    ";
    unset($_SESSION['error']);
  }
  if(isset($_SESSION['success'])){
    echo "
      <div class='callout callout-success text-center'>
        <p>".$_SESSION['success']."</p> 
      </div>
    ";
    unset($_SESSION['success']);
  }
?>

    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="hero-items owl-carousel">
            <div class="single-hero-items set-bg" data-setbg="img/hero-1.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <span>Bag,kids</span>
                            <h1>Best Kids Items</h1>
                            <p>Get the best kids items that you possibly can</p>
                            <a href="/category.php?id=3" class="primary-btn">Shop Now</a>
                        </div>
                    </div>
                    <div class="off-card">
                        <h2>Sale <span>50%</span></h2>
                    </div>
                </div>
            </div>
            <div class="single-hero-items set-bg" data-setbg="img/hero-2.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <span>Bag,kids</span>
                            <h1>Opening offer</h1>
                            <p>We have opened recently. Giving cashback to 10 lucky winners. What are you waiting for? Start shopping now</p>
                            <a href="/shop.php" class="primary-btn">Shop Now</a>
                        </div>
                    </div>
                    <div class="off-card">
                        <h2>Sale <span>50%</span></h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <?php
        $conn = $pdo->open();

        try{
            $stmt = $conn->prepare("SELECT * FROM category");
            $stmt->execute();
            foreach($stmt as $row){
            $image = (!empty($row['picture'])) ? '../images/'.$row['picture'] : '../images/noimage.jpg';
            ?>
                <section class="women-banner spad">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="product-large set-bg" data-setbg="<?php echo $image; ?>">
                                    <h2><?php echo $row['name']; ?></h2>
                                    <a href="/category.php?id=<?php echo $row['id']; ?>">Discover More</a>
                                </div>
                            </div>
                            <div class="col-lg-8 offset-lg-1">
                                <div class="filter-control">
                                    
                                </div>
                                <div class="product-slider owl-carousel">
                                    <?php 
                                        $catid = $row['id'];
                                        $stmt2 = $conn->prepare("SELECT * FROM products WHERE category_id=:catid LIMIT 6");
                                        $stmt2->execute(['catid'=>$catid]);
                                        foreach($stmt2 as $row2){
                                        $image2 = (!empty($row2['photo'])) ? '../images/'.$row2['photo'] : '../images/noimage.jpg';
                                    ?>
                                        <div class="product-item">
                                            <div class="pi-pic">
                                                <img src="<?php echo $image2; ?>">
                                                <ul>
                                                    <li class="w-icon active"><a href="#" class="addToCart" data-id="<?php echo $row2['id'] ?>"><i class="icon_bag_alt"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="pi-text">
                                                <a href="/product.php?id=<?php echo $row2['id'] ?>">
                                                    <h5><?php echo $row2['name'] ?></h5>
                                                </a>
                                                <div class="product-price">
                                                  रू <?php echo $row2['price'] ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                        }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }

        $pdo->close();
    ?>

    <!-- Deal Of The Week Section Begin-->
    <!-- <section class="deal-of-week set-bg spad" data-setbg="img/time-bg.jpg">
        <div class="container">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h2>Deal Of The Week</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed<br /> do ipsum dolor sit amet,
                        consectetur adipisicing elit </p>
                    <div class="product-price">
                        $35.00
                        <span>/ HanBag</span>
                    </div>
                </div>
                <div class="countdown-timer" id="countdown">
                    <div class="cd-item">
                        <span>56</span>
                        <p>Days</p>
                    </div>
                    <div class="cd-item">
                        <span>12</span>
                        <p>Hrs</p>
                    </div>
                    <div class="cd-item">
                        <span>40</span>
                        <p>Mins</p>
                    </div>
                    <div class="cd-item">
                        <span>52</span>
                        <p>Secs</p>
                    </div>
                </div>
                <a href="#" class="primary-btn">Shop Now</a>
            </div>
        </div>
    </section> -->
    <!-- Deal Of The Week Section End -->



<?php include 'includes/footer.php'; ?>
<?php include 'includes/scripts.php'; ?>
</body>
</html>