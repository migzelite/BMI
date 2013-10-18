<?php

class clsXmlRpcRequestDel{
  private $username ="admin";
  private $password="YWKQM321";
  private $server ="http://184.82.109.18/xapi/server.php";
 
 /*function __construct($username,$password,$server)
 {
  $this->username=$username;
  $this->password=$password;
  $this->server=$server;
 }
 */
function XmlRpcRequest($request)
 
  {             
       //Create the auth string for the server..
       $auth = base64_encode($this->username.":".$this->password);
 		//var_dump($auth); 
       //Create the header to send wit hthe request.
       $header = (version_compare(phpversion(), '5.2.8')) ?
                  array("Content-Type: text/xml","Authorization: Basic $auth") :
                  "Content-Type: text/xml\r\nAuthorization: Basic $auth" ;
		//var_dump($header);			
       //Create the stream context.
       $context = stream_context_create(array('http' =>  array(
                           'method' =>  "POST",
                           'header' => $header,
         				   'user_id'=> 1,
                           'content' => $request)));
       
  
 				//var_dump($context);
              //Get the contents of the response.
              $file = file_get_contents($this->server, false, $context);
  				//var_dump($file);
              //Decode the response.
             $response = xmlrpc_decode($file);
 				//var_dump($response);
				//Return it.
               return $response;
  }
  function multiexplode ($delimiters,$string) {
    
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}
  
  
  function Sqlconnection($info)
{
	include_once 'connect.php';
	$con=mysqli_connect($server,$user,$pass,$db_name);
	if (mysqli_connect_errno($con))
	{
		echo "failed to connect to MySql: " . mysqli_connect_error();
	}
	else {
		//first level dtermine key1 either finished or delivered	
		//if (array_search('-',$info,true)!==false)
		//
		//var_dump($info);
		foreach($info as $key1 =>$val1)
		{
			
			$status = NULL;
			 if ($key1 == "delivering")$status = "delivering"; 
			 else if ($key1 == "finished")$status = "finished";
			// second key access the arrays	
			foreach($val1 as $key2 => $val2)
				  {
					// var_dump($val1);
					 $arr = array($key1,$val2);
					 //var_dump($arr);
					 //third key acces3rd level array that holds fields and values
				  	 foreach($val2 as $key3 =>$val3)
				  		{
							unset($values);
						//	var_dump($val2);
							//key 4 holds fields names, val 4 holds field values
							foreach($val3 as $key4 => $val4)
							{
								// assign values to array
							//	var_dump($val3);
								$values[] =  $con->real_escape_string($val4);
								//joins values to list 
								$value_list = join(', ', $values);	
								// splits campign info into campaign id and campaign name
								// grab message id to check if record exist 
							
								if ($key4=='campaign')
								{
									
									unset ($campaign);
									
									if (strpos($val4, "-")!== false)
									{
										$campaign = 1;
										$arr2=$this->multiexplode(array("-",),$val4);
										
										if (count($arr2) >= 2)
										{
											$i = 2;
											unset($arr2[$i]);
											$i++;	
										}
											if (array_key_exists(1,$arr2))
											{//var_dump($arr2);									{
											$arr2_list = join("','",$arr2);
											}
											else 
											{
												 $arr2[1] = NULL;
												$arr2_list = join("','",$arr2);
										//var_dump($arr2_list);
											}
									}
								}
							}
								//assign fields to array
								//$fields1[] = "$key4";
								// makes sure the fields are unique with in array (same fields for all iterations
								//$fields =array_unique($fields1);
								//join array fields 
								//$field_list = join(',', $fields);
								
								// check if record exist 
									//$chksql = "SELECT `message_id` FROM volomp where `message_id' = '$msgID'";
									//$cksql =mysqli_query($con,$chksql);
									//var_dump($cksql);
									if($status != NULL && $campaign =1)
										{
											$values[1] = date('Y-m-d H:i:s', strtotime($values[1]));
											
											$query = "INSERT INTO `volomp` ( message_id,Start,campaign,queued,processed,delivered,bounced,open_percent,open,clicks,clicks_percent,campaign_id,campaign_name,status) VALUES ('" . $values[0] . "', '" .$values[1].  "', '".$values[2] . "', '" . $values[3] . "', '" . $values[4] . "', '" . $values[5] . "', '" . $values[6] . "', '" . $values[7] . "', '" . $values[8] . "', '" . $values[9] . "', '" . $values[10]."','".$arr2_list."', '" . $status ."') on duplicate key UPDATE  status = '$status', Start='$values[1]', queued='$values[3]',processed='$values[4]',delivered='$values[5]',bounced='$values[6]',open_percent='$values[7]',open='$values[8]',clicks='$values[9]',clicks_percent='$values[10]'" ;
											//$query2 =  implode(',',$arr2);	
								
											//dumps query for viewing
											//var_dump($query);
											//var_dump($query2);
											//send query to db 
											$result = mysqli_query($con,$query);
											//$result2 = mysqli_query($con,$query2);
											//var_dump($query);
											if (!$result )//|| !$result2
						 					{
   												$message  = 'Invalid query: ' . mysqli_error($con) . "\n";
    											$message .= 'Whole query: ' . $query;
						    					die($message);	
			  			 					}
										}
			  			 				}
								}
						}
				  				
					}
						
						
				
				mysqli_close($con);
			}
			
			
			
		}
	
$client = new  clsXmlRpcRequestDel;
$request = xmlrpc_encode_request("delivery_queue",array("user_id"=>1, 'fields'=>array('MsgID','Start','Campaign','Queued','Processed','Delivered','Bounced','Opnd','Opened','Clicks','ClickPerc')));
$res =$client ->XmlRpcRequest($request);
$client -> Sqlconnection($res);
?>