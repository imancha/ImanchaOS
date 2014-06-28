<?php include_once('function.inc');	
	$error = FALSE;
	if(isset($_SESSION['id'])){		
		$nid = $_GET['nid'];
		
		mysql_open();		
		$sql = "SELECT * FROM notification WHERE id_user='".$_SESSION['id']."' ";
		
		$notification = '<ul class="timeline">';
		
		if(is_numeric($nid) && $nid > 0){
			$sql0 = "UPDATE notification SET status_notification='read' WHERE id_notification='$nid' LIMIT 1";
			$res0 = mysql_query($sql0) or die(mysql_error());			
			$sql .= "AND id_notification='$nid' LIMIT 1";
			$res = mysql_query($sql) or die(mysql_error());
			
			if(mysql_num_rows($res) == 1){
				$row = mysql_fetch_array($res);
				$notification .= '<li>
														<i class="fa fa-comments bg-aqua"></i>															
														<div class="timeline-item">				
															<span class="time"><i class="fa fa-clock-o"></i> '.$row['date_notification'].'</span>
															<h3 class="timeline-header no-border"><a href="#">'.$row['user_notification'].'</a> &nbsp;'.$row['content_notification'].'</h3>
														</div>
													</li>';				
			}
		}else{
			$sql0 = "UPDATE notification SET status_notification='read' WHERE id_user='".$_SESSION['id']."' AND status_notification='sent'";
			$res0 = mysql_query($sql0) or die(mysql_error());				
			$sql .= "ORDER BY date_notification DESC";
			$res = mysql_query($sql) or die(mysql_error());
			
			if(mysql_num_rows($res) > 0){
				while($row = mysql_fetch_array($res)){
					$notification .= '<li>
															<i class="fa fa-comments bg-aqua"></i>															
															<div class="timeline-item">				
																<span class="time"><i class="fa fa-clock-o"></i> '.$row['date_notification'].'</span>
																<h3 class="timeline-header no-border"><a href="#">'.$row['user_notification'].'</a> &nbsp;'.$row['content_notification'].'</h3>
															</div>
														</li>';
				}
			}
		}
		
		$notification .= '<li><i class="fa fa-clock-o"></i></li></ul>';
		
		mysql_close();
	}else{
		$error = TRUE;
	}
	
	if($error){
		header("Location: error.php");
		exit();
	}

  $title        = "Notification";
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
						<div class="col-md-12">
							<?php echo $notification; ?>
						</div>
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
<?php ob_flush(); ?>
