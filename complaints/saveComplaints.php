<?php
include 'conn.php';

$con = new mysqli($server,$user,$pass,$db_name);
if ($con->connect_errno) {
	echo "Failed to connect to MySQL1: (" . $con2->connect_errno . ") " . $con2->connect_error;
}
$con2 = new mysqli("184.82.109.218", "major", "Above@ll", "the_oracle");

if ($con2->connect_errno) {
	echo "Failed to connect to MySQL2: (" . $con2->connect_errno . ") " . $con2->connect_error;
}
$user="";
$passw="";
$firstname="";
$lastname="";
$email="";
if(isset($_REQUEST['emails']))
{
	$emails= $_REQUEST['emails'];
	$email[] = explode("\n",$emails);
	//var_dump($emails);
	//var_dump($email);
}
if(isset($_REQUEST['compType']))
{
	$compType =$_REQUEST['compType'];
	//var_dump($compType);
}

foreach($email as $key => $values)
{
			foreach($values as $value)
			{
			//$con2  = new mysqli("184.82.109.218:22","major","Above@ll","the_oracle")
			$value = trim($value);	
			$query = "INSERT IGNORE INTO `suppression` (email_address,reason) VALUES ('".$value."','".$compType."')";
			//var_dump($query);
			$res =$con->real_query($query);
			if (!$res)
			{
				$message  = 'Invalid query1: ' . mysqli_error($con) . "\n";
				$message .= 'Whole query: ' . $query;
				die("Error  <br />email already inserted".mysqli_error($con));
			}
			$query2 = "INSERT IGNORE INTO `log_spamtraps` (email) VALUES ('".$value."')";
			//var_dump($query2);	
			$res2 =$con2->real_query($query2);
				if (!$res2)
 	        	{	
 					$message  = 'Invalid query2: ' . mysqli_error($con) . "\n";
	    			$message .= 'Whole query: ' . $query;
	    			die("Error  <br />email already inserted".mysqli_error($con2));
				}
				
			$url = 'http://206.71.166.232/livefeed/index.php?email='.$value.'&list_id=65';
			//var_dump($url);
			$html = file_get_contents($url);
		//	var_dump($html);
						
			}
		
}

$con->close();
$con2->close();
//otherDB($email);
//echo ("<SCRIPT LANGUAGE='JavaScript'>
//    window.alert('Succesfully Updated');
//    </SCRIPT>");

	
header("Location: complaints.php");
exit;
?>
