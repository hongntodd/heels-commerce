<?php
ob_start();
session_start();
include("includes/functions.php");
if(isset($_POST['reg'])) {
if(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['password']) ) {
	$return_url 	= base64_decode($_POST["return_url"]);
	if(strlen($_POST['password']) < 6) {	
		echo '<div class="password_error">Password must be at least 6 characters</div>';
	include('register.php');
	} elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		include('header.inc');
		echo "Email must be valid.";
		include('footer.inc');
	} else {
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
		}
		else {	//if there is duplicate	
			//$conn = dbConnect('query');
			$values = "INSERT INTO customer (customer_fname, customer_lname, email, password) VALUES ('$user_fname', '$user_lname', '$user_email', '$user_password')";
			//echo $values;
			$insert = $conn->query($values) or die('insert failed to execute');
			$loggedin = array('loggedinemail'=>$user_email, 'loggedinfname'=>$user_fname, 'loggedinlname'=>$user_lname,'loggedinpass'=>$user_password);
			if($insert) {				
				$_SESSION['loggedin'] = $loggedin;
				//print_r($_SESSION['loggedin']);	
				//echo 'session is set';			
			}
			//echo $insert; //check if insert	
			//echo "Please <a href='login.php'>Login</a>";			
		}
	}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>GOT HEELS <?php  //echo $sectionName; ?></title>
<link href="heels_style.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/search.js"></script>

<script>
$(document).ready(function() {
	
	// Expand Panel
	$("#open").click(function(){
		$("div#panel").slideDown("slow");
	
	});	
	
	// Collapse Panel
	$("#close").click(function(){
		$("div#panel").slideUp("slow");	
	});		
	
	// Switch buttons from "Log In | Register" to "Close Panel" on click
	$("#toggle a").click(function () {
		$("#toggle a").toggle();
	});
	
	$('#cart_slide').click(function () {        
		$('#cart_slide_down').slideToggle(500);			
	});	
		
});
</script>

<!--[if IE 5]>
<style type="text/css"> 
/* IE 5 does not use the standard box model, so the column widths are overidden to render the page correctly. */
#outerWrapper #contentWrapper #navBar {
  width: 180px;
}
#outerWrapper #contentWrapper #rightColumn1 {
  width: 220px;
}
</style>
<![endif]-->
<!--[if IE]>
<style type="text/css"> 
/* The proprietary zoom property gives IE the hasLayout property which addresses several bugs. */
#outerWrapper #contentWrapper, #outerWrapper #contentWrapper #content {
  zoom: 1;
}
</style>
<![endif]-->
<!--[if lt IE 7]>
<style type="text/css"> 
img, div {
  behavior: url("images/iepngfix.htc");
}
</style>
<![endif]-->

</head>

<body>

