<?php include 'includes/session.php'; ?>
<?php
	$conn = $pdo->open();

	$id = $_GET['id'];

	try{
		$total_rating = 0;
        $stmt = $conn->prepare("SELECT COUNT(*) as numrow from reviews inner join users on reviews.userid=users.id where reviews.productid = :id");
        $stmt->execute(['id' => $id]);
        $res = $stmt->fetch();
        $number_of_rows = $res["numrow"];

	    $stmt = $conn->prepare("SELECT *, products.name AS prodname, category.name AS catname, products.id AS prodid, category.id AS catid FROM products LEFT JOIN category ON category.id=products.category_id WHERE products.id = :id");
	    $stmt->execute(['id' => $id]);
	    $product = $stmt->fetch();
		
	}
	catch(PDOException $e){
		echo "There is some problem in connection: " . $e->getMessage();
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
                        <a href="/"><i class="fa fa-home"></i> Home</a>
                        <a href="/shop.php">Shop</a>
                        <span>Detail</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->


    <!-- Product Shop Section Begin -->
    <section class="product-shop spad page-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="product-pic-zoom">
                                <img class="product-big-img" src="<?php echo (!empty($product['photo'])) ? 'images/'.$product['photo'] : 'images/noimage.jpg'; ?>" alt="">
                                <div class="zoom-icon">
                                    <i class="fa fa-search-plus"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="product-details">
                                <div class="pd-title">
                                    <span><?php echo $product['catname'] ?></span>
                                    <h3><?php echo $product['prodname'] ?></h3>
                                    <input type="hidden" value="<?php echo $product['prodid']; ?>" id="productId">
                                </div>
                                <div class="pd-rating" id="ratingProduct">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <span>(5)</span>
                                </div>
                                <div class="pd-desc">
                                <?php echo $product['description'] ?>
                                    <h4>रू <?php echo number_format($product['price'], 2); ?> </h4>
                                </div>
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" id="quantity" value="1">
                                    </div>
                                    <a href="#" class="primary-btn pd-cart" id="addToCartButton">Add To Cart</a>
                                </div>
                                <ul class="pd-tags">
                                    <li><span>Stock Quantity</span>: <?php echo $product['stock'] ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="product-tab">
                        <div class="tab-item">
                            <ul class="nav" role="tablist">
                                <li>
                                    <a class="active" data-toggle="tab" href="#tab-1" role="tab">Customer Reviews (<?php echo $number_of_rows; ?>)</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab-2" role="tab">SPECIFICATIONS</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab-3" role="tab">Description</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-item-content">
                            <div class="tab-content">
                                <div class="tab-pane fade-in active" id="tab-1" role="tabpanel">
                                    <div class="customer-review-option">
                                        <?php 

                                           $stmt = $conn->prepare("SELECT * from reviews inner join users on reviews.userid=users.id where reviews.productid = :id");
                                           $stmt->execute(['id' => $id]);
                                        ?>
                                        <h4><?php echo $number_of_rows; ?> Comments</h4>
                                        <div class="comment-option">
                                            <?php
                                                foreach($stmt as $row){
                                                    $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/profile.jpg';
                                            ?>
                                                <div class="co-item">
                                                    <div class="avatar-pic">
                                                        <img src="<?php echo $image; ?>" alt="">
                                                    </div>
                                                    <div class="avatar-text">
                                                        <div class="at-rating">
                                                            <?php 
                                                                $total_rating += $row['rating'];
                                                                for($i=0; $i<$row['rating']; $i++){
                                                                    echo '<i class="fa fa-star"></i>';
                                                                }
                                                                for($i=0; $i<5-$row['rating']; $i++){
                                                                    echo '<i class="fa fa-star-o"></i>';
                                                                }
                                                            ?>
                                                        </div>
                                                        <h5><?php echo $row['firstname'].' '.$row['lastname']; ?> <span><?php echo $row['date']; ?></span></h5>
                                                        <div class="at-reply"><?php echo $row['review']; ?></div>
                                                    </div>
                                                </div>
                                            <?php
                                                }
                                                $pdo->close();
                                            ?>
                                        </div>
                                        <div class="leave-comment">
                                                <?php 
                                                    if(!isset($_SESSION['user'])){
                                                        echo '<h4>Login to leave a comment</h4>';
                                                    }
                                                    else{
                                                ?>
                                            <h4>Leave A Comment</h4>
                                            <form action="add_review.php" method="post" class="comment-form">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <select name="rating">
                                                            <option value="0">Select a rating</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                        </select>
                                                    </div>
                                                    <input type="hidden" value="<?php echo $product['prodid']; ?>" name="productId">
                                                    <div class="col-lg-12">
                                                        <textarea name="message" placeholder="Messages"></textarea>
                                                        <button type="submit" class="site-btn">Send message</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <?php 
                                                    }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-2" role="tabpanel">
                                    <div class="specification-table">
                                        <table>
                                            <tr>
                                                <td class="p-catagory">Customer Rating</td>
                                                <td>
                                                    <div class="pd-rating" id="ratingProduct2">
                                                    <?php 
                                                        if($number_of_rows > 0){
                                                            $total_rating = floor($total_rating/$number_of_rows);
                                                        }
                                                        for($i=0; $i<$total_rating; $i++){
                                                            echo '<i class="fa fa-star"></i>';
                                                        }
                                                        for($i=0; $i<5-$total_rating; $i++){
                                                            echo '<i class="fa fa-star-o"></i>';
                                                        }
                                                    ?>
                                                        <span>(<?php echo $number_of_rows; ?>)</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Price</td>
                                                <td>
                                                    <div class="p-price">रू <?php echo number_format($product['price'], 2); ?></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Availability</td>
                                                <td>
                                                <?php 
                                                    if($product['stock'] > 0){
                                                        echo '<div class="p-stock">'.$product['stock'].' in stock</div>';
                                                    }
                                                    else{
                                                        echo '<div class="p-stock">Out of stock</div>';
                                                    }
                                                ?>
                                                    
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-3" role="tabpanel">
                                    <div class="product-content">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <?php echo $product['description'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Shop Section End -->


<?php include 'includes/footer.php'; ?>
<?php include 'includes/scripts.php'; ?>
<script>
document.getElementById("ratingProduct").innerHTML = document.getElementById("ratingProduct2").innerHTML;
$("#addToCartButton").on('click', function(e){
    e.preventDefault();
    let id = $("#productId").val();
    let qty = $("#quantity").val();
    let param = {id: id, quantity: qty};
    console.log(param);
    $.ajax({
        url: '/cart_add.php',
        data: param,
        method: "POST",
        success: function(response){
            response = JSON.parse(response);
            if(!response.error){
                $.toast({
                    heading: 'Success',
                    text: response.message,
                    showHideTransition: 'slide',
                    icon: 'success'
                });
            }
            else{
                $.toast({
                    heading: 'Error',
                    text: response.message,
                    showHideTransition: 'slide',
                    icon: 'error'
                })
            }
            getCartFetch();
        },
        error: function(err){
            $.toast({
                heading: 'Error',
                text: "unknown error",
                showHideTransition: 'slide',
                icon: 'error'
            })
        }
    });
});
$(function(){
	$('#add').click(function(e){
		e.preventDefault();
		var quantity = $('#quantity').val();
		quantity++;
		$('#quantity').val(quantity);
	});
	$('#minus').click(function(e){
		e.preventDefault();
		var quantity = $('#quantity').val();
		if(quantity > 1){
			quantity--;
		}
		$('#quantity').val(quantity);
	});

});
</script>
</body>
</html>