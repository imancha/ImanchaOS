<?php include_once('function.inc');
	$error = FALSE;
	$user = (int) $_GET['user'];
	
	mysql_open();

	if(isset($_POST['upload'])){
		if (!empty($_FILES["uploadedimage"]["name"])) {
			$file_name = $_FILES["uploadedimage"]["name"];
			$temp_name = $_FILES["uploadedimage"]["tmp_name"];
			$imgtype = $_FILES["uploadedimage"]["type"];
			$ext = GetImageExtension($imgtype);
			$imagename = $_SESSION['username'].$ext;
			$target_path = "img/user/".$imagename;

			if(move_uploaded_file($temp_name, $target_path)) {
				$sql = "UPDATE user SET avatar='$target_path' WHERE id='".$_SESSION['id']."' LIMIT 1";
				$res = mysql_query($sql) or die(mysql_error());

				if($res){
					$avatar = "<div class='alert alert-success alert-dismissable'>
												<i class='fa fa-check'></i>
												<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times</button>
												Avatar have been changed.
											</div>";
				}else{
					$avatar = "<div class='alert alert-warning alert-dismissable'>
												<i class='fa fa-warning'></i>
												<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times</button>
												Error while uploading image on the server. Please try again.
											</div>";
				}					
			}else{
				 exit("Error While uploading image on the server");
			}
		}
	}
	
	if(is_numeric($user) && $user > 0){
		$sql = "SELECT * FROM user WHERE id='$user' LIMIT 1";						
	}else{
		$sql = "SELECT * FROM user WHERE id='".$_SESSION['id']."' LIMIT 1";
	}
	
	$res = mysql_query($sql) or die(mysql_error());
	
	if(mysql_num_rows($res) == 1){
		$row = mysql_fetch_array($res);

		$name = $row['name'];
		
		$sql0 = "SELECT * FROM topic WHERE creator_topic='".$row['1']."'";
		$res0 = mysql_query($sql0) or die(mysql_error());
		$row0 = mysql_num_rows($res0);
		$sql1 = "SELECT * FROM follow WHERE user='".$row['0']."'";
		$res1 = mysql_query($sql1) or die(mysql_error());
		$row1 = mysql_num_rows($res1);
		$sql2 = "SELECT * FROM follow WHERE follower='".$row['0']."'";
		$res2 = mysql_query($sql2) or die(mysql_error());
		$row2 = mysql_num_rows($res2);

		if($_SESSION['id'] == $row['id']){
			$form = '<form action="" enctype="multipart/form-data" method="post">
								<div class="col-md-9 no-padding">												
									<input style="display:none" id="file-type" type="file" size="4" name="uploadedimage" />
									<input id="browse-click" type="button" class="btn btn-info btn-sm btn-block btn-flat" value="Change Avatar" title="Browse" />
								</div>
								<div class="col-md-3 no-padding">
									<button type="submit" name="upload" class="btn btn-info btn-sm btn-block btn-flat" title="Upload"><i class="fa fa-check"></i></button>
								</div>
							</form>';
		}
		
		$content .= '<div class="row">									
									<div class="col-md-12">
										<div class="col-md-2">											
											<img src="'.$row['avatar'].'" class="thumbnail" alt="user image" width="100%" style="padding-bottom:10px" />
											'.$form.'									
										</div>
										<div class="col-md-10">
											<table cellpadding="5em">
												<tr><td><i class="fa fa-caret-right"></i></td><td>ID Member</td><td>:</td><td>'.$row['0'].'</td></tr>
												<tr><td><i class="fa fa-caret-right"></i></td><td>Username</td><td>:</td><td>'.$row['1'].'</td></tr>													
												<tr><td><i class="fa fa-caret-right"></i></td><td>Name</td><td>:</td><td>'.$row['3'].'</td></tr>
												<tr><td><i class="fa fa-caret-right"></i></td><td>City</td><td>:</td><td>'.$row['4'].'</td></tr>
												<tr><td><i class="fa fa-caret-right"></i></td><td>Email</td><td>:</td><td>'.$row['5'].'</td></tr>
												<tr><td><i class="fa fa-caret-right"></i></td><td>Join Date</td><td>:</td><td>'.Tanggal($row['6']).'</td></tr>
												<tr><td><i class="fa fa-caret-right"></i></td><td>Posts</td><td>:</td><td>'.$row0.'</td></tr>
												<tr><td><i class="fa fa-caret-right"></i></td><td>Following</td><td>:</td><td>'.$row2.'</td></tr>
												<tr><td><i class="fa fa-caret-right"></i></td><td>Followers</td><td>:</td><td>'.$row1.'</td></tr>
											</table>
										</div>										
									</div>
								</div>';
		
	}else{
		$error = TRUE;
	}
	
	mysql_close();
	
	if($error){
		header('Location: error.php');
		exit();
	}
	
  $title        = "Profile";
  $description  = "Customize Your Profile";  
?>
<!DOCTYPE html>
<html>
  <head>
	<meta charset="UTF-8">
	<title><?php echo $title ?> | ImanchaOS</title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<meta content='<?php echo $title; ?> | ImanchaOS' name='keywords'/>
	<meta content='<?php echo $description; ?> ImanchaOS' name='description'/>
	<!-- bootstrap 3.0.2 -->
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- font Awesome -->
	<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<!-- Ionicons -->
	<link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />	
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
  <body class="skin-blue">
    <header class="header"><?php navigation(); ?></header>    
    <div class="wrapper row-offcanvas row-offcanvas-left">
      <aside class="left-side sidebar-offcanvas"><?php sidebar(); ?></aside>
      <!-- Right side column. Contains the navbar and content of the page -->
      <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">                    
          <?php echo '<h1>'.$title.' <small>'.$description.'</small></h1>'; ?>
          <ol class="breadcrumb">
						<li><a href="index.php"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active"><?php echo $title ?></li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
					<?php echo $avatar; ?>
					<div class="box box-solid box-danger">
						<div class="box-header">
							<h3 class="box-title"><i class="fa fa-globe"></i> <?php echo $name; ?></h3>
							<div class="box-tools pull-right"><span class="time"><?php echo date("D, d-M-Y h:i A"); ?></span></div>
						</div>
						<div class="box-body"><?php echo $content; ?></div>
					</div>										
        </section><!-- /.content -->
      </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->    
    <!-- jQuery 2.0.2 -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
      <!-- jQuery UI 1.10.3 -->
    <script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js" type="text/javascript"></script>    
    <!-- Imancha-OS App -->
    <script src="js/imancha/app.js" type="text/javascript"></script>
    <script>
    $(window).load(function () {
			var intervalFunc = function () {
					$('#file-name').html($('#file-type').val());
			};
			$('#browse-click').on('click', function () { // use .live() for older versions of jQuery
					$('#file-type').click();
					setInterval(intervalFunc, 1);
					return false;
			});
		});
    </script>
  </body>
</html>
<?php ob_flush(); ?>
