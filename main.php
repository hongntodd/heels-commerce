<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	if(!isset($_SESSION['loggedin'])) {//sop if user not logged in
		die('Please Log in to view this page');// or use header() to redirect users
	} 
	
	elseif(isset($_SESSION['loggedin']) && ($_SESSION['adminuser'] == 0)) {
		include('header.inc');
		echo " You are logged in as: {$_SESSION['loggedinemail']} - MEMBER<br /><br />\n";
		echo "<p>Welcome {$_SESSION['loggedinfname']} !<a href=\"edit_member.php\">[Edit]</a></p>";
		echo "<p>User: {$_SESSION['loggedinuser']}</p>";
		echo "<p><a href=\"logout.php\">Logout</a></p>";
		include('footer.inc');
		
	}
	
	elseif(isset($_SESSION['loggedin']) && ($_SESSION['adminuser'] == 1)) {
		include('header.inc');
		echo " You are logged in as: {$_SESSION['loggedinemail']} - ADMIN<br /><br />\n";
		echo "<p>Welcome {$_SESSION['loggedinfname']}!<a href=\"admin_page.php\">[Edit]</a></p>";
		echo "User: {$_SESSION['loggedinuser']}";
		echo "<p><a href=\"logout.php\">Logout</a></p>";
		include('footer.inc');
		
	}
	
	
?>