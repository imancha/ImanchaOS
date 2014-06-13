<?php include_once('function.inc');
	$errno = FALSE;
	
	if(isset($_GET['f']) && is_numeric($_GET['f'])){
		$user = $_GET['f'];
		
		if($user > 0){
			mysql_open();
	
			$sql = "INSERT INTO follow VALUE (null,'$user','".$_SESSION['id']."',now())";
			$res = mysql_query($sql) or die(mysql_error());
			
			if($res){
				header('Location: '.$_SERVER['HTTP_REFERER']);
				exit();
			}
	
			mysql_close();
		}else{
			$errno = TRUE;
		}
	}else{
		$errno = TRUE;
	}
	
	if($errno){
		header('Location: errno.php');
		exit();
	}
?>
