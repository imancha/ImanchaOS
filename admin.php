<?php include_once('function.inc');
	if(isset($_SESSION['id'])){		
		if($_SESSION['level'] == "admin"){
			$view = $_GET['view'];

			mysql_open();
			
			$sql = "SELECT avatar FROM user WHERE id='".$_SESSION['id']."' LIMIT 1";
			$res = mysql_query($sql) or die(mysql_error());

			if(mysql_num_rows($res) == 1){
				$row = mysql_fetch_array($res);
				$avatar = $row['avatar'];
			}
			
			mysql_close();

			if($view == "admin"){
				mysql_open();

				if(isset($_POST['submit'])){
					$sql = "SELECT id,username FROM user WHERE username='".$_POST['name']."' OR email='".$_POST['name']."' LIMIT 1";
					$res = mysql_query($sql) or die(mysql_error());

					if(mysql_num_rows($res) == 1){
						$row = mysql_fetch_array($res);
						$sql0 = "UPDATE user SET level='admin' WHERE id='".$row['id']."' LIMIT 1";
						$res0 = mysql_query($sql0) or die(mysql_error());

						if($res0){
							$content = "<div class='alert alert-success alert-dismissable'>
														<i class='fa fa-check'></i>
														<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times</button>
														<b>".$row['username']."</b> added as Admin.
													</div>";
						}else{
							$content = "<div class='alert alert-warning alert-dismissable'>
														<i class='fa fa-warning'></i>
														<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times</button>
														An error has occured. Please try again.
													</div>";
						}
					}else{
						$content = "<div class='alert alert-danger alert-dismissable'>
													<i class='fa fa-danger'></i>
													<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times</button>
													<b>Username</b> did not match. Please try again.
												</div>";
					}
				}

				if(isset($_POST['remove'])){
					$sql0 = "UPDATE user SET level='member' WHERE id='".$_POST['id']."' LIMIT 1";
					$res0 = mysql_query($sql0) or die(mysql_error());

					if($res0){
						$content = "<div class='alert alert-success alert-dismissable'>
													<i class='fa fa-check'></i>
													<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times</button>
													<b>".$_POST['name']."</b> removed from Admin.
												</div>";
					}
				}
											
				
				$content .= "<div class='row'>
											<div class='col-md-2'>
												<button class='btn bg-purple btn-social' data-toggle='collapse' data-target='#add'><i class='fa fa-plus'></i><span> Add Admin</span></button>
											</div>
											<div class='col-md-8'>																					
												<div id='add' class='collapse'>
													<form action='' method='post'>
														<div class='input-group'>
															<input name='name' type='text' class='form-control' placeholder='Type username or email'>
															<div class='input-group-btn'>
																<button class='btn bg-purple' name='submit' type='submit'><i class='fa fa-plus'></i></button>
															</div>
														</div>
													</form>
												</div>
											</div>
										</div><br>";

				$content .= '<div class="box">
												<div class="box-header"><h3 class="box-title"><i class="glyphicon glyphicon-tower"></i> &nbsp;Admin</h3></div>
												<div class="box-body no-padding">';

				$sql = "SELECT * FROM user WHERE level='admin'";
				$res = mysql_query($sql) or die(mysql_error());

				if(mysql_num_rows($res) > 0){
					$content .= '<table class="table table-striped">
												<tbody>
													<tr><th style="width: 10px">#</th><th>Username</th><th>Name</th><th>City</th><th>Email</th><th style="width: 20px">View</th><th style="width: 20px">Remove</th></tr>';

					while($row = mysql_fetch_array($res)){
						$content .= '<tr>
													<td>'.++$i.'</td>
													<td>'.$row['username'].'</td>
													<td>'.$row['name'].'</td>
													<td>'.$row['city'].'</td>
													<td>'.$row['email'].'</td>
													<td style="text-align:center"><button onClick="window.location=\'profile.php?user='.$row['id'].'\'" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-ok"></i></button></td>
													<td style="text-align:center">
														<form action="" method="post">
															<input type="hidden" name="id" value="'.$row['id'].'">
															<input type="hidden" name="name" value="'.$row['username'].'">
															<button name="remove" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></button>
														</form>
													</td>
												</tr>';						
					}

					$content .= '</tbody></table>';
				}

				$content .= '</div></div>';
				
				mysql_close();
			}else if($view == "member"){
				mysql_open();

				$content .= '<div class="box">
												<div class="box-header"><h3 class="box-title"><i class="glyphicon glyphicon-user"></i> &nbsp;Member</h3></div>
												<div class="box-body no-padding">';

				$sql = "SELECT * FROM user";
				$res = mysql_query($sql) or die(mysql_error());

				if(mysql_num_rows($res) > 0){
					$content .= '<table class="table table-striped">
												<tbody>
													<tr><th style="width: 10px">#</th><th>Username</th><th>Name</th><th>City</th><th>Email</th><th>Join Date</th><th style="width: 20px">View</th><th style="width: 20px">Remove</th></tr>';

					while($row = mysql_fetch_array($res)){
						$content .= '<tr>
													<td>'.++$i.'</td>
													<td>'.$row['username'].'</td>
													<td>'.$row['name'].'</td>
													<td>'.$row['city'].'</td>
													<td>'.$row['email'].'</td>
													<td>'.Tanggal($row['date']).'</td>
													<td style="text-align:center"><button onClick="window.location=\'profile.php?user='.$row['id'].'\'" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-ok"></i></button></td>
													<td style="text-align:center">
														<form action="" method="post">
															<input type="hidden" name="id" value="'.$row['id'].'">
															<input type="hidden" name="name" value="'.$row['username'].'">
															<button name="remove" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></button>
														</form>
													</td>
												</tr>';						
					}

					$content .= '</tbody></table>';
				}

				$content .= '</div></div>';
				
				mysql_close();
			}else if($view == "category"){
				mysql_open();

				if(isset($_POST['add'])){
					$sql = "INSERT INTO category VALUES (null,'".$_POST['name']."','".$_POST['desc']."')";
					$res = mysql_query($sql) or die(mysql_error());

					if($res){
						$content = "<div class='alert alert-success alert-dismissable'>
													<i class='fa fa-check'></i>
													<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times</button>
													<b>".$_POST['name']."</b> added to Category.
												</div>";
					}					
				}

				if(isset($_POST['remove'])){
					$sql = "DELETE FROM category WHERE id_category='".$_POST['id']."' LIMIT 1";
					$res = mysql_query($sql) or die(mysql_error());

					if($res){
						$content = "<div class='alert alert-success alert-dismissable'>
													<i class='fa fa-check'></i>
													<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times</button>
													<b>".$_POST['name']."</b> removed from Category.
												</div>";
					}else{
						$content = "<div class='alert alert-warning alert-dismissable'>
														<i class='fa fa-warning'></i>
														<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times</button>
														<b>'".$_POST['name']."'</b> didn't found.
													</div>";
					}
				}

				if(isset($_POST['edit'])){
					$sql = "SELECT * FROM category WHERE id_category='".$_POST['id']."' LIMIT 1";
					$res = mysql_query($sql) or die(mysql_error());

					if(mysql_num_rows($res) == 1){
						$row = mysql_fetch_array($res);
						$edit = "<div id='edit'>
											<form action='' method='post'>											
												<div class='col-md-5'>
													<input name='id' type='hidden' value='".$row['id_category']."'>
													<input name='name' type='text' class='form-control' value='".$row['name_category']."' required>
												</div>
												<div class='col-md-6'>
													<input name='desc' type='text' class='form-control' value='".$row['description']."' required>
												</div>
													<div class='col-md-1'>
														<button class='btn bg-maroon' name='save' type='submit'><i class='fa fa-save'></i></button>
													</div>														
											</form>
										</div>";
					}
				}

				if(isset($_POST['save'])){
					$sql = "UPDATE category SET name_category='".$_POST['name']."',description='".$_POST['desc']."' WHERE id_category='".$_POST['id']."' LIMIT 1";
					$res = mysql_query($sql) or die(mysql_error());

					if($res){
						$content = "<div class='alert alert-success alert-dismissable'>
													<i class='fa fa-check'></i>
													<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times</button>
													<b>".$_POST['name']."</b> have been updated.
												</div>";
					}
				}
				
				$content .= "<div class='row'>
											<div class='col-md-2'>
												<button class='btn bg-maroon btn-social' data-toggle='collapse' data-target='#add'><i class='fa fa-plus'></i><span> Add Category</span></button>
											</div>
											<div class='col-md-10'>																					
												<div id='add' class='collapse'>
													<form action='' method='post'>
														<div class='col-md-5'>
															<input name='name' type='text' class='form-control' placeholder='Category Name' required>
														</div>
														<div class='col-md-6'>
															<input name='desc' type='text' class='form-control' placeholder='Description' required>
														</div>
															<div class='col-md-1'>
																<button class='btn bg-maroon' name='add' type='submit'><i class='fa fa-plus'></i></button>
															</div>														
													</form>
												</div>
												$edit												
											</div>
										</div><br>";

				$content .= '<div class="box">
												<div class="box-header"><h3 class="box-title"><i class="glyphicon glyphicon-th-large"></i> &nbsp;Category</h3></div>
												<div class="box-body no-padding">';				
																

				$sql = "SELECT * FROM category ORDER BY name_category ASC";
				$res = mysql_query($sql) or die(mysql_error());

				if(mysql_num_rows($res) > 0){
					$content .= '<table class="table table-striped">
												<tbody>
													<tr><th style="width: 10px">#</th><th>Name</th><th>Description</th><th style="width: 20px">View</th><th style="width: 20px">Edit</th><th style="width: 20px">Remove</th></tr>';

					while($row = mysql_fetch_array($res)){
						$content .= '<tr>
													<td>'.++$i.'</td>
													<td>'.$row['name_category'].'</td>
													<td>'.$row['description'].'</td>
													<td style="text-align:center"><button onClick="window.location=\'category.php?cid='.$row['id_category'].'&title='.$row['name_category'].'\'" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-ok"></i></button></td>
													<form action="" method="post">
														<input type="hidden" name="id" value="'.$row['id_category'].'">
														<input type="hidden" name="name" value="'.$row['name_category'].'">
														<td style="text-align:center"><button name="edit" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-pencil"></i></button></td>
														<td style="text-align:center"><button name="remove" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></button></td>
													</form>
												</tr>';						
					}

					$content .= '</tbody></table>';
				}

				$content .= '</div></div>';
				
				mysql_close();			
			}else if($view == "topic"){
				mysql_open();

				if(isset($_POST['edit'])){
					$sql = "SELECT * FROM category ORDER BY name_category ASC";
					$res = mysql_query($sql) or die(mysql_error());

					if(mysql_num_rows($res) > 0){
						while($row = mysql_fetch_array($res)){
							if($row['name_category'] == $_POST['name'])
								$select = 'selected';
							else
								$select = '';
								
							$option .= '<option value='.$row['id_category'].' '.$select.'>'.$row['name_category'].'</option>';
						}
					}
					
					$content = "<div class='row'>
												<div class='col-md-1'></div>
												<form action='' method='post'>											
													<div class='col-md-6'>
														<input name='id' type='hidden' value='".$_POST['id']."'>
														<input name='title' type='text' class='form-control' value='".$_POST['title']."' required>
													</div>
													<div class='col-md-3'>
														<select name='name' class='form-control'>$option</select>
													</div>
													<div class='col-md-1'>
														<button class='btn bg-maroon' name='save' type='submit'><i class='fa fa-save'></i></button>
													</div>														
												</form>
											</div><br>";
				}

				if(isset($_POST['save'])){
					$sql = "UPDATE topic SET id_category='".$_POST['name']."',title_topic='".$_POST['title']."' WHERE id_topic='".$_POST['id']."' LIMIT 1";
					$res = mysql_query($sql) or die(mysql_error());

					if($res){
						$content = "<div class='alert alert-success alert-dismissable'>
													<i class='fa fa-check'></i>
													<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times</button>
													<b>ID Topic ".$_POST['id']."</b> have been updated.
												</div>";
					}
				}

				if(isset($_POST['remove'])){
					$sql = "DELETE FROM topic WHERE id_topic='".$_POST['id']."' LIMIT 1";
					$res = mysql_query($sql) or die(mysql_error());

					$content = "<div class='alert alert-success alert-dismissable'>
													<i class='fa fa-check'></i>
													<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times</button>
													<b>ID Topic ".$_POST['id']."</b> have been deleted.
												</div>";
				}

				$content .= '<div class="box">
												<div class="box-header"><h3 class="box-title"><i class="glyphicon glyphicon-th-list"></i> &nbsp;Topic</h3></div>
												<div class="box-body no-padding">';
				$sql = "SELECT * FROM topic ORDER BY date_topic DESC";
				$res = mysql_query($sql) or die(mysql_error());
				
				if(mysql_num_rows($res) > 0){
					$content .= '<table class="table table-striped">
												<tbody>
													<tr><th style="width: 10px">#</th><th>Title</th><th>Category</th><th>Creator</th><th>Date</th><th>Answers</th><th>Views</th><th style="width: 20px">View</th><th style="width: 20px">Edit</th><th style="width: 20px">Remove</th></tr>';

					while($row = mysql_fetch_array($res)){
						$sql0 = "SELECT name_category FROM category WHERE id_category='".$row['id_category']."' LIMIT 1";
						$res0 = mysql_query($sql0) or die(mysql_error());

						if(mysql_num_rows($res0) == 1)
							$row0 = mysql_fetch_array($res0);											
						
						$content .= '<tr>
													<td>'.++$i.'</td>
													<td>'.$row['title_topic'].'</td>
													<td>'.$row0['name_category'].'</td>
													<td>'.$row['creator_topic'].'</td>
													<td>'.$row['date_topic'].'</td>
													<td>'.$row['answers'].'</td>
													<td>'.$row['views'].'</td>
													<td style="text-align:center"><button onClick="window.location=\'topic.php?cid='.$row['id_category'].'&tid='.$row['id_topic'].'&title='.$row['title_topic'].'\'" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-ok"></i></button></td>
													<form action="" method="post">
														<input type="hidden" name="id" value="'.$row['id_topic'].'">
														<input type="hidden" name="title" value="'.$row['title_topic'].'">
														<input type="hidden" name="name" value="'.$row0['name_category'].'">
														<td style="text-align:center"><button name="edit" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-pencil"></i></button></td>
														<td style="text-align:center"><button name="remove" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></button></td>
													</form>													
												</tr>';						
					}

					$content .= '</tbody></table>';
				}
				
				$content .= '</div></div>';
				
				mysql_close();
			}else if($view == "post"){
				mysql_open();

				if(isset($_POST['remove'])){
					$sql = "DELETE FROM post WHERE id_post='".$_POST['id']."' LIMIT 1";
					$res = mysql_query($sql) or die(mysql_error());

					$content = "<div class='alert alert-success alert-dismissable'>
													<i class='fa fa-check'></i>
													<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times</button>
													<b>ID Post ".$_POST['id']."</b> have been deleted.
												</div>";
				}

				$content .= '<div class="box">
												<div class="box-header"><h3 class="box-title"><i class="glyphicon glyphicon-th"></i> &nbsp;Post</h3></div>
												<div class="box-body no-padding">';
												
				$sql = "SELECT * FROM post ORDER BY date_post DESC";
				$res = mysql_query($sql) or die(mysql_error());
				
				if(mysql_num_rows($res) > 0){
					$content .= '<table class="table table-striped">
												<tbody>
													<tr><th style="width: 10px">#</th><th>Content</th><th>Category</th><th>Creator</th><th>Date</th><th style="width: 20px">View</th><th style="width: 20px">Remove</th></tr>';

					while($row = mysql_fetch_array($res)){
						$sql0 = "SELECT name_category FROM category WHERE id_category='".$row['id_category']."' LIMIT 1";
						$res0 = mysql_query($sql0) or die(mysql_error());

						if(mysql_num_rows($res0) == 1)
							$row0 = mysql_fetch_array($res0);

						if(strlen($row['content_post']) > 100)
							$row['content_post'] = substr($row['content_post'],0,100) . "...";
						
						$content .= '<tr>
													<td>'.++$i.'</td>
													<td>'.$row['content_post'].'</td>
													<td>'.$row0['name_category'].'</td>
													<td>'.$row['creator_post'].'</td>
													<td>'.$row['date_post'].'</td>
													<td style="text-align:center"><button onClick="window.location=\'topic.php?cid='.$row['id_category'].'&tid='.$row['id_topic'].'&title='.$row['title_topic'].'\'" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-ok"></i></button></td>
													<form action="" method="post">
														<input type="hidden" name="id" value="'.$row['id_post'].'">																												
														<td style="text-align:center"><button name="remove" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></button></td>
													</form>													
												</tr>';						
					}

					$content .= '</tbody></table>';
				}
				
				$content .= '</div></div>';
				
				mysql_close();			
			}else{
				header("Location: admin.php?view=admin");
				exit();
			}
		}else{
			header('Location: dashboard.php');
			exit();
		}
	}else{
		header('Location: login.php');
		exit();
	}

	$title = "Administrator";
