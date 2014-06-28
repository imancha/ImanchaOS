<?php session_start();
	ob_start();
	
	function mysql_open(){
		$host = "localhost";
		$username = "root";
		$password = "root";
		$database = "ImanchaOS";
	
		mysql_connect($host, $username, $password) or die(mysql_error());
		mysql_select_db($database);
	}
	
	function usermenu(){
		mysql_open();
		
		$sql = "SELECT * FROM message WHERE receiver_message='".$_SESSION['username']."' AND status_message='sent' ORDER BY date_message DESC";
		$res = mysql_query($sql) or die(mysql_error());		
		$num = mysql_num_rows($res);
		
		if($num > 0){
			$message = '<li><ul class="menu">';
			while($row = mysql_fetch_assoc($res)){
				$id = $row['id_message'];				
				$user = $row['user_message'];
				$content = $row['content_message'];
				$date = $row['date_message'];
				
				if(strlen($content) > 30){
					$content = substr($content,0,30) . "...";
				}
				
				$message .= '<li>
											<a href="messages.php?mid='.$id.'#'.$id.'">
												<div class="pull-left"><img src="img/avatar3.png" class="img-circle" alt="User Image"/></div>
												<h4>'.$user.' &nbsp;<span><small><i class="fa fa-clock-o"></i> '.$date.'</small></span></h4>
												<p>'.$content.'</p>
											</a>
										</li>';										
			}
			$message .= '</ul></li>';
		}else{			
			$message = '';
		}
		
		$sql = "SELECT * FROM notification WHERE id_user='".$_SESSION['id']."' AND status_notification='sent' ORDER BY date_notification DESC";
		$res = mysql_query($sql) or die(mysql_error());
		$mun = mysql_num_rows($res);
		
		if($mun > 0){
			$notification = '<li><ul class="menu">';
			while($row = mysql_fetch_array($res)){
				if(strlen($row['content_notification']) > 30) 
					$row['content_notification'] = substr($row['content_notification'],0,30) . "...";
					
				$notification .= '<li>
														<a href="notification.php?nid='.$row['id_notification'].'">						
															<i class="fa fa-warning info"></i> <b>'.$row['user_notification'].'</b> &nbsp;'.$row['content_notification'].'
														</a>
													</li>';
			}
			$notification .= '</ul></li>';
		}else{			
			$notification = '';
		}
		
		mysql_close();
		
		echo '<li class="dropdown messages-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-envelope"></i>
							<span class="label label-success">'.$num.'</span>
						</a>
						<ul class="dropdown-menu">
              <li class="header">You have '.$num.' messages</li>
              '.$message.'
              <li class="footer"><a href="messages.php">See All Messages</a></li>
            </ul>
          </li>
          
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-warning"></i>
              <span class="label label-warning">'.$mun.'</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have '.$mun.' notifications</li>
              '.$notification.'
              <li class="footer"><a href="notification.php">View all</a></li>
            </ul>
          </li>        

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="glyphicon glyphicon-user"></i>
              <span>'.$_SESSION['username'].' &nbsp;<i class="caret"></i></span>
            </a>
            <ul class="dropdown-menu">      
              <li class="user-header bg-light-blue">
                <img src="img/avatar3.png" class="img-circle" alt="User Image" />
                <p>'.$_SESSION['name'].'<small>Member since &nbsp;'.tanggal($_SESSION['date']).'</small></p>
              </li>
              <li class="user-body">
								<div class="col-xs-12 text-center"><a href="lockscreen.php">Lockscreen</a></div>
              </li>
              <li class="user-footer">
                <div class="pull-left"><a href="profile.php" class="btn btn-default btn-flat">Profile</a></div> 
                <div class="pull-right"><a href="logout.php" class="btn btn-default btn-flat">Sign out</a></div>
              </li>
            </ul>
          </li>';
	}

	function guestmenu(){    
		echo '<li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="glyphicon glyphicon-user"></i>
              <span>Guest &nbsp;<i class="caret"></i></span>
            </a>
            <ul class="dropdown-menu">      
              <li class="user-header bg-red">
                <img src="img/avatar3.png" class="img-circle" alt="User Image" />
                <p>Anonymous</p>
              </li>
              <li class="user-footer">
                <div class="pull-left"><a href="login.php" class="btn btn-default btn-flat">Sign In</a></div> 
                <div class="pull-right"><a href="register.php" class="btn btn-default btn-flat">Sign Up</a></div>
              </li>
            </ul>
          </li>';
	}
	
	function topmenu(){						
		if(isset($_SESSION['id'])){
			usermenu();
		}else{
			guestmenu();
		}
	}

	function navigation(){
		echo '<a href="index.php" class="logo">ImanchaOS</a>
          <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button" title="Toggle Navigation">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>
            <div class="navbar-right">
              <ul class="nav navbar-nav">';
                topmenu();
    echo '		</ul>
            </div>
          </nav>';
	}

	function sidebar(){			
		if(isset($_SESSION['id'])){
			if($_SESSION['level'] == "admin")
				$dashboard = "<li><a href='admin.php'><i class='glyphicon glyphicon-eye-open'></i><span>Administrator</span></a></li>";
			$message = "<p>Hello, ".$_SESSION['username']."</p>";
			$dashboard .= "<li><a href='dashboard.php'><i class='fa fa-dashboard'></i><span>Dashboard</span></a></li>";
		}else{
			$message = "<p>Hello, Guest</p>";
			$dashboard = "";
		}	
		
		echo '<section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="img/avatar3.png" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
									'.$message.'
									<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            	</div>

            <ul class="sidebar-menu">'.$dashboard.'';
                
							mysql_open();

							$sql = "SELECT * FROM category ORDER BY name_category ASC";
							$res = mysql_query($sql) or die(mysql_error());

							if(mysql_num_rows($res) > 0){
								while($row = mysql_fetch_assoc($res)){
									$id = $row['id_category'];
									$name = $row['name_category'];                                    

									if(isset($_GET['cid']) && ($_GET['cid'] == $id)){
										$active = "active";
										$icon = "glyphicon-folder-open";
									}else{
										$active = "";
										$icon = "glyphicon-folder-close";
									}
									
									echo '<li class='.$active.'>
													<a href="category.php?cid='.$id.'&title='.$name.'">
														<i class="glyphicon '.$icon.'"></i>
														<span>'.$name.'</span>
													</a>
												</li>';                                    
								}
							}   
							mysql_close();                
          
    echo '	</ul>
      		</section>';
	}

  function modal(){
    echo "<div class='modal fade' id='login-modal' tabindex='-1' role='dialog' aria-hidden='true'>
            <div class='modal-dialog'>
              <div class='modal-content'>
                <div class='modal-header'>               
                  <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>   
                  <h4 class='modal-title'><i class='fa fa-warning'></i> Sign In Required</h4>
                </div>                
                <div class='modal-body'>
                  Please Sign In or Sign Up <span class='text-muted'>if you don't have account yet</span> to process your request.
                </div>                
                <div class='modal-footer clearfix'>                  
                  <button class='btn btn-success pull-left' onClick=\"window.location='login.php'\"><i class='fa fa-sign-in'></i>&nbsp; Sign In</button>
                  <button class='btn btn-warning pull-right' onClick=\"window.location='register.php'\"><i class='fa fa-user'></i>&nbsp; Sign Up</button>
              </div>
              </div>              
            </div>
          </div>";
  }

	function tanggal($date){
		$Bulan = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		
		$tahun = substr($date, 0, 4);
		$bulan = substr($date, 5, 2);
		$tgl   = substr($date, 8, 2);

		$result = $tgl . " " . $Bulan[(int)$bulan-1] . " ". $tahun;		
		return($result);
	}
?>
