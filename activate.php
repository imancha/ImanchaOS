<?php include_once('function.inc');
  if(isset($_SESSION['id'])){
    header('Location: dashboard.php');
    exit();
  }
?>
<!DOCTYPE html>
<html class="bg-black">
  <head>
    <meta charset="UTF-8">
    <title>Account Activation | ImanchaOS</title>
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
      <div class="header">Activate Your Account</div>            
      <div class="body bg-gray">
        <?php
          $email = $_GET['x'];
          $active = $_GET['y'];

          if(isset($email, $active) && filter_var($email,FILTER_VALIDATE_EMAIL) && (strlen($active) == 32)){
            mysql_open();

            $sql = "UPDATE user SET active=NULL WHERE email='mysql_real_escape_string($email)' AND active='mysql_real_escape_string($active)' LIMIT 1";
            $res = mysql_query($sql) or die(mysql_error());

            if(mysql_affected_rows() == 1){
							$sql = "SELECT * FROM user WHERE email='mysql_real_escape_string($email)' LIMIT 1";
							$res = mysql_query($sql) or die(mysql_error());

							if(mysql_num_rows($res) == 1){
								$row = mysql_fetch_array($res);
								$pass = $row['password'];								
								$body = "Your account for ImanchaOS have been activated. \nHere's the detail of your account:\n\n";
								$body .= 'Username\t: '.$row['username'].'\nPassword\t: '.SHA1('$pass').'\nName\t: '.$row['name'].'\nCity\t: '.$row['city'].'\nEmail\t: '.$row['email'];
								mail($email, 'Registration Success', $body, 'From: ImanchaOS');
              
								echo '<div class="alert alert-success alert-dismissable margin text-center">
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
												Your account is now active. You may now <a href="login.php"><b>log in</b></a>.
											</div>';
							}else{
								echo '<div class="alert alert-danger margin text-center">
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
												Your account could not be activated. Please re-check the link or contact the system administration.
											</div>';
							}
            }else{
              echo '<div class="alert alert-danger margin text-center">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
                      Your account could not be activated. Please re-check the link or contact the system administration.
                    </div>';
            }
            mysql_close();
          }else{
            header("Location: errno.php");
            exit();
          }
        ?>                
      </div>
      <div class="footer">
        <div class="alert alert-success margin text-center">
            <a href="login.php" class="alert-link">Sign In</a>
        </div>
      </div>
    </div>    
    <!-- jQuery 2.0.2 -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <!-- jQuery UI 1.10.3 -->
    <script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js" type="text/javascript"></script>    
  </body>
</html>
