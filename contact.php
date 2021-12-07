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

    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="/"><i class="fa fa-home"></i> Home</a>
                        <span>FAQs</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section Begin -->
    <div class="map spad">
        <div class="container">
            <div class="map-inner">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d3532.203445821316!2d85.41565351340226!3d27.711004119955973!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2snp!4v1616099927461!5m2!1sen!2snp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                
            </div>
        </div>
    </div>
    <!-- Map Section Begin -->

    <!-- Contact Section Begin -->
    <section class="contact-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="contact-title">
                        <h4>Contacts Us</h4>
                        
                    </div>
                    <div class="contact-widget">
                        <div class="cw-item">
                            <div class="ci-icon">
                                <i class="ti-location-pin"></i>
                            </div>
                            <div class="ci-text">
                                <span>Address:</span>
                                <p>NEC, Bhaktapur, Changunarayan</p>
                            </div>
                        </div>
                        <div class="cw-item">
                            <div class="ci-icon">
                                <i class="ti-mobile"></i>
                            </div>
                            <div class="ci-text">
                                <span>Phone:</span>
                                <p>+977 9801234567</p>
                            </div>
                        </div>
                        <div class="cw-item">
                            <div class="ci-icon">
                                <i class="ti-email"></i>
                            </div>
                            <div class="ci-text">
                                <span>Email:</span>
                                <p>geniestore18@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

<?php include 'includes/footer.php'; ?>
<?php include 'includes/scripts.php'; ?>
</body>
</html>
