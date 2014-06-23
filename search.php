<?php include_once('function.inc');
	$keyword = $_GET['keyword'];

	mysql_open();

	$sql = "SELECT * FROM topic WHERE title_topic LIKE '%$keyword%' ORDER BY date_topic DESC";
	$res = mysql_query($sql) or die(mysql_error());

	$content = '<div class="box box-solid">
									<div class="box-body">
										Showing '.mysql_num_rows($res).' result of <i>'.$keyword.'</i><hr>';

	if(mysql_num_rows($res) > 0){		
		while($row = mysql_fetch_array($res)){
			$sql0 = "SELECT content_post FROM post WHERE id_topic='".$row['id_topic']."' AND id_category='".$row['id_category']."' LIMIT 1";
			$res0 = mysql_query($sql0) or die(mysql_error());

			if(mysql_num_rows($res0) == 1){
				$row0 = mysql_fetch_array($res0);

				if(strlen($row0['content_post']) > 400){							
					$row0['content_post'] = substr($row0['content_post'],0,400).' . . . <button class="btn btn-warning btn-xs" onclick="window.location=\'topic.php?cid='.$row['id_category'].'&tid='.$row['id_topic'].'&title='.$row['title_topic'].'\'">readmore</button>';
				}
			}
				
			$content .= '<h2><a href="topic.php?cid='.$row['id_category'].'&tid='.$row['id_topic'].'&title='.$row['title_topic'].'">'.$row['title_topic'].'</a></h2>'.$row0['content_post'].'<hr>';			
		}
	}

	$content .=	'	</div>
								</div>';
								
	mysql_close();

	$title = "Search";
	$description = $keyword;
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
