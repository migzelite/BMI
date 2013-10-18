<?php 
include 'connect.php';

$con = new mysqli($server ,$user,$pass,$db_name);
	if ($con->connect_errno) {
		echo "Failed to connect to MySQL: (" . $con->connect_errno . ") " . $con->connect_error;
	}
$query = "SELECT u.user_id, u.username,u.firstname, u.lastname, u.email, r.role_name, p.perm_desc FROM users u
			INNER JOIN user_role ur on ur.user_id = u.user_id
			INNER JOIN roles r on r.role_id = ur.role_id
			Inner join role_perm rp on rp.user_id = u.user_id
			inner join permissions p on p.perm_id = rp.perm_id";
				
	
$res = $con->query($query) or die("SQL Error 5: " . mysqli_error($con));
			
			while ($row = mysqli_fetch_array($res,MYSQLI_ASSOC))
			 {
				 $result[] = array(
				  'user_id'=>$row['user_id'],
				  'username'=>$row['username'],	
        		  'firstname'=>$row['firstname'],
				  'lastname'=>$row['lastname'],
				  'email'=>$row['email'],
				  'role_name'=>$row['role_name'],
				  'descriptions'=>$row['perm_desc']);
			 }
			  
			
	//var_dump($result);
		header("Content-type: application/json");
		echo json_encode($result,JSON_PRETTY_PRINT);
		$error = json_last_error();

?>