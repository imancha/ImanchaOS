<?php include_once('function.inc');
	mysql_open();
	
	$sql = "SELECT * FROM topic";
	$res = mysql_query($sql) or die(mysql_error());
	$topic = mysql_num_rows($res);
	$sql = "SELECT * FROM user";
	$res = mysql_query($sql) or die(mysql_error());
	$user = mysql_num_rows($res);
	$sql = "SELECT DISTINCT(server) FROM site";
	$res = mysql_query($sql) or die(mysql_error());
	$site = mysql_num_rows($res);
	
	mysql_close();
  $title        = "Home";
  $description  = "";  
?>
<!DOCTYPE html>
<html>
  <head>
	<meta charset="UTF-8">
	<title><?php echo $title ?> | Imancha-OS</title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<!-- bootstrap 3.0.2 -->
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- font Awesome -->
	<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<!-- Ionicons -->
	<link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />	
	<!-- Theme style -->
	<link href="css/imancha.css" rel="stylesheet" type="text/css" />

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
            <li><a href="index.php"><i class="fa fa-dashboard"></i><?php echo $title ?></a></li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">             
					<div class="row">
						<div class="col-lg-4 col-xs-6">
							<!-- small box -->
							<div class="small-box bg-green">
								<div class="inner">
									<h3><?php echo $topic; ?></h3>
									<p>Topic Created</p>
								</div>
								<div class="icon">
									<i class="ion ion-stats-bars"></i>
								</div>
								<a href="#" class="small-box-footer">
									More info <i class="fa fa-arrow-circle-right"></i>
								</a>
							</div>
						</div><!-- ./col -->
						<div class="col-lg-4 col-xs-6">
							<!-- small box -->
							<div class="small-box bg-yellow">
								<div class="inner">
									<h3><?php echo $user; ?></h3>
									<p>User Registrations</p>
								</div>
								<div class="icon">
									<i class="ion ion-person-add"></i>
								</div>
								<a href="#" class="small-box-footer">
									More info <i class="fa fa-arrow-circle-right"></i>
								</a>
							</div>
						</div><!-- ./col -->
						<div class="col-lg-4 col-xs-6">
							<!-- small box -->
							<div class="small-box bg-red">
								<div class="inner">
									<h3><?php echo $site; ?></h3>
									<p>Unique Visitors</p>
								</div>
								<div class="icon">
									<i class="ion ion-pie-graph"></i>
								</div>
								<a href="#" class="small-box-footer">
									More info <i class="fa fa-arrow-circle-right"></i>
								</a>
							</div>
						</div><!-- ./col -->
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
  </body>
</html>
