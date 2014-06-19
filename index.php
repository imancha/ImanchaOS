<?php include_once('function.inc');
	mysql_open();
	
	$sql = "SELECT * FROM topic";
	$res = mysql_query($sql) or die(mysql_error());
	$topic = mysql_num_rows($res);
	$sql = "SELECT * FROM user";
	$res = mysql_query($sql) or die(mysql_error());
	$user = mysql_num_rows($res);

	$sql = "SELECT * FROM topic ORDER BY date_topic DESC LIMIT 10";
	$res = mysql_query($sql) or die(mysql_error());

	if(mysql_num_rows($res) > 0){		
		$content .= '<h4 class="page-header"></h4>
								 <div class="box box-solid box-success">
									<div class="box-header"><h3 class="box-title">Recent Topics</h3></div>
									<div class="box-body table-responsive">
										<table class="table table-hover" id="recent">
											<thead><tr><th width="50%">Title</th><th width="15%">Category</th><th width="15%">Creator</th><th width="20%">Date</th></tr></thead>
											<tbody>';

											while($row = mysql_fetch_array($res)){
												$sql0 = "SELECT name_category FROM category WHERE id_category='".$row['id_category']."' LIMIT 1";
												$res0 = mysql_query($sql0) or die(mysql_error());												

												if(mysql_num_rows($res0) == 1)
													$row0 = mysql_fetch_array($res0);

												$sql1 = "SELECT id FROM user WHERE username='".$row['topic_creator']."' LIMIT 1";
												$res1 = mysql_query($sql1) or die(mysql_error());

												if(mysql_num_rows($res) == 1){
													$row1 = mysql_fetch_array($res1);
													
													if(isset($_SESSION['id']))
														$profile = 'href="profile.php?user='.$row1['id'].'"';
													else
														$profile = 'href="#required" data-toggle="modal" data-target="#login-modal"';
												}
												
												$content .= '<tr><td><a href="topic.php?cid='.$row['id_category'].'&tid='.$row['id_topic'].'&title='.$row['title_topic'].'"><b>'.$row['title_topic'].'</b></a></td><td>'.$row0['name_category'].'</td><td><a '.$profile.'>'.$row['creator_topic'].'</a></td><td>'.$row['date_topic'].'</td></tr>';
											}
											
		$content .=	'			</tbody>
										</table>
									</div>
								</div>';
	}

	$sql = "SELECT * FROM topic ORDER BY views DESC LIMIT 10";
	$res = mysql_query($sql) or die(mysql_error());

	if(mysql_num_rows($res) > 0){
		$content .= '<h4 class="page-header"></h4>
								 <div class="box box-solid box-warning">
									<div class="box-header"><h3 class="box-title">Popular Topics</h3></div>
									<div class="box-body table-responsive">
										<table class="table table-hover" id="recent">
											<thead><tr><th width="50%">Title</th><th width="15%">Category</th><th width="15%">Creator</th><th width="20%">Date</th></tr></thead><tbody>';

											while($row = mysql_fetch_array($res)){
												$sql0 = "SELECT name_category FROM category WHERE id_category='".$row['id_category']."' LIMIT 1";
												$res0 = mysql_query($sql0) or die(mysql_error());												

												if(mysql_num_rows($res0) == 1)
													$row0 = mysql_fetch_array($res0);										
													
												$sql1 = "SELECT id FROM user WHERE username='".$row['topic_creator']."' LIMIT 1";
												$res1 = mysql_query($sql1) or die(mysql_error());

												if(mysql_num_rows($res) == 1){
													$row1 = mysql_fetch_array($res1);
													
													if(isset($_SESSION['id']))
														$profile = 'href="profile.php?user='.$row1['id'].'"';
													else
														$profile = 'href="#required" data-toggle="modal" data-target="#login-modal"';
												}
												
												$content .= '<tr><td><a href="topic.php?cid='.$row['id_category'].'&tid='.$row['id_topic'].'&title='.$row['title_topic'].'"><b>'.$row['title_topic'].'</b></a></td><td>'.$row0['name_category'].'</td><td><a '.$profile.'>'.$row['creator_topic'].'</a></td><td>'.$row['date_topic'].'</td></tr>';
											}
											
		$content .=	'		</table>
									</div>
								</div>';										
	}
	
	mysql_close();
  $title        = "Home";
  $description  = "";  
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
            <li><a href="index.php"><i class="fa fa-dashboard"></i><?php echo $title ?></a></li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">             
					<div class="row">
						<div class="col-lg-6 col-xs-6">
							<!-- small box -->
							<div class="small-box bg-maroon">
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
						<div class="col-lg-6 col-xs-6">
							<!-- small box -->
							<div class="small-box bg-red">
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
					</div>					
					<div class="row">						
						<div class="col-md-12">							
							<?php echo $content; ?>
						</div>
					</div>
        </section><!-- /.content -->
      </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->
    <?php modal(); ?>
    <!-- jQuery 2.0.2 -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
      <!-- jQuery UI 1.10.3 -->
    <script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js" type="text/javascript"></script>    
    <!-- Imancha-OS App -->
    <script src="js/imancha/app.js" type="text/javascript"></script>
		<script src="js/imancha/dashboard.js" type="text/javascript"></script>    
   <!-- page script -->
    <script type="text/javascript">
      $(function() {
          $('#recent').dataTable( {
            "bSort": false,
            "bFilter": false,
            "bLengthChange": false,
            "bAutoWidth": false,
            "bPaginate": false
          } );
        });
    </script>    
  </body>
</html>
