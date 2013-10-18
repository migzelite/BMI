<?php

include 'connect.php';

//include 'config.php';
  
/* $conRole =new mysqli($server ,$user,$pass,$db_name);
 if ($con->connect_errno) {
 	echo "Failed to connect to MySQL: (" . $con->connect_errno . ") " . $con->connect_error;
 }
 $sqlRole = "SELECT ur.role_id FROM user_role ur 
 			Inner Join users u on u.user_id = ur.user_id
 			where username= ". $_SESSION['username'];
 while ($row = $resUser->fetch())
 {
 	$row['role_id'];
 }
 
 $_SESSION['role_id'] = $row['role_id'];
 $conRole->close(); */
 //$_SESSION['role_id']=2;
//$_SESSION['role_id']= $_SESSION['role_id'];
Session_start();
//echo $SESSION['role_id'];
if(isset($_SESSION['role_id']))
{
	
	
	$con = new mysqli($server ,$user,$pass,$db_name);
	if ($con->connect_errno) {
		echo "Failed to connect to MySQL: (" . $con->connect_errno . ") " . $con->connect_error;
	}
	
			$sql ="SELECT p.page_id, p.menu_label,p.parentid,p.subMenuWidth,p.url FROM page p
					INNER JOIN page_perm pp ON pp.page_id = p.page_id
					INNER JOIN permissions pms ON pms.perm_id = pp.perm_id
					INNER JOIN role_perm rp ON rp.perm_id = pms.perm_id
					INNER JOIN roles r ON r.role_id = rp.role_id
					INNER JOIN users u on u.user_id = rp.user_id
					WHERE r.role_id = " . $_SESSION['role_id']." AND u.username = '".trim($_SESSION['username'])."'";	
			$res = $con->query($sql) or die("SQL Error 5: " . mysqli_error($con));
			
			while ($row = mysqli_fetch_array($res,MYSQLI_ASSOC))
			 {
				 $result[] = array(
				  'id'=>$row['page_id'],
				  'parentid'=>$row['parentid'],	
        		  'text'=>$row['menu_label'],
				  'subMenuWidth'=>$row['subMenuWidth'],
				  'href'=>$row['url']);
			 }
			  
			
		//var_dump($result);
		header("Content-type: application/json");
		echo json_encode($result,JSON_PRETTY_PRINT);
		$error = json_last_error();
	
		//$con->close();
	
	}
	//else
	//{
	//	header("location: MainMenu.php");
	//}

?>