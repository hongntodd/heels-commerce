<?php
	session_cache_limiter('private_no_expire'); ////same as calling ini_set('session.cache_limiter','private')
	session_start();
	date_default_timezone_set('America/Los_Angeles');
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	require('includes/functions.php');
	$con = dbConnect('query');
	if(isset($_POST['login'])) {
		loginUser($con);
	} else {
		include('header.inc');	
?>

    
<?php
	include('footer.inc');
}
	function loginUser($con) {			
		$login_email = $con->real_escape_string($_POST['email']);		
		$login_password = $con->real_escape_string(md5($_POST['password']));
		$return_url 	= base64_decode($_POST["return_url"]);
			
		$sql = $con->query("SELECT customer_id, customer_fname, customer_lname, email, password, level FROM customer WHERE email = '" .$login_email. "' AND password = '" .$login_password. "' ");
		$result = $sql->num_rows;	
		if( $result > 0) {
			$row = $sql->fetch_assoc();
			
			if($row) {
				$loggedin = array('loggedinemail'=>$row['email'], 'loggedinfname'=>$row['customer_fname'], 'loggedinlname'=>$row['customer_lname'],'loggedinpass'=>$row['password']);
				$_SESSION['loggedin'] = $loggedin;
				//print_r($_SESSION['loggedin']);
				
				if(isset($_SESSION['loggedin'])) {
					header('location:'.$return_url);	
				}
/*				if($row['level'] == '1') {
					$_SESSION['adminuser'] = 0;
					header('location: main.php');
				} elseif($row['level'] == '9') {
					$_SESSION['adminuser'] = 1;
					header('location:'. $current_url);
				}			
*/			} 
			
			$sql->free_result();
		} else {
			echo 'Wrong email or password';
				
		}
		dbClose($con);
		
	}	
?>