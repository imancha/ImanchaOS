<?php include_once('function.inc');	
  $title       = "505 Error Page";
  $description = "";
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php echo $title ?> | ImanchaOS</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<meta content='<?php echo $title; ?> | ImanchaOS' name='keywords'/>
		<meta content='<?php echo $description; ?> | ImanchaOS' name='description'/>      
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
					<div class="error-page">
            <h2 class="headline">500</h2>
							<div class="error-content">
								<h3><i class="fa fa-warning text-yellow"></i> Oops! Something went wrong.</h3>
								<p>
									We will work on fixing that right away. 
									Meanwhile, you may <a href='dashboard.php'>return to dashboard</a> or try using the search form.
								</p>
								<form class='search-form' method="GET" action="search.php">
									<div class='input-group'>
										<input type="text" name="keyword" class='form-control' placeholder="Search" required autofocus />
										<div class="input-group-btn">
											<button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
										</div>
									</div><!-- /.input-group -->
								</form>
							</div>
					</div><!-- /.error-page -->
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
<?php ob_flush(); ?>
