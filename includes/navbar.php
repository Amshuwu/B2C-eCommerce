
<!-- Header Section Begin -->
<header class="header-section">
  <div class="header-top">
    <div class="container">
      <div class="ht-left">
        <div class="mail-service">
          <i class=" fa fa-envelope"></i>
          geniestore18@gmail.com
        </div>
        <?php
        	if(isset($_SESSION['admin'])){
            echo'
            <a href="/admin/home.php" class="phone-service">
              <i class=" fa fa-user"></i>
              Administration
            </a>
            ';
          }
        ?>
        <div class="phone-service">
          <i class=" fa fa-phone"></i>
          +977 9801234567
        </div>
      </div>
      <div class="ht-right">
        <?php
        if (!isset($_SESSION['user'])) {
          echo '<a href="/login.php" class="login-panel"><i class="fa fa-user"></i>Login</a>';
        }
        else{
          echo '<a href="#" class="login-panel"><i class="fa fa-user"></i>'.$user['firstname']." ".$user['lastname'];
            if(is_null($user['numberoforders'])){
                //do nothing
            }
            else{
              if($user['numberoforders'] >= 500){
                echo " (Platinum)";
              }
                else if($user['numberoforders'] >= 100){
                    echo " (Gold)";
                }
                else if($user['numberoforders'] >= 50){
                    echo " (Silver)";//instad of text, you can show image badge logo here yay
                }
            }
            echo "</a>";
            echo '<a href="/logout.php" class="login-panel"><i class="fa fa-cog"></i>Logout</a>';
        }
        ?>
        
        <div class="top-social">
          <a href="https://facebook.com/geniestore"><i class="ti-facebook"></i></a>
          <a href="https://twitter.com/geniestore"><i class="ti-twitter-alt"></i></a>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="inner-header">
      <div class="row">
        <div class="col-lg-2 col-md-2">
          <div class="logo">
            <a href="/">
              <img src="images/logo-b.png" alt="">
            </a>
          </div>
        </div>
        <div class="col-lg-7 col-md-7">
          <div class="advanced-search">
            <button type="button" class="category-btn" style="visibility: hidden;">All Categories</button>
            <form class="input-group" action="/shop.php">
              <input type="text" name="query" placeholder="What do you need?">
              <button type="submit"><i class="ti-search"></i></button>
            </form>
          </div>
        </div>
        <div class="col-lg-3 text-right col-md-3">
          <ul class="nav-right">
            <li class="cart-icon" id="cartFetch">
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="nav-item">
    <div class="container">
      <div class="nav-depart">
        <div class="depart-btn">
          <i class="ti-menu"></i>
          <span>All categories</span>
          <ul class="depart-hover">
          <?php
	  			$conn = $pdo->open();

	  			$stmt = $conn->prepare("SELECT * FROM category");
	  			$stmt->execute();
	  			foreach($stmt as $row){
            echo "<li class='active'><a href='/category.php?id=".$row['id']."'>".$row['name']."</a></li>";
	  			}

	  			$pdo->close();
	  		?>
          </ul>
        </div>
      </div>
      <nav class="nav-menu mobile-menu">
        <ul>
          <li class="active"><a href="/">Home</a></li>
          <li><a href="/shop.php">Shop</a></li>
          <li><a href="/contact.php">Contact</a></li>
          <li><a href="javascript:void(0);">Pages</a>
            <ul class="dropdown">
              <li><a href="/cart.php">Shopping Cart</a></li>
              <li><a href="/faq.php">Faq</a></li>
              <li><a href="/register.php">Register</a></li>
              <li><a href="/login.php">Login</a></li>
            </ul>
          </li>
        </ul>
      </nav>
      <div id="mobile-menu-wrap"></div>
    </div>
  </div>
</header>
<!-- Header End -->
