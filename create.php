<?php include_once('function.inc');
	$error = FALSE;
	$edit = FALSE;
	if(isset($_GET['cid']) && is_numeric($_GET['cid'])){
		$cid = (int) $_GET['cid'];

		if($cid > 0){
			mysql_open();

			$sql = "SELECT * FROM category WHERE id_category=$cid LIMIT 1";
			$res = mysql_query($sql) or die(mysql_error());

			if(mysql_num_rows($res) == 1){
				$row = mysql_fetch_assoc($res);
				$title0 = $row['name_category'];
				
				$title = "Create Topic";
				$description = "Create New Topic on $title0 Category";
				
				if((isset($_GET['tid']) && is_numeric($_GET['tid'])) AND (isset($_GET['pid']) && is_numeric($_GET['pid'])) AND (isset($_GET['id']) && is_numeric($_GET['id']))){
					$tid = (int) $_GET['tid'];
					$pid = (int) $_GET['pid'];
					$id = (int) $_GET['id'];
					
					if($tid > 0 && $pid > 0 && $tid > 0){
						$sql = "SELECT * FROM post WHERE id_post='$pid' AND id_topic='$tid' AND id_category='$cid' LIMIT 1";
						$res = mysql_query($sql) or die(mysql_error());
						
						if(mysql_num_rows($res) == 1){
							$row = mysql_fetch_assoc($res);
							$content = $row['content_post'];							
							$creator = $row['creator_post'];
							
							if(isset($_SESSION['username']) && $_SESSION['username'] == $creator){
								if($id == 1){
									$sql = "SELECT * FROM topic WHERE id_topic='$tid' AND id_category='$cid' LIMIT 1";
									$res = mysql_query($sql) or die(mysql_error());
									
									if(mysql_num_rows($res) == 1){
										$row = mysql_fetch_assoc($res);
										$topic = $row['title_topic'];
									}else{
										$error = TRUE;
									}
								}
								$edit = TRUE;
							}else{
								$error = TRUE;
							}
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
						<li><?php echo '<a href="category.php?cid='.$cid.'">'.$title0.'</a>'; ?></li>
						<li class="active"><?php echo $title; ?></li>
					</ol>
				</section>
				<!-- Main content -->
				<section class="content">					
					<?php
						if(isset($_POST['submit'])){
							// Validate Title Topic
							if(!empty($_POST['title'])){
								$title = $_POST['title'];
							}else{
								$title = FALSE;
								echo '<div class="alert alert-danger alert-dismissable">
												<i class="fa fa-ban"></i>
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
												<b>Please fill Topic Title.</b>
											</div>';
							}
							
							// Validate Content Topic
							if(!empty($_POST['editor1'])){
								$content = $_POST['editor1'];
							}else{
								$content = FALSE;
								echo '<div class="alert alert-danger alert-dismissable">
												<i class="fa fa-ban"></i>
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
												<b>Please fill Topic Content.</b>
												</div>';
							}
							
							if($title && $content){
								mysql_open();								
								$sql = "INSERT INTO topic (id_category,title_topic,date_topic,reply_date_topic,creator_topic,last_post_by) VALUES ('$cid','$title',now(),now(),'".$_SESSION['username']."','".$_SESSION['username']."')";
								$res = mysql_query($sql) or die(mysql_error());
								$tid0 = mysql_insert_id();
								$sql0 = "INSERT INTO post VALUES (null,'$tid0','$cid','$content',now(),null,'".$_SESSION['username']."')";
								$res0 = mysql_query($sql0) or die(mysql_error());
									
								if($res && $res0){									
									echo '<div class="alert alert-success alert-dismissable">
													<i class="fa fa-check"></i>
													<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
													Your Topic have been posted succesfully.<br>You may <a href="topic.php?cid='.$cid.'&tid='.$tid0.'">View Your Topic</a> or Create New Topic.
												</div>';
									$_POST['title'] = null;
									$_POST['editor1'] = null;
								}else{									
									header("Location: errno.php");										
									exit();
								}																	
								mysql_close();
							}
						}
						
						if(isset($_POST['edit'])){
							mysql_open();
							
							$sql = "UPDATE post SET content_post='".$_POST['editor1']."',edit_date_post=now() WHERE id_post='$pid' AND id_topic='$tid' AND id_category='$cid' LIMIT 1";
							$res = mysql_query($sql) or die(mysql_error());
																
							if($id == 1){								
								$sql = "UPDATE topic SET title_topic='".$_POST['title']."' WHERE id_topic='$tid' AND id_category='$cid' LIMIT 1";
								$res = mysql_query($sql) or die(mysql_error());
							}
														
							echo '<div class="alert alert-success alert-dismissable">
											<i class="fa fa-check"></i>
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
											Your post have been posted succesfully.<br>You may <a href="topic.php?cid='.$cid.'&tid='.$tid.'#pid='.$id.'">View Your Post</a> or Edit Your Post again.
										</div>';
											
							mysql_close();
						}						
					?>
					<form action="" method="post">						
						<div class="form-group">
							<p><button type="submit" name="<?php if($edit) echo 'edit'; else echo 'submit'; ?>" class='btn bg-yellow btn-social'><i class='fa fa-check-square-o'></i><span> Submit Topic</span></button></p>
						</div>
							<div class="form-group has-success">
								<?php 
									if((!$edit) || ($edit && $id == 1)){
										echo '<p><input type="text" name="title" class="form-control" placeholder="Topic Title" value="';if(isset($_POST['title']) AND (!empty($_POST['title']))) echo $_POST['title']; else if($edit) echo $topic; echo'"></p>';
									}
								?>								
							</div>
							<div class="form-group">
								<textarea id="editor1" name="editor1" rows="10" cols="80">
									<?php 
										if(isset($_POST['editor1']) AND (!empty($_POST['editor1']))){
											echo $_POST['editor1']; 
										}else if($edit){
											echo $content;
										}else{
											echo "Topic Content"; 
										}
									?>
								</textarea>
							</div>
					</form>
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
