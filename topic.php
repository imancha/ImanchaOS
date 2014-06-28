<?php include_once('function.inc');
	$error = FALSE;
	if((isset($_GET['cid']) && is_numeric($_GET['cid'])) AND (isset($_GET['tid']) && is_numeric($_GET['tid']))){
		$cid = (int) $_GET['cid'];
		$tid = (int) $_GET['tid'];
	
		if(0 < $cid && $tid > 0){
			mysql_open();
    
			$sql = "SELECT * FROM category WHERE id_category=$cid LIMIT 1";
			$res = mysql_query($sql) or die(mysql_error());

			if(mysql_num_rows($res) == 1){
				$row = mysql_fetch_assoc($res);
				$title = $row['name_category'];
				$description = $row['description'];
      
				$sql = "SELECT * FROM topic WHERE id_topic='$tid' && id_category='$cid' LIMIT 1";
				$res = mysql_query($sql) or die(mysql_error());
		
				if(mysql_num_rows($res) == 1){
					$row = mysql_fetch_assoc($res);
					$title0 = $row['title_topic'];
					$views = $row['views'];
					$views++;
					
					$sql = "UPDATE topic SET views='$views' WHERE id_topic='$tid' AND id_category='$cid' LIMIT 1";
					$res = mysql_query($sql) or die(mysql_error());
				}else{
					$error = TRUE;
				}      
			}else{    
				$error = TRUE;
			}      
			mysql_close();
		}else{
			$error = TRUE;
		}
  }else{
		$error = TRUE;
	}
	
	if($error){
		header('Location: error.php');
		exit();
	}