<div id="outerWrapper">
    <div id="loginNav">
    	<?php include("includes/loginnav.php"); ?>
    </div>
    <div class="header_bg">
    <div id="header" class="clearfix">
    	<div class="pagelogo">
            <a href="index.php"><div class="logo"></div></a>
            
        </div>
        <div class="promotion">
            FREE SHIPPING AND FREE RETURN <br />
            <div id="search_form">

			<form>                
                <div class="input_container">
                    <input type="text" id="item_search_id" onkeyup="autocomplet()" placeholder="Search..">
                    <ul id="item_list_id"></ul>
                </div>
                <!--<input type="submit" value="Search" name="search" />-->
            </form>
                
            </div>
        </div>
        <div id="navBar">
            <?php include("includes/navbar.php"); ?>
        </div>
    </div>
    </div>
        
    <div id="contentWrapper">        
        <div id="navigation">
			<?php include("includes/nav.php"); ?>
        </div>
        
        <div id="content">
           	<h2 class="alert"><strong> This is a demo website. Please do not put in your Real Credit Card information!</strong></h2>
 			
            <?php echo $message; ?>
            <!-- Login navifation : only display if user not logged in-->
            <div class="loginpage">
				<?php			
                $current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                if(isset($_SESSION['loggedin'])){
                    
                } else {
                    ?>
                        <div id="login_section" class="cf">
                            <div id="login_form">
                                <form action = "login.php" method ="POST" id="loginform">
                                <h3>Login </h3>
                                    <div class="login">
                                        <label for="email">Email: </label>
                                        <input type="email" name="email" id="email" required>
                                    </div>
                                    
                                    <div class="login">
                                        <label for="password">Password: </label>
                                        <input type="password" name="password" id="password" required>
                                    </div>
                                    <div class="login">
                                        <input type="submit" name="login" value="Login">
                                        <input type="hidden" name="return_url" value="<?php echo $current_url; ?>" />
                                    </div>
                                </form>
                            </div>
                            
                            <div id="register_form">
                                <form method="POST" action="checkout.php" id="registerform">
                                <h3>Register</h3>
                                    <div class="reg">
                                        <label for="fname">First Name: </label>
                                        <input type="text" name="fname" id="fname" required>
                                    </div>
                                    
                                    <div class="reg">
                                        <label for="lname">Last Name: </label>
                                        <input type="text" name="lname" id="lname" required>
                                    </div>
                                    
                                    <div class="reg">
                                        <label for="email">Email: </label>
                                        <input type="email" name="email" id="email" required>
                                    </div>  
                                      
                                    <div class="reg">
                                        <label for="password">Password: </label>
                                        <input type="password" name="password" id="password" required>
                                    </div>
                                    
                                    <div class="reg">    	
                                        <input type="submit" name="reg" id="registernow" value="Register">
                                        <input type="hidden" name="return_url" value="<?php echo $current_url; ?>" />
                                    </div>     
                                </form>
                            </div>	
                        </div>
                <?php
                }
                ?>            
            </div>
            
            <!-- Shopping cart display, view cart -->			
            <div id="checkout_info"> 
                    <h2>Your Shopping Cart</h2>    
                    <form name="checkout" id="checkout" method="post" action="paypal/process.php">
                    	<div id="cart_paypal">      
                            <div class="cart">                         
                                <?php
                                if(isset($_SESSION["products"]))
                                {
                                    $total = 0;
                                    echo '<form method="post" action="paypal-checkout/process.php">';
                                    echo '<ol>';
									$cart_items = 0;
                                    foreach ($_SESSION["products"] as $cart_itm)
                                    {
                                        echo '<li class="cart-itm">';
                                       
                                        echo '<div class="cart-item-image"><img src="images/'.$cart_itm["thumb"].'" alt=""/></div>';
                                        echo '<div class="cart-item-content">';
                                            echo '<h3>'.$cart_itm["name"].'</h3>';
                                            echo '<div class="cart-item-box">';
                                                echo '<p>Size : '.$cart_itm["size"].'<br>';
                                                echo 'Qty : '.$cart_itm["qty"].'</p>';			
                                            
                                        echo '<div class="remove-itm"><a href="cart_update.php?removep='.$cart_itm["size"].'&item='.$cart_itm["name"].'&return_url='.$current_url.'">&times;<br><span>Remove</span></a></div>';
                                        echo '<div class="p-price">$'.$currency.$cart_itm["price"].'</div>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</li>';
                                        $subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
                                        $total = ($total + $subtotal);
										echo '<input type="hidden" name="item_price['.$cart_items.']" value="'.$cart_itm["price"].'" />';	
										echo '<input type="hidden" name="item_name['.$cart_items.']" value="'.$cart_itm["name"].'" />';
										echo '<input type="hidden" name="item_id['.$cart_items.']" value="'.$cart_itm["product_id"].'" />';
										echo '<input type="hidden" name="item_thumb['.$cart_items.']" value="'.$cart_itm["thumb"].'" />';									
										echo '<input type="hidden" name="item_size['.$cart_items.']" value="'.$cart_itm["size"].'" />';
										echo '<input type="hidden" name="item_qty['.$cart_items.']" value="'.$cart_itm["qty"].'" />';									
										$cart_items ++;
                                    }
                                    echo '</ol>';
                                    echo '<strong>Total : $'.$currency.$total.'</strong>';
                                    echo '<span class="check-out-txt"> <a href="view_cart.php">Edit</a></span>';
                                    echo '<span class="empty-cart"><a href="cart_update.php?emptycart=1&return_url='.$current_url.'">Empty Cart</a></span>';
									
									

                                }else{
                                    echo 'Your Cart is empty';
                                }
                                ?>
                            </div> <!-- end shopping-cart -->
            		       

                                    
                            <div id="checkout_paypal">
                                <input name="goToCheckout" id="goToCheckout" type="submit" value="Pay with Paypal" />
                            </div>
						</div>
                        <div id="checkout_card">
                        	<h3>Checkout with Card</h3>		
                            <p><strong>Fill in name and shipping information:</strong></p>
                            <label>First Name: </label><input name="firstname" type="text" value="<?php echo $_SESSION['loggedin']['loggedinfname']; ?>" size="20" /><br />
                            <label>Last Name: </label><input name="lastname" type="text" value="<?php echo $_SESSION['loggedin']['loggedinlname']; ?>" size="20" /><br />
                            <label>Street: </label><input name="street" type="text" value="<?php echo $_SESSION['loggedin']['loggedinstreet']; ?>" size="40" /><br />
                            <label>City: </label><input name="city" type="text" value="<?php echo $_SESSION['loggedin']['loggedincity']; ?>" size="40" /><br />
                            <label>State: </label><input name="state" type="text" value="<?php echo $_SESSION['loggedin']['loggedinstate']; ?>" size="2" /><br />
                            <label>Zip: </label><input name="zip" type="text" value="" size="10" /><br />
                        
                
                            <p><strong>Payment Details:</strong></p>
                            <label>Name on Card:</label><input name="cardname" type="text" value="" size="30" /><br />
                            <label>Card Type:</label><select name="card_type" size="1">
                                                <option value="visa">Visa</option>
                                                <option value="mc">MasterCard</option>
                                                <option value="amex">American Express</option>
                                              </select><br />
                            <label>Number:</label><input name="cardnumber" type="text" value="1234567890123456" size="24" disabled/><br />
                            <label>Security Code:</label><input name="security" type="text" value="123" size="3" disabled/><br />
                            <label>Expiration:</label><select name="exp_mo" size="1">
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                              </select>
                                              <select name="exp_yr" size="1">
                                                <option value="2010">2010</option>
                                                <option value="2011">2011</option>
                                                <option value="2012">2012</option>
                                                <option value="2013">2013</option>
                                                <option value="2014">2014</option>
                                                <option value="2015">2015</option>
                                              </select><br />
                                          
                      
                            <input name="checkout" id="finish_checkout" type="submit" value="Pay with Card" />
                        </div> 
                   </form>
			</div>
            

        
    
            <div id="footer">
                <?php include("includes/footer.php"); ?>
            </div>
		</div>
	</div>
</div>

</body>
</html>