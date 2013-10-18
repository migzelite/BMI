<?php 
include 'conn.php';

$con = new mysqli($server ,$user,$pass,$db_name);
	if ($con->connect_errno) {
		echo "Failed to connect to MySQL: (" . $con->connect_errno . ") " . $con->connect_error;
	}
$query = "SELECT * FROM suppression";
				
	
$res = $con->query($query) or die("SQL Error 6: " . mysqli_error($con));
			
			while ($row = mysqli_fetch_array($res,MYSQLI_ASSOC))
			 {
				 $result[] = array(
				  'id'=>$row['suppression_id'],
				  'email'=>$row['email_address'],
				  'reason'=>$row['reason']);
			 }
			  
			
	//var_dump($result);
		header("Content-type: application/json");
		echo json_encode($result,JSON_PRETTY_PRINT);
		$error = json_last_error();

?>