?>
<!DOCTYPE html>
<html>
  <head>
	<meta charset="UTF-8">
	<title><?php echo $title ?> | ImanchaOS</title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>	
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
      <aside class="left-side sidebar-offcanvas">
				<section class="sidebar">
					<div class="user-panel">
						<div class="pull-left image">
							<img src="<?php echo $avatar; ?>" class="img-circle" alt="User Image" />
						</div>
						<div class="pull-left info">
							<p>Hello, <?php echo $_SESSION['username']; ?></p>
							<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
						</div>						
					</div>
					<ul class="sidebar-menu">
						<li><a href='dashboard.php'><i class='fa fa-dashboard'></i><span>Dashboard</span></a></li>
						<li><a href='admin.php?view=admin'><i class='glyphicon glyphicon-tower'></i><span>Admin</span></a></li>
						<li><a href='admin.php?view=member'><i class='glyphicon glyphicon-user'></i><span>Member</span></a></li>
						<li><a href='admin.php?view=category'><i class='glyphicon glyphicon-th-large'></i><span>Category</span></a></li>
						<li><a href='admin.php?view=topic'><i class='glyphicon glyphicon-th-list'></i><span>Topic</span></a></li>
						<li><a href='admin.php?view=post'><i class='glyphicon glyphicon-th'></i><span>Post</span></a></li>
					</ul>
        </section>
      </aside>
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
<?php ob_flush(); ?>
