<?php

error_reporting(0);
//This will start a session
ob_start();
session_start();

//Check do we have username and password

if(isset($_SESSION['loggedin'])){
	$fname = $_SESSION['loggedin']['loggedinfname'];
	echo "Welcome ".$fname." (<a href=logout.php>Logout</a>)";
} else {
	$current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	?>
<!-- Panel -->
<div id="toppanel">
	<div id="panel">
		<div class="content clearfix">

			<div class="left">
				<!-- Login Form -->
				<form class="clearfix" action="login.php" method="post">
					<h1>Login</h1>
					<label class="grey" for="email">Email:</label>
					<input class="field" type="text" name="email" id="email" value="" size="23" />
					<label class="grey" for="password">Password:</label>
					<input class="field" type="password" name="password" id="password" size="23" />
	            	<!--<label id="rememberme">Remember me</label>
                    <input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" />
        			<div class="clear"></div>-->
					<input type="submit" name="login" value="Login" class="bt_login" />
                    <input type="hidden" name="return_url" value="<?php echo $current_url; ?>" />
					<!--<a class="lost-pwd" href="#">Lost your password?</a>-->
				</form>
			</div>
			<div class="left right">			
				<!-- Register Form -->
				<form action="regcheck.php" method="post">
					<h1>Sign Up!</h1>				
					<label class="grey" for="fname">First Name:</label>
					<input class="field" type="text" name="fname" id="fname" value="" size="23" />
					<label class="grey" for="lname">Last Name:</label>
					<input class="field" type="text" name="lname" id="lname" size="23" />
                    <label class="grey" for="email">Email: </label>
                    <input class="field" type="email" name="email" id="email" required>
                    <label class="grey" for="password">Password: </label>
                    <input class="field" type="password" name="password" id="password" required>                   
					<!--<span>A password will be e-mailed to you.</span>-->
					<input type="submit" name="submit" value="Register" class="bt_register" />
                    <input type="hidden" name="return_url" value="<?php echo $current_url; ?>" />
                    
				</form>
			</div>
		</div>
</div> <!-- /login -->	

	<!-- The tab on top -->	
	<div class="tab">
		<ul class="login">
			
			<li>Hello Guest!</li>
			
			<li id="toggle">
				<a id="open" class="open" href="#">Log In | Register</a>
				<a id="close" style="display: none;" class="close" href="#">Close Panel</a>			
			</li>
			
		</ul> 
	</div> <!-- / top -->
	
</div> <!--panel -->

    
    <?php
}
	include('header.inc');
?>





