<?php include_once('function.inc');		
	$error = FALSE;
  if(isset($_GET['cid']) && is_numeric($_GET['cid'])){
		$cid = (int) $_GET['cid'];

		if($cid > 0){
			mysql_open();

			$sql = "SELECT * FROM category WHERE id_category=$cid LIMIT 1";
			$res = mysql_query($sql) or die(mysql_error());

			if(mysql_num_rows($res) == 1){
				$row = mysql_fetch_assoc($res);
				$title = $row['name_category'];
				$description = $row['description'];
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
    <!-- DATA TABLES -->
    <link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
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
            <li class="active"><?php echo $title; ?></li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <div class="row">
						<div class="col-md-6">
							<p><button class='btn bg-blue btn-social' <?php if(isset($_SESSION['id'])) echo "onClick=\"window.location='create.php?cid=".$cid."&title=".$title."'\""; else echo 'data-toggle="modal" data-target="#login-modal"'; ?>><i class='fa fa-pencil'></i><span> Create Topic</span></button></p>
						</div>
						<div class="col-md-6">
							<form class="search-form" method="GET" action="search.php">
                <div class="input-group">
                  <input type="text" name="keyword" class="form-control" placeholder="Search" required />
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </form>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="box box-solid">
								<?php
									mysql_open();

									$sql = "SELECT * FROM topic WHERE id_category=$cid ORDER BY reply_date_topic DESC";
									$res = mysql_query($sql) or die(mysql_error());

									if(mysql_num_rows($res) > 0){
										$topic .= '<div class="box-body table-responsive">';
										$topic .= '<table class="table table-hover" id="category">';
										$topic .= '<thead><tr><th width="60%">Title</th><th width="20%">Last Post</th><th width="10%" class="text-center">Answers</th><th width="10%" class="text-center">Views</th></tr></thead><tbody>';
										while($row = mysql_fetch_assoc($res)){
											$tid = $row['id_topic'];
											$title = $row['title_topic'];
											$answer = $row['answers'];
											$view = $row ['views'];
											$date = $row['date_topic'];
											$last = $row['last_post_by'];
											$reply = $row['reply_date_topic'];
											$creator = $row['creator_topic'];

											$sql0 = "SELECT id FROM user WHERE username='$creator' LIMIT 1";
											$res0 = mysql_query($sql0) or die(mysql_error());
											$row0 = mysql_fetch_array($res0);
											$sql1 = "SELECT id FROM user WHERE username='$last' LIMIT 1";
											$res1 = mysql_query($sql1) or die(mysql_error());
											$row1 = mysql_fetch_array($res1);

											if(substr($date,0,10) == date("Y-m-d"))
												$date = "Today ".substr($date,11,8);
											else if((substr($date,8,2) == (date("d")-1)) && (substr($date,0,8) == date("Y-m-")))
												$date = "Yesterday ".substr($date,11,8);

											if(substr($reply,0,10) == date("Y-m-d"))
												$reply = "Today ".substr($reply,11,8);
											else if((substr($reply,8,2) == (date("d")-1)) && (substr($reply,0,8) == date("Y-m-")))
												$reply = "Yesterday ".substr($reply,11,8);

											if(isset($_SESSION['id']))
												$profil = 'href="profile.php?user='.$row0['id'].'"';
											else
												$profil = 'href="#required" data-toggle="modal" data-target="#login-modal"';

											if(isset($_SESSION['id']))
												$profile = 'href="profile.php?user='.$row1['id'].'"';
											else
												$profile = 'href="#required" data-toggle="modal" data-target="#login-modal"';

											$topic .= "<tr>
																	<td><p style='font-size: 16.5px;' class='no-margin'><b><a href='topic.php?cid=$cid&tid=$tid&title=$title'>$title</a></b></p><p style='font-size:smaller;'>Started by <a $profil>$creator</a> on $date</p></td>
																	<td><p class='no-margin'>$reply</p> by <a $profile>$last</a></td>
																	<td class='text-center'><p class='lead margin'>$answer</p></td>
																	<td class='text-center'><p class='lead margin'>$view</p></td>
																 </tr>";

										}
										$topic .= "</tbody></table></div>";

									}else{
										$topic = "<div class='box-body'>There are no topics available in $title categories yet.</div>";
									}
									echo $topic;
									mysql_close();
								?>
							</div>
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
    <!-- DATA TABES SCRIPT -->
    <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <!-- Imancha-OS App -->
    <script src="js/imancha/app.js" type="text/javascript"></script>
   <!-- page script -->
    <script type="text/javascript">
      $(function() {
          $('#category').dataTable( {
            "bSort": false,
            "bFilter": false,
            "bLengthChange": false,
            "bAutoWidth": false
          } );
        });
    </script>
  </body>
</html>
<?php ob_flush(); ?>
