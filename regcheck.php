<?php
ob_start();
session_start();

error_reporting(E_ALL);
ini_set('display_errors', '1');
// some error checking
if(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['password']) ) {
	$return_url 	= base64_decode($_POST["return_url"]);
	if(strlen($_POST['password']) < 6) {	
	echo '<div class="password_error">Password must be at least 6 characters</div>';
	} 
	//FILTER_VALIDATE_EMAIL filter validates value as an e-mail address. Since we validate from html so we dont need this code
	/*elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))	
	include('header.inc');
	echo "Email must be valid.";
	include('footer.inc');
	}*/
  	else {
		require('includes/functions.php');
		$conn = dbConnect('query');	
		$user_fname = $conn->real_escape_string($_POST['fname']);
		$user_lname = $conn->real_escape_string($_POST['lname']);
		$user_email = $conn->real_escape_string($_POST['email']);
		$user_password = $conn->real_escape_string(md5($_POST['password']));//md5 encrypt password
		
		//echo "$user_fname $user_lname $user_email $user_password"."<br/>";
		
		
		//check if user already register. if not insert info into database
		$query = $conn->query("SELECT email FROM customer WHERE email = '". $user_email ."'"); // note the way $user_email in the query exactly the same
		
		$result = $query->num_rows;
		
		if( $result > 0 ) {// if there is no duplicate
			header('Location:'.$return_url);
			echo "You have already register";		
		}
		else {	//if there is duplicate	
			//$conn = dbConnect('query');
			$values = "INSERT INTO customer (customer_fname, customer_lname, email, password) VALUES ('$user_fname', '$user_lname', '$user_email', '$user_password')";
			//echo $values;
			$insert = $conn->query($values) or die('insert failed to execute');
			
			if($insert) {
				$loggedin = array('loggedinemail'=>$user_email, 'loggedinfname'=>$user_fname, 'loggedinlname'=>$user_lname,'loggedinpass'=>$user_password);
				if($insert) {				
					$_SESSION['loggedin'] = $loggedin;
					header('location:'.$return_url);
				}
			}
		}
	}	
}	
?>