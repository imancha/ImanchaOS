<?php include_once('function.inc');
	if(!isset($_SESSION['id'])){
		header('Location: index.php');
		exit();
	}
	
	mysql_open();
	
	$sql = "SELECT * FROM topic ORDER BY date_topic DESC";
	$res = mysql_query($sql) or die(mysql_error());
	
	if(mysql_num_rows($res) > 0){		
		while($row = mysql_fetch_array($res)){			
			$sql0 = "SELECT * FROM user WHERE username='".$row['creator_topic']."' LIMIT 1";
			$res0 = mysql_query($sql0) or die(mysql_error());
			
			if(mysql_num_rows($res0) == 1){
				$row0 = mysql_fetch_array($res0);
				$sql1 = "SELECT * FROM follow WHERE user='".$row0['id']."' AND follower='".$_SESSION['id']."' LIMIT 1";
				$res1 = mysql_query($sql1) or die(mysql_error());
				
				if(mysql_num_rows($res1) <= 1){
					$sql2 = "SELECT * FROM post WHERE id_topic='".$row['id_topic']."' AND id_category='".$row['id_category']."' ORDER BY date_post ASC";
					$res2 = mysql_query($sql2) or die(mysql_error());
					
					if(mysql_num_rows($res2) > 0){
						$row2 = mysql_fetch_array($res2);
						
						$content .= '<div class="box box-solid">											
													<div class="box-body" style="word-wrap:break-word;">
														<div class="row">								
															<div class="col-md-12">
																<h3 class="page-header">
																	<a href="topic.php?cid='.$row['id_category'].'&tid='.$row['id_topic'].'&title='.$row['title_topic'].'">'.$row['title_topic'].'</a>
																	<small class="pull-right"><i class="fa fa-clock-o"></i> '.$row['date_topic'].'</small>
																</h3>
															</div>
														</div>
														<div class="row">
															<div class="col-sm-4 col-md-2">																																
																<div class="panel panel-warning">
																	<div class="panel-body no-padding">
																		<a href="profile.php?user='.$row0['id'].'" class="thumbnail no-margin"><img src="img/avatar3.png" alt="user image" width="100%"/></a>
																		<button class="btn btn-block btn-flat btn-sm" data-toggle="collapse" data-target="#info'.++$i.'" title="Click Me">'.$row['creator_topic'].'</button>
																		<div id="info'.$i.'" class="collapse" style="margin: 0 5px">
																			<table>
																				<tr><td>Join Date</td><td>:</td><td>'.$row0['date'].'</td></tr>
																				<tr><td>City</td><td>:</td><td>'.$row0['city'].'</td></tr>
																				<tr><td>Posts</td><td>:</td><td></td></tr>
																				<tr><td>Following</td><td>:</td><td>'.$following.'</td></tr>
																				<tr><td>Followers</td><td>:</td><td>'.$follower.'</td></tr>
																			</table>
																		</div>
																	</div>
																</div>
															</div>
															<div class="col-md-10">
																'.$row2['content_post'].'
															</div>															
														</div>	
														<div class="row">
															<div class="col-md-10 pull-right">
																<button class="btn btn-flat bg-olive pull-right" onClick="window.location=\'reply.php?cid='.$row['id_category'].'&tid='.$row['id_topic'].'\'">Reply</button>
															</div>
														</div>
													</div>													
												</div>';
					}
				}
			}			
		}
	}	
	
	mysql_close();
		
	
  $title        = "Dashboard";
  $description  = "Control Panel";  
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
						<li><a href="index.php"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active"><?php echo $title ?></li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">             					
					<?php echo $content; ?>
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