?>
<!DOCTYPE html>
<html>
  <head>
	<meta charset="UTF-8">
	<title><?php echo $title0; ?> | ImanchaOS</title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<meta content='<?php echo $title0; ?> | ImanchaOS' name='keywords'/>
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
            <li><?php echo '<a href="category.php?cid='.$cid.'">'.$title.'</a>'; ?></li>
            <li class="active"><?php echo $title0; ?></li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
					<div class="row">
						<div class="col-md-12">
							<h4 class="page-header"><?php echo $title0; ?></h4>
							<p><button class='btn bg-yellow btn-social' <?php if(isset($_SESSION['id'])) echo "onClick=\"window.location='reply.php?cid=".$cid."&tid=".$tid."'\""; else echo 'data-toggle="modal" data-target="#login-modal"'; ?>><i class='fa fa-reply'></i><span> Add Reply</span></button></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">							
								<?php
									mysql_open();
									
									$sql = "SELECT * FROM post WHERE id_topic='$tid' && id_category='$cid' ORDER BY date_post ASC";
									$res = mysql_query($sql) or die(mysql_error());
									
									if(mysql_num_rows($res) > 0){										
										while($row = mysql_fetch_assoc($res)){
											$pid = $row['id_post'];
											$content = $row['content_post'];
											$date = $row['date_post'];
											$edit = $row['edit_date_post'];
											$creator = $row['creator_post'];											
												
											if(substr($date,0,10) == date("Y-m-d"))
												$date = "Today ".substr($date,11,8);
											else if((substr($date,8,2) == (date("d")-1)) && (substr($date,0,8) == date("Y-m-")))
												$date = "Yesterday ".substr($date,11,8);
												
											if(substr($edit,0,10) == date("Y-m-d"))
												$edit = "Today ".substr($edit,11,8);
											else if((substr($date,8,2) == (date("d")-1)) && (substr($edit,0,8) == date("Y-m-")))
												$edit = "Yesterday ".substr($edit,11,8);
											
											$sql0 = "SELECT * FROM user WHERE username='$creator' LIMIT 1";
											$res0 = mysql_query($sql0) or die(mysql_error());											
											
											if(mysql_num_rows($res0) == 1){
												$row0 = mysql_fetch_assoc($res0);								
												$sql1 = "SELECT * FROM topic WHERE creator_topic='".$row0['username']."'";				
												$res1 = mysql_query($sql1) or die(mysql_error());
												$row1 = mysql_num_rows($res1);
												$sql2 = "SELECT * FROM follow WHERE user='".$row0['id']."'";
												$res2 = mysql_query($sql2) or die(mysql_error());										
												$follower = mysql_num_rows($res2);												
												$sql4 = "SELECT * FROM follow WHERE follower='".$row0['id']."'";
												$res4 = mysql_query($sql4) or die(mysql_error());
												$following = mysql_num_rows($res4);
											}
											
											++$id;
											
											if(isset($_SESSION['id'])){
												$sql3 = "SELECT * FROM follow WHERE user='".$row0['id']."' AND follower='".$_SESSION['id']."' LIMIT 1";
												$res3 = mysql_query($sql3) or die(mysql_error());
												
												if(mysql_num_rows($res3) == 1){
													$folow = 'Following';
													$follow = "disabled";
												}else{												
													$folow = 'Follow';
													$follow = "onClick=\"window.location='follow.php?f=".$row0['id']."'\"";
												}
											}else{
												$folow = 'Follow';
												$follow = 'data-toggle="modal" data-target="#login-modal"';																							
											}
											
											if(isset($_SESSION['id']) && ($_SESSION['id'] == $row0['id']))
												$foll = '';
											else
												$foll = '<button class="btn btn-block btn-flat btn-sm" '.$follow.' "><b>'.$folow.'</b></button>';
												
											if(isset($_SESSION['id']))												
												$profile = 'href="profile.php?user='.$row0['id'].'"';		
											else
												$profile = 'href="#" data-toggle="modal" data-target="#login-modal"';
												
											
											echo '<div class="box box-solid box-success">
															<div class="box-header">
																<div class="box-tools pull-left">
																	<button class="btn btn-success btn-xs" data-widget="remove" title="" data-toggle="tooltip" data-original-title="Remove"><i class="fa fa-times"></i></button>
																	<button class="btn btn-success btn-xs" data-widget="collapse" title="" data-toggle="tooltip" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
																</div>
																<div class="box-tools pull-right">
																	<span class="time"><i class="fa fa-clock-o"></i> '.$date.'&nbsp;&nbsp;</span>
																	<a href="#pid='.$id.'"><button class="btn btn-success btn-xs" id="pid='.$id.'"># '.$id.'</button></a>
																</div>
															</div>
															<div class="box-body" style="word-wrap:break-word;">
																<div class="row">
																	<div class="col-md-2">																		
																		<div class="panel panel-warning">
																			<div class="panel-body no-padding">
																				<a '.$profile.' class="thumbnail no-margin"><img src="img/avatar3.png" alt="user image" width="100%"/></a>
																				<button class="btn btn-block btn-flat btn-sm" data-toggle="collapse" data-target="#info'.++$i.'" title="Click Me">'.$creator.'</button>
																				<div id="info'.$i.'" class="collapse" >
																					<table style="margin: 0 5px">																				
																						<tr><td>Join Date</td><td>:</td><td>'.$row0['date'].'</td></tr>
																						<tr><td>City</td><td>:</td><td>'.$row0['city'].'</td></tr>
																						<tr><td>Posts</td><td>:</td><td>'.$row1.'</td></tr>
																						<tr><td>Following</td><td>:</td><td>'.$following.'</td></tr>
																						<tr><td>Followers</td><td>:</td><td>'.$follower.'</td></tr>																						
																					</table>
																					'.$foll.'
																				</div>
																			</div>
																		</div>																		
																	</div>
																	<div class="col-md-10">'.$content.'</div>
																</div>
																<div class="row">
																	<div class="col-md-10 pull-right">';
																		if($edit != null)
																			echo '<span class="pull-left text-muted" style="font-size:smaller"><i class="fa fa-bullhorn"></i>&nbsp; edited on '.$edit.'</span>';
																			
																		if(isset($_SESSION['username'])){
																			echo "<button class='btn btn-xs pull-right' onClick=\"window.location='reply.php?cid=".$cid."&tid=".$tid."&qid=".$pid."'\"><i class='fa fa-quote-right'></i><span>&nbsp; Quote</span></button>";
																			if($_SESSION['username'] == $row0['username'])
																				echo "<button class='btn btn-xs pull-right' onClick=\"window.location='create.php?cid=".$cid."&tid=".$tid."&pid=".$pid."&id=".$id."'\" style='margin-right:5px'><i class='fa fa-edit'></i><span>&nbsp; Edit</span></button>";
																		}else{
																			echo "<button class='btn btn-xs pull-right' data-toggle='modal' data-target='#login-modal'><i class='fa fa-quote-right'></i><span>&nbsp; Quote</span></button>";
																		}
											echo	'			</div>
																</div>
															</div>					
															
													</div>';
										}										
									}else{
										header("Location: errno.php");
										exit();
									}
									mysql_close();
								?>						
								<button class='btn bg-yellow btn-social' <?php if(isset($_SESSION['id'])) echo "onClick=\"window.location='reply.php?cid=".$cid."&tid=".$tid."'\""; else echo 'data-toggle="modal" data-target="#login-modal"'; ?>><i class='fa fa-reply'></i><span> Add Reply</span></button>
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
  </body>
</html>
<?php ob_flush(); ?>
