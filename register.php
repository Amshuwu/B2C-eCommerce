<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'libraries/phpmailer/phpmailer/src/Exception.php';
	require 'libraries/phpmailer/phpmailer/src/PHPMailer.php';
	require 'libraries/phpmailer/phpmailer/src/SMTP.php';

	include 'includes/session.php';

	if(isset($_POST['signup'])){
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$repassword = $_POST['repassword'];

		$_SESSION['firstname'] = $firstname;
		$_SESSION['lastname'] = $lastname;
		$_SESSION['email'] = $email;


		if($password != $repassword){
			$_SESSION['error'] = 'Passwords did not match';
		}
		else{
			$conn = $pdo->open();

			$stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM users WHERE email=:email");
			$stmt->execute(['email'=>$email]);
			$row = $stmt->fetch();
			if($row['numrows'] > 0){
				$_SESSION['error'] = 'Email already taken';
			}
			else{
				$now = date('Y-m-d');
				$password = password_hash($password, PASSWORD_DEFAULT);

				//generate code
				$set='123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$code=substr(str_shuffle($set), 0, 12);

				try{
					$stmt = $conn->prepare("INSERT INTO users (email, password, firstname, lastname, activate_code, created_on) VALUES (:email, :password, :firstname, :lastname, :code, :now)");
					$stmt->execute(['email'=>$email, 'password'=>$password, 'firstname'=>$firstname, 'lastname'=>$lastname, 'code'=>$code, 'now'=>$now]);
					$userid = $conn->lastInsertId();

					$message = "
						<h2>Thank you for Registering.</h2>
						<p>Your Account:</p>
						<p>Email: ".$email."</p>
						<p>Password: ".$_POST['password']."</p>
						<p>Please click the link below to activate your account.</p>
						<a href='http://127.0.0.1/activate.php?code=".$code."&user=".$userid."'>Activate Account</a>
					";


		    		$mail = new PHPMailer();                             
				    try {
				        //Server settings
				        $mail->IsSMTP();
						$mail->Mailer = "smtp";
						$mail->SMTPDebug  = 1;  
						$mail->SMTPAuth   = TRUE;
						$mail->SMTPSecure = "tls";
						$mail->Port       = 587;
						$mail->Host       = "smtp.gmail.com";
						$mail->Username   = "geniestore18@gmail.com";
						$mail->Password   = "genie1998";

						$mail->IsHTML(true);
						$mail->AddAddress($email, $firstname." ".$lastname);
						$mail->SetFrom("geniestore18@gmail.com", "Genie Store");
						$mail->AddReplyTo("geniestore18@gmail.com", "Genie Store");
						$mail->Subject = "Activate your account";

				        //Content
				        $mail->isHTML(true);                                  
				        $mail->Subject = 'Geniestore signup';
				        $mail->Body    = $message;

				        if(!$mail->send()){
							var_dump($mail);
						}
						
				        unset($_SESSION['firstname']);
				        unset($_SESSION['lastname']);
				        unset($_SESSION['email']);

				        $_SESSION['success'] = 'Account created. Check your email to activate.';
				        header('location: index.php');

				    } 
				    catch (Exception $e) {
				        $_SESSION['error'] = 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
				    }


				}
				catch(PDOException $e){
					$_SESSION['error'] = $e->getMessage();
				}

				$pdo->close();

			}

		}

	}

?>
<?php
  if(isset($_SESSION['user'])){
    header('location: index.php');
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
                <div class="breadcrumb-text">
                    <a href="/"><i class="fa fa-home"></i> Home</a>
                    <span>Register</span>
                </div>
            </div>
        </div>
    </div>
</div>

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

    <!-- Register Section Begin -->
    <div class="register-login-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="login-form">
                        <h2>Register</h2>
                        <form action="register.php" method="post">
                            <div class="group-input">
                                <label for="firstname">First Name *</label>
                                <input type="text" id="firstname" name="firstname" required>
                            </div>
                            <div class="group-input">
                                <label for="lastname">Last Name *</label>
                                <input type="text" id="lastname" name="lastname" required> 
                            </div>
                            <div class="group-input">
                                <label for="email">Email address *</label>
                                <input type="text" id="email" name="email" required>
                            </div>
                            <div class="group-input">
                                <label for="password">Password *</label>
                                <input type="password" id="password" name="password" required>
                            </div>
                            <div class="group-input">
                                <label for="repassword">Confirm Password *</label>
                                <input type="password" id="repassword" name="repassword" required>
                            </div>
                            <input type="submit" class="site-btn login-btn" name="signup" value="Sign Up" />
                        </form>
                        <div class="switch-login">
                            <a href="/register.php" class="or-login">Or Create An Account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Form Section End -->

<?php include 'includes/footer.php'; ?>
<?php include 'includes/scripts.php'; ?>
</body>
</html>
