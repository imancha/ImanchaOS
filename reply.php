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
					$answers = $row['answers'];
					$answers++;
					
					if(isset($_GET['qid']) && is_numeric($_GET['qid'])){
						$pid = (int) $_GET['qid'];
						
						if($pid > 0){
							$sql = "SELECT * FROM post WHERE id_post='$pid' AND id_topic='$tid' AND id_category='$cid' LIMIT 1";
							$res = mysql_query($sql) or die(mysql_error());
							
							if(mysql_num_rows($res) == 1){
								$row = mysql_fetch_assoc($res);
								$content = $row['content_post'];
								
								$_POST['editor1'] = '<div style="background:#eee; border:1px solid #ccc; padding:5px 10px">'.$content.'</div><br>';
							}else{
								$error = TRUE;
							}
						}else{
							$error = TRUE;
						}
					}
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
            <li><?php echo '<a href="category.php?cid='.$cid.'">'.$title.'</a>'; ?></li>
            <li class="active"><?php echo $title0; ?></li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
					<div class="row">
						<div class="col-md-12">
							<h4 class="page-header"><?php echo $title0; ?></h4>							
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">							
							<?php
								ob_start();
								
								if(isset($_POST['submit'])){
									// Validate Content Topic
									if(!empty($_POST['editor1'])){
										$content = $_POST['editor1'];
									}else{
										$content = FALSE;
										echo '<div class="alert alert-danger alert-dismissable">
														<i class="fa fa-ban"></i>
														<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
														<b>Please fill Reply Content.</b>
														</div>';
									}

									if($content){
										mysql_open();
										
										$sql = "INSERT INTO post VALUES (null,'$tid','$cid','$content',now(),NULL,'".$_SESSION['username']."')";
										$res = mysql_query($sql) or die(mysql_error());
										
										if($res){
											$sql = "UPDATE topic SET answers='$answers',reply_date_topic=now(),last_post_by='".$_SESSION['username']."' WHERE id_topic='$tid' AND id_category='$cid'";
											$res = mysql_query($sql) or die(mysql_error());
											
											$sql = "SELECT COUNT(*) FROM post WHERE id_topic='$tid' AND id_category='$cid'";
											$res = mysql_query($sql) or die(mysql_error());
											
											if($res){
												$row = mysql_fetch_row($res);
												$id = $row[0];
												
												echo '<div class="alert alert-success alert-dismissable">
																<i class="fa fa-check"></i>
																<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
																Your Reply have been posted succesfully.<br>You may <a href="topic.php?cid='.$cid.'&tid='.$tid.'#pid='.$id.'">View Your Reply</a> or Post New Reply.
															</div>';
															
												$_POST['editor1'] = null;
											}else{
												header("Location: errno.php");										
												exit();
											}
										}else{
											header("Location: errno.php");										
											exit();
										}

										mysql_close();
									}
								}
								ob_flush();
							?>
							<form action="<?php echo $_SERVER['PHP_SELF'].'?cid='.$cid.'&tid='.$tid;?>" method="post">																															
								<div class="form-group">
									<textarea id="editor1" name="editor1" rows="10" cols="80"><?php if(isset($_POST['editor1']) AND (!empty($_POST['editor1']))) echo $_POST['editor1']; ?></textarea>
								</div>
								<div class="form-group">
									<p class="pull-right"><button type="submit" name="submit" class='btn bg-yellow btn-social'><i class='fa fa-check-square-o'></i><span> Submit Reply</span></button></p>
								</div>
							</form>								
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
    <!-- CK Editor -->
    <script src="js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(function() {
          // Replace the <textarea id="editor1"> with a CKEditor
          // instance, using default configuration.
          CKEDITOR.replace('editor1');
      });
    </script>
  </body>
</html>
