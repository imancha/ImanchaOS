<?php include_once('function.inc');
  if(isset($_SESSION['id'])){
    header('Location: index.php');
    exit();
  }
  
  $title = "Reset Password";
?>
<!DOCTYPE html>
<html class="bg-black">
  <head>
      <meta charset="UTF-8">
      <title><?php echo $title; ?> | ImanchaOS</title>
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
      <div class="header">Reset Your Password</div>            
      <div class="body bg-gray"><br>
        <?php
					ob_start();
          if(isset($_POST['submit'])){
            mysql_open();

						$username = trim($_POST['username']);
            $email = trim($_POST['email']);

            $sql = "SELECT * FROM user WHERE username='$username' AND email='$email' AND active is NULL LIMIT 1";
            $res =  mysql_query($sql) or die(mysql_error());

            if(mysql_num_rows($res) == 1){
              $row = mysql_fetch_assoc($res);
              $id = $row['id'];

              $password = substr(md5(uniqid(rand(), true)), 3, 10);

              $sql = "UPDATE user SET password=SHA1('$password') WHERE id='$id' LIMIT 1";
              $res = mysql_query($sql) or die(mysql_error());

              if(mysql_affected_rows() == 1){
                $body = "Your account password to login into ImanchaOS has been temporarily changed to '$password'. \nPlease log in using this password and this email address. Then you may change your password to something more familiar.";
                mail($email, 'Your Temporary Password.', $body, 'From: me@imanchaos.com');

                echo '<div class="alert alert-success margin text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
                        Your password has been changed. You will receive the new, temporarily password at the email address with which you registered. Once you have logged in with the password, you may change it to something more familiar.
                      </div>
                      </div></div></body></html>';
                
                exit();
              }else{
								header('Location: errno.php');
								exit();
							}
            }else{
              echo '<div class="alert alert-danger alert-dismissable margin text-center">
              			<i class="fa fa-warning"></i>
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
                      Username and Email address does not match.
                    </div><br>';
            }
            mysql_close();
          }
          ob_flush();
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">                    
          <div class="form-group">
            <input type="text" name="username" class="form-control" placeholder="Username" required/>
          </div>
          <div class="form-group">
            <input type="text" name="email" class="form-control" placeholder="Email address" required/>
          </div>
      </div>
          <div class="footer">
            <button type="submit" name="submit" class="btn bg-olive btn-block">Reset</button>                                    
            <p><a href="login.php" class="text-center">Return to login form</a></p>
            <a href="index.php">Return to forum index</a>
          </div>
        </form>            
    </div>
    <!-- jQuery 2.0.2 -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js" type="text/javascript"></script>        
  </body>
</html>
