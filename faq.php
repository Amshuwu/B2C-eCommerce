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
    <!-- Breadcrumb Section Begin -->
    <!-- Faq Section Begin -->
    <div class="faq-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="faq-accordin">
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-heading active">
                                    <a class="active" data-toggle="collapse" data-target="#collapseOne">
                                        What payment are allowed
                                    </a>
                                </div>
                                <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <p>Currently we only have esewa and cash on delivery features. We wlil soon expand to credit card and khalti and paypal.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseTwo">
                                        What items are available to buy
                                    </a>
                                </div>
                                <div id="collapseTwo" class="collapse" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <p>You can buy any clothes and accessories with us.</p>
                                    </div>
                                </div>
                              </div>
                            <div class="card">
                         <div class="card-heading">
                      <a data-toggle="collapse" data-target="#collapseThree">
                               Is VAT charged?
                            </a>
                          </div>
                            <div id="collapseThree" class="collapse" data-parent="#accordionExample">
                                <div class="card-body">
                                <p>If you have VAT number, then VAT is not charged. You need to remember to add the VAT number to your account information section. Online checkout system will automatically fill in the submitted VAT number when you order products.You can also add your VAT number during the checkout process manually. </p>
                                    </div>
                                    </div>
                                    </div>
                               <div class="card">
                               <div class="card-heading">
                            <a data-toggle="collapse" data-target="#collapseFour">
                                What should be done if the payment is not accepted?
                                  </a>
                                </div>
                   <div id="collapseFour" class="collapse" data-parent="#accordionExample">
                        <div class="card-body">
                       <p> Please try again in a little while. If the payment is still not accepted, please verify your account balance. If everything is as it should, but you still cant make the payment, please contact and notify us about the problem. We can manage the order manually. </p>
                              </div>
                              </div>
                              </div>
                    <div class="card">
                   <div class="card-heading">
                  <a data-toggle="collapse" data-target="#collapseFive">
                   Why should I buy online?
                     </a>
                    </div>
                      <div id="collapseFive" class="collapse" data-parent="#accordionExample">
                      <div class="card-body">
                 <p>Speeding up the process. By ordering online you will you will get prices faster and you will be able to go through order confirmation and payment process much faster. This could save days of your time. Traceability: You will have easy access to all of your previous orders any time you want.Reordering:  you can make a re-order anytime based on your previous orders by only couple of clicks. This will save time and effort as you don’t need to go through all the documents and emails from the past. </p>
                     </div>
                     </div>
                     </div>

                      <div class="card">
                      <div class="card-heading">
                      <a data-toggle="collapse" data-target="#collapseSix">
                        How can I order?
                         </a>
                         </div>
                      <div id="collapseSix" class="collapse" data-parent="#accordionExample">
                           <div class="card-body">
                          <p>IYou can order easily using our online platform. When you find a product you need, you can add it to cart, login and go through the ordering process. After the order is ready, you will receive order summary to your email. Order summary will also be stored to your account.You can also easily make reorders afterwards by clicking the “reorder” button on any of your previously made orders. After clicking the “reorder” button the cart will open and you can change quantities or products.
                            </p>
                               </div>
                              </div>
                             </div>
                            <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseSeven">
                                        What is the return policy
                                    </a>
                                </div>
                                <div id="collapseSeven" class="collapse" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <p>You can return any item to us within 1 week of purchase.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Faq Section End -->


<?php include 'includes/footer.php'; ?>
<?php include 'includes/scripts.php'; ?>
</body>
</html>
