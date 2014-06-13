<?php include_once('function.inc');			
	$error = FALSE;
	$errno = FALSE;
	
	if(isset($_SESSION['id'])){
		$action = (int) $_GET['action'];
		
		mysql_open();
		
		$sql = "SELECT * FROM message WHERE receiver_message='".$_SESSION['username']."' AND status_message='sent'";
		$res = mysql_query($sql) or die(mysql_error());
		$num = mysql_num_rows($res);
		
		switch($action){
			case 0 :
			case 1 : 
				$case = "INBOX";
				$inbox = "class='active'";
				$mid = $_GET['mid'];

				if(is_numeric($mid) && $mid > 0){
					$sql = "SELECT user_message FROM message WHERE receiver_message='".$_SESSION['username']."' AND id_message='$mid' LIMIT 1";
					$res = mysql_query($sql) or die(mysql_error());
					$row = mysql_fetch_array($res);
					$to = $row['0'];
					$sql = "UPDATE message SET status_message='read' WHERE user_message='".$row['0']."' AND receiver_message='".$_SESSION['username']."' AND status_message='sent'";
					$res = mysql_query($sql) or die(mysql_error());

					$sql = "SELECT * FROM message WHERE user_message='".$row['0']."' AND receiver_message='".$_SESSION['username']."' AND receiver_deleted='N' ORDER BY date_message ASC";
					$res = mysql_query($sql) or die(mysql_error());
						
					if(mysql_num_rows($res) > 0){
						$message = '<div class="box box-solid">
													<div class="box-header">
														<h3 class="box-title"><i class="fa fa-comments-o"></i> Chat</h3>
														<div class="box-tools pull-right" data-toggle="tooltip" title="Status">
															<div class="btn-group" data-toggle="btn-toggle" >
																<button type="button" class="btn btn-default btn-sm active"><i class="fa fa-square text-green"></i></button>                                            
																<button type="button" class="btn btn-default btn-sm"><i class="fa fa-square text-red"></i></button>
															</div>
														</div>
													</div>
													<div class="box-body chat" id="chat-box">';
														
						while($row = mysql_fetch_assoc($res)){
							$sql0 = "SELECT id FROM user WHERE username='".$row['user_message']."' LIMIT 1";
							$res0 = mysql_query($sql0) or die(mysql_error());
							$row0 = mysql_fetch_array($res0);
							
							$message .= '<div class="item" id='.$row['id_message'].'>
														<img src="img/avatar3.png" alt="user image" class="offline"/>
														<p class="message">
															<a href="profile.php?user='.$row0['0'].'" class="name">
																<small class="text-muted pull-right"><i class="fa fa-clock-o"></i> '.$row['date_message'].'</small>
																'.$row['user_message'].'
															</a>
															'.$row['content_message'].'
														</p>
													</div>';
						}						
												
						$message .= '</div>';
						
						if(isset($_POST['chat'])){
							if(!empty($_POST['name'])){
								$name = $_POST['name'];
							}else{
								$name = FALSE;								
							}
							
							if(!empty($_POST['content'])){
								$content = $_POST['content'];
							}else{
								$content = FALSE;
								$message .= '<div class="alert alert-warning alert-dismissable">
															<i class="fa fa-ban"></i>
															<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
															Please fill content messages.
														</div>';						
							}
							
							if($name && $content){
								$sql = "INSERT INTO message VALUES (null,'".$_SESSION['username']."','$content','$name',now(),'sent','N','N')";
								$res = mysql_query($sql) or die(mysql_error());
								
								if($res){									
									header("Location: messages.php?mid=".mysql_insert_id()."#".mysql_insert_id());
									exit();
								}
							}
						}
						
						$message .= '<div class="box-footer">
													<form action="" method="POST">
														<div class="input-group">
															<input name="name" value='.$to.' type="hidden">
															<input name="content" type="text" class="form-control" placeholder="Type message...">
															<div class="input-group-btn">
																<button class="btn btn-success" name="chat" type="submit"><i class="fa fa-plus"></i></button>
															</div>
														</div>
													</form>
												</div>';
						$message .= '</div>';	
					}else{
						$errno = TRUE;
						break;
					}
				}else{
					$sql = "SELECT * FROM message WHERE receiver_message='".$_SESSION['username']."' AND receiver_deleted='N' ORDER BY date_message DESC";
					$res = mysql_query($sql) or die(mysql_error());
							
					if(mysql_num_rows($res) > 0){
						$message = '<table class="table table-mailbox" id="messages">
													<thead><tr><th><label style="margin-right: 10px;"><input type="checkbox" id="check-all"/></label></th><th>SUBJECT</th><th>FROM</th><th>DATE</th></tr></thead>
													<tbody>';
															
						while($row = mysql_fetch_assoc($res)){							
							$mid = $row['id_message'];
							$user = $row['user_message'];
							$content = $row['content_message'];
							$date = $row['date_message'];
							$status = $row['status_message'];
							
							$sql0 = "SELECT id FROM user WHERE username='".$row['user_message']."' LIMIT 1";
							$res0 = mysql_query($sql0) or die(mysql_error());
							$row0 = mysql_fetch_array($res0);
									
							if(strlen($content) > 50)
								$content = substr($content,0,50) . "...";												
							
							if($status == "sent")
								$sent = 'class="unread"';
							else
								$sent = '';									
										
							$message .= '<tr '.$sent.'>
														<td class="small-col"><input type="checkbox" /></td>														
														<td class="subject"><a href="messages.php?mid='.$mid.'#'.$mid.'">'.$content.'</a></td>
														<td class="name"><a href="profile.php?user='.$row0['0'].'">'.$user.'</a></td>
														<td class="time">'.$date.'</td>														
													</tr>';
						}
						$message .= '</tbody></table>';
					}else{
						$message = '<div class="callout callout-info"><p>There are no messages available yet in your inbox.</p></div>';
					}
				}				
				break;
			case 2 :
				$case = "SENT";
				$sent = "class='active'";
				
				$sql = "SELECT * FROM message WHERE user_message='".$_SESSION['username']."' AND user_deleted='N' ORDER BY date_message DESC";
				$res = mysql_query($sql) or die(mysql_error());
				
				if(mysql_num_rows($res) > 0){
					$message = '<table class="table table-mailbox" id="messages">
												<thead><tr><th><label style="margin-right: 10px;"><input type="checkbox" id="check-all"/></label></th><th>SUBJECT</th><th>TO</th><th>DATE</th></tr></thead>
												<tbody>';
					
					while($row = mysql_fetch_array($res)){
						$sql0 = "SELECT id FROM user WHERE username='".$row['user_message']."' LIMIT 1";
						$res0 = mysql_query($sql0) or die(mysql_error());
						$row0 = mysql_fetch_array($res0);
						
						if(strlen($row['content_message']) > 50)
							$row['content_message'] = substr($row['content_message'],0,50) . "...";
						
						$message .= '<tr>
													<td class="small-col"><input type="checkbox" /></td>													
													<td class="subject"><a href="messages.php?mid='.$row['id_message'].'">'.$row['content_message'].'</a></td>
													<td class="name"><a href="profile.php?user='.$row0['0'].'">'.$row['receiver_message'].'</a></td>
													<td class="time">'.$row['date_message'].'</td>
												</tr>';
					}
					$message .= '</tbody></table>';
				}else{
					$message = '<div class="callout callout-info"><p>There are no messages available yet that you sent.</p></div>';
				}
				break;
/*			case 3 :
				$case = "TRASH";				
				$trash = "class='active'";
				
				$sql = "SELECT * FROM message WHERE receiver_message='".$_SESSION['username']."' AND receiver_deleted='Y' ORDER BY date_message DESC";
				$res = mysql_query($sql) or die(mysql_error());
				
				if(mysql_num_rows($res) > 0){
					$message = '<table class="table table-mailbox" id="messages">
												<thead><tr><th><label style="margin-right: 10px;"><input type="checkbox" id="check-all"/></label></th><th>TO</th><th>SUBJECT</th><th>DATE</th></tr></thead>
												<tbody>';
					
					while($row = mysql_fetch_array($res)){
						if(strlen($row['content_message']) > 50)
							$row['content_message'] = substr($row['content_message'],0,50) . "...";
						
						$message .= '<tr>
													<td class="small-col"><input type="checkbox" /></td>
													<td class="name"><a href="#">'.$row['user_message'].'</a></td>
													<td class="subject"><a href="messages.php?mid='.$mid.'">'.$row['content_message'].'</a></td>
													<td class="time">'.$row['date_message'].'</td>
												</tr>';
					}
					$message .= '</tbody></table>';
				}else{
					$message = '<div class="callout callout-info"><p>There are no messages available yet in your trash.</p></div>';
				}								
				break;
*/		
			case 5 :				
				$case = "WRITE";
				
				if(isset($_POST['submit'])){					
					if(!empty($_POST['name'])){
						$name = $_POST['name'];
						
						$sql = "SELECT * FROM user WHERE username='$name' LIMIT 1";
						$res = mysql_query($sql) or die(mysql_error());
						
						if(mysql_num_rows($res) == 0){
							$name = FALSE;
							$message = '<div class="alert alert-warning alert-dismissable">
														<i class="fa fa-ban"></i>
														<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
														Username of the receiver didn\'t exist.
													</div>';
						}
					}else{
						$name = FALSE;
						$message = '<div class="alert alert-warning alert-dismissable">
													<i class="fa fa-ban"></i>
													<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
													Please fill receiver username.
												</div>';
					}
					
					if(!empty($_POST['content'])){
						$content = $_POST['content'];
					}else{
						$content = FALSE;
						$message .= '<div class="alert alert-warning alert-dismissable">
													<i class="fa fa-ban"></i>
													<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
													Please fill content messages.
												</div>';						
					}
					
					if($name && $content){
						$sql = "INSERT INTO message VALUES ('".mysql_insert_id()."','".$_SESSION['username']."','$content','$name',now(),'sent','N','N')";
						$res = mysql_query($sql) or die(mysql_error());
						
						if($res){
							$message = '<div class="alert alert-success alert-dismissable">
														<i class="fa fa-check"></i>
														<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
														Your messages have been sent succesfully.
													</div>';
						}else{
							$message = '<div class="alert alert-danger alert-dismissable">
														<i class="fa fa-check"></i>
														<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
														Your messages failed to sent. Please try again.
													</div>';
						}
					}
				}
				
        $message .=  '<div class="box box-info">
											<div class="box-header">
												<i class="fa fa-envelope"></i>
												<h3 class="box-title">Write Message</h3>
											</div>
											<form action="" method="post">
												<div class="box-body">												
													<div class="form-group">
														<input type="text" class="form-control" name="name" placeholder="Message to:"/>
													</div>													
													<div>
														<textarea class="textarea" name="content" placeholder="Message Content" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
													</div>												
												</div>
												<div class="box-footer clearfix">
													<button class="pull-right btn btn-default" id="sendEmail" name="submit">Send <i class="fa fa-arrow-circle-right"></i></button>
												</div>
											</form>
										</div>';				
				break;
		}
		mysql_close();
	}else{
		$error = TRUE;
	}
	
	if($error){
		header("Location: error.php");
		exit();
	}
	
	if($errno){
		header('Location: errno.php');
		exit();
	}
	
  $title        = "Mailbox";
  $description  = "";  
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
  <!-- DATA TABLES -->
  <link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />	
	<!-- bootstrap wysihtml5 - text editor -->
  <link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
  <!-- iCheck for checkboxes and radio inputs -->
  <link href="css/iCheck/minimal/blue.css" rel="stylesheet" type="text/css" />
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
          <?php echo '<h1 class="text-center">'.$title.'</h1>'; ?>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li class="active"><?php echo $title ?></a></li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">             
					<!-- MAILBOX BEGIN -->
          <div class="mailbox row">
            <div class="col-xs-12">
              <div class="box box-solid">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-3 col-sm-4">
                      <!-- BOXES are complex enough to move the .box-header around.
                      This is an example of having the box header within the box body -->
                      <div class="box-header">
                        <i class="fa fa-inbox"></i>
                        <h3 class="box-title"><?php echo $case; ?></h3>
                      </div>
                      <!-- compose message btn -->
                      <button class="btn btn-block btn-primary" onclick="window.location='messages.php?action=5'"><i class="fa fa-pencil"></i> Compose Message</button>
                      <!-- Navigation - folders-->
                      <div style="margin-top: 15px;">
                        <ul class="nav nav-pills nav-stacked">
                          <li class="header">Folders</li>
                          <li <?php echo $inbox; ?>><a href="messages.php?action=1"><i class="fa fa-inbox"></i> Inbox (<?php echo $num; ?>)</a></li>
                          <li <?php echo $sent; ?>><a href="messages.php?action=2"><i class="fa fa-mail-forward"></i> Sent</a></li>
                        </ul>
                      </div>
                    </div><!-- /.col (LEFT) -->
                    <div class="col-md-9 col-sm-8">
                      <div class="row pad">
											</div><!-- /.row -->
											<div class="table-responsive">
											<?php echo $message; ?>
											</div>
										</div><!-- /.col (RIGHT) -->
									</div><!-- /.row -->
								</div><!-- /.box-body -->
							</div><!-- /.box -->
						</div><!-- /.col (MAIN) -->
					</div>
					<!-- MAILBOX END -->
        </section><!-- /.content -->
      </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->    
    <!-- jQuery 2.0.2 -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <!-- jQuery UI 1.10.3 -->
    <script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
    <!-- DATA TABES SCRIPT -->
    <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js" type="text/javascript"></script>    
    <!-- Imancha-OS App -->
    <script src="js/imancha/app.js" type="text/javascript"></script>        
   <!-- page script -->
    <script type="text/javascript">			
      $(function() {          
          $('#messages').dataTable( {   
            "bSort": false 
          } );
      });
    </script>    
  </body>
</html>
