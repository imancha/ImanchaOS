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
    <title>Sign In | ImanchaOS</title>
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
      <div class="header">Sign In</div>            
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="body bg-gray"><br>                
        <?php
					ob_start();
          if(isset($_POST['submit'])){                            
            mysql_open();
            //	Validate username
            if(!empty($_POST['username'])){
              $username = mysql_real_escape_string(trim($_POST['username']));
            }else{
              $username = FALSE;
              echo '<div class="alert alert-warning alert-dismissable">                                    
                      <i class="fa fa-warning"></i>
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
                      You forgot to enter your <b>username</b>.
                    </div>';
            }
                
            //	Validate password
            if(!empty($_POST['password'])){
              $password = mysql_real_escape_string(trim($_POST['password']));
            }else{
              $password = FALSE;
              echo '<div class="alert alert-warning alert-dismissable">                                    
                      <i class="fa fa-warning"></i>
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
                      You forgot to enter your <b>password</b>.
                    </div>';
            }
                
            if($username && $password){                            
              $sql = "SELECT * FROM user WHERE ((username='$username' || email='$username') AND password=SHA1('$password')) AND active is NULL LIMIT 1";
              $res = mysql_query($sql) or die(mysql_error());
                
              if(mysql_num_rows($res) == 1){
                $row = mysql_fetch_assoc($res);
                $_SESSION['id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['email'] = $row['email'];                            
                $_SESSION['date'] = $row['date'];
                                
                header("Location: dashboard.php");
                exit();
              }else{
                echo '<br/>
                      <div class="alert alert-warning alert-dismissable">                                    
                        <i class="fa fa-warning"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
                        <b>Username</b> and <b>Password</b> did not match. Please try again.
                      </div>';
              }
            }
            mysql_close();
            ob_flush();
          }
        ?>                
          <div class="form-group">
            <input type="text" name="username" class="form-control" placeholder="Username or Email" value="<?php if(isset($_POST['username'])) echo htmlentities($_POST['username']); ?>"/>
          </div>
          <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password" value="<?php if(isset($_POST['password'])) echo htmlentities($_POST['password']); ?>"/>
          </div>          
          <div class="form-group">
            <input type="checkbox" name="remember" <?php if(isset($_POST['remember'])) echo 'checked'; ?> /> Remember me
          </div>
        </div>
        <div class="footer">                                                               
          <button type="submit" name="submit" class="btn bg-olive btn-block">Sign in</button>
          <p><a href="reset.php">I forgot my password</a></p>                        
          <p><a href="register.php" class="text-center">Register a new membership</a></p>
          <a href="index.php">Return to forum index</a>
        </div>
      </form>            

<!--  <div class="margin text-center">
        <span>Sign in using social networks</span>
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
