<?php include_once('function.inc');
  if(isset($_SESSION['id'])){
    header('Location: index.php');
    exit();
  }

  $title = "Registration";
  $description = "";
?>
<!DOCTYPE html>
<html class="bg-black">
  <head>
    <meta charset="UTF-8">
      <title>Registration | ImanchaOS</title>
      <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
      <meta content='<?php echo $title; ?> | ImanchaOS' name='keywords'/>
			<meta content='<?php echo $description; ?> | ImanchaOS' name='description'/>
      <!-- bootstrap 3.0.2 -->
      <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
      <!-- font Awesome -->
      <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
      <!-- Theme style -->
      <link href="css/imancha.css" rel="stylesheet" type="text/css" />
      <link href="img/imanchaos.png" rel="shortcut icon" />

      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
      <![endif]-->
  </head>
  <body class="bg-black">
    <div class="form-box" id="login-box">
      <div class="header">Register New Membership</div>
      <div class="body bg-gray">
        <?php
					ob_start();
					
          if(isset($_POST['submit'])){
						mysql_open();
						
            $name = trim($_POST['name']);
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $password2 = trim($_POST['password2']);
            $city = trim($_POST['city']);
            $email = trim($_POST['email']);                

          	//	Validate name 
            if(preg_match('/^[A-Za-z \'.-]{2,50}$/i', $name)){
              $name = mysql_real_escape_string($name);
            }else{
							$name = FALSE;
              echo '<div class="alert alert-danger alert-dismissable margin text-center">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
                      Please enter your name.
                    </div>';
            }

            // Validate username
            if(preg_match('/^\w{2,20}$/', $username)){
              $username = mysql_real_escape_string($username);
            }else{
							$username = FALSE;
              echo '<div class="alert alert-danger alert-dismissable margin text-center">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
                      Please enter a valid username.
                    </div>';
            }

            //	Validate password
            if(preg_match('/^\w{2,20}$/', $password)){
              if($password == $password2){
                $password = mysql_real_escape_string($password);
              }else{
								$password = FALSE;
                echo '<div class="alert alert-danger alert-dismissable margin text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
                        Password did not match.
                        </div>';
              }
            }else{
							$password = FALSE;
              echo '<div class="alert alert-danger alert-dismissable margin text-center">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
                      Please enter a valid password.
                    </div>';
            }
            
            if(!empty($city)){
							$city = mysql_real_escape_string($city);
						}else{
							$city = FALSE;
              echo '<div class="alert alert-danger alert-dismissable margin text-center">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
                      Please fill your city.
                    </div>';
						}

            //	Validate email
            if(filter_var($email,FILTER_VALIDATE_EMAIL)){
              $email = mysql_real_escape_string($email);
            }else{
							$email = FALSE;
              echo '<div class="alert alert-danger alert-dismissable margin text-center">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
                      Please enter a valid email address.
                    </div>';
            }                                        

            if($name && $username && $password && $city && $email){
              $sql = "SELECT * FROM user WHERE username='$username'";
              $res = mysql_query($sql) or die(mysql_error());
              $sql1 = "SELECT * FROM user WHERE email='$email'";
              $res1 = mysql_query($sql1) or die(mysql_error());

              if((mysql_num_rows($res) == 0) && (mysql_num_rows($res1) == 0)){
                $activate = md5(uniqid(rand(), true));

                $sql = "INSERT INTO user VALUES (NULL,'$username',SHA1('$password'),'$name','$city','$email',NOW(),'$activate')";
                $res = mysql_query($sql) or die(mysql_error());

                if(mysql_affected_rows() == 1){
                  $body = "Thank you for registering at ImanchaOS. \nTo activate your account, please click on this link:\n\n";
                  $body .= 'http://imanchaos.com/activate.php?x='. urlencode($email) . "&y=$activate";
                  mail($email, 'Registration Confirmation', $body, 'From: me@imanchaos.com');
                  
                  echo '<div class="alert alert-info alert-dismissable margin text-center">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
                          Thank you for registering! A confirmation registration has been sent to your email address. 
                          Please click on the link in that email in order to activate your account.
                        </div>
                      </div>
                      <div class="footer">
												<a href="index.php">Return to forum index</a>
											</div></div></body></html>';
                      exit();
                }else{
                  echo '<div class="alert alert-danger alert-dismissable margin text-center">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
                          Could not be registered. Please try again.
                        </div>';
                }
              }else{
                if(mysql_num_rows($res) > 0){
                  echo '<div class="alert alert-danger alert-dismissable margin text-center">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
                          Username already used.
                        </div>';
                }
                if(mysql_num_rows($res1) > 0){
                  echo '<div class="alert alert-danger alert-dismissable margin text-center">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
                          That email address has already been registered.
                        </div>';
                }
              }
            }                            
            mysql_close();
          }
          ob_flush();
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">                
          <div class="form-group">
              <input type="text" name="name" class="form-control" placeholder="Full name" value="<?php if(isset($_POST['name'])) echo trim($_POST['name']); ?>" required/>
          </div>
          <div class="form-group">
              <input type="text" name="username" class="form-control" placeholder="Username" value="<?php if(isset($_POST['username'])) echo htmlentities($_POST['username']); ?>" required/>
          </div>
          <div class="form-group">
              <input type="password" name="password" class="form-control" placeholder="Password" value="<?php if(isset($_POST['password'])) echo htmlentities($_POST['password']); ?>" required/>
          </div>
          <div class="form-group">
              <input type="password" name="password2" class="form-control" placeholder="Retype password" value="<?php if(isset($_POST['password2'])) echo htmlentities($_POST['password2']); ?>" required/>
          </div>
          <div class="form-group">
             <input type="text" name="city" class="form-control" placeholder="City" value="<?php if(isset($_POST['city'])) echo htmlentities($_POST['city']); ?>" required/>
          </div> 
          <div class="form-group">
              <input type="text" name="email" class="form-control" placeholder="Email address" value="<?php if(isset($_POST['email'])) echo htmlentities($_POST['email']); ?>" required/>
          </div>          
        </div>
          <div class="footer">                    
              <button type="submit" name="submit" class="btn bg-olive btn-block">Sign me up</button>
              <p><a href="login.php" class="text-center">I already have a membership</a></p>
              <a href="index.php">Return to forum index</a>
          </div>
        </form>      

<!--      <div class="margin text-center">
          <span>Register using social networks</span>
          <br/>
          <button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
          <button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
          <button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>
      </div>                
-->
    </div>
    <!-- jQuery 2.0.2 -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
      <!-- jQuery UI 1.10.3 -->
    <script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js" type="text/javascript"></script>    
  </body>
</html>
