<?php 
ob_start();
session_start();
	include("includes/functions.php");


if (array_key_exists('goToCheckout', $_POST)) {
		//redirect to checkout page
		header("Location: checkout.php");
} elseif (array_key_exists('update', $_POST)) {
		$cart_count = count($_SESSION['products']);
		//print_r($_SESSION['products']);
		
		
		//LOOP THROUGH CART ELEMENTS
		for ($row = 0; $row < $cart_count; $row++) { 		   
			//echo "Looping through the update for loop: " . $row . "</br>"; //for troubleshooting
		   //setting the product id and type id for use in if conditional
		   //Need both product and type id to get a true match on item - think about this
		   //like it's a composite primary key
		   
		   
		   //set quantity variables for use in if/elseif conditionals
			$origQty = $_SESSION['products'][$row]['qty']; //the original qty in form/session	   
			$updateQty = filter_var($_POST["update_qty"][$row], FILTER_SANITIZE_NUMBER_INT); //the new updated qty that came from POST
			//echo "Orig qty is: " . $origQty . "</br>";
			//echo "Update qty is: " . $updateQty . "</br>";
			//$updateName = $_POST["update_name"][$row];
			//$updateSize = filter_var($_POST["update_size"][$row], FILTER_SANITIZE_NUMBER_INT);
			//$updatePrice = filter_var($_POST["update_price"][$row], FILTER_SANITIZE_NUMBER_INT);
			//$updateId = filter_var($_POST["update_id"][$row], FILTER_SANITIZE_NUMBER_INT);
			   
			if ($updateQty != $origQty ){ 
				//unset old quantity AND other elements ON SESSION
				
				unset($_SESSION['products'][$row]['qty']);
				
				  
				//REST the elements to the new udpated values
				//NOTE THE PRODUCT ID COMES FIRST.  NEED this order to match the array key order in the
				//Add to cart script!	
						  
				$_SESSION['products'][$row]['qty'] = $updateQty;
				
								   
				  //for troubleshooting
				 // echo "Update prod id is: " . $updateId . "</br>";
				// echo "Update prod is: " . $updateName . "</br>";
				// echo "Update qty is: " . $updateQty . "</br>";
				// echo "Update price is: " . $updatePrice . "</br>";
				// echo "New session qty after changing the session is: " . $_SESSION['products'][$row]['qty']. "</br>";
				//echo "<hr>";
						
		   } else { 
				  //the original quantity is the same as what came through on update, so do nothing
				  //for troubleshooting
				  $qty = filter_var($_POST["update_qty"][$row], FILTER_SANITIZE_NUMBER_INT); //the new updated qty that came from POST
				  $_SESSION['products'][$row]['qty'] = $qty;
					//echo "<hr>";
		   }//end if-elseif-else for updating quantities
				   	
		}
}//END FOR LOOP through cart items 
		


		


		
	
	//get the current url to show process on the same page
	$current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>GOT HEELS <?php  //echo $sectionName; ?></title>
<link href="heels_style.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

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
       
        


<!-- Shopping cart display, view cart -->
<div class="view-cart">
<h2>View Shopping Cart</h2>
<form name="view_cart" id="view_cart" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <table id="view_cart">
    <tr>
        <th><strong>Image</strong></th>
        <th><strong>Product</strong></th>
        <th><strong>Size</strong></th>
        <th><strong>Price Each</strong></th>
        <th><strong>Quantity</strong></th>               
        <th><strong>Subtotal</strong></th>
        <th><strong>Delete?</strong></th>
     </tr>
    
    <?php 
$cart_count = count($_SESSION['products']); 
		//echo '$cart_count:'.$cart_count;
		$grandTotal = 0;
		$totalItems = 0;
		if (isset($_SESSION['products']) && $cart_count >0) {
			$cart_count = count($_SESSION['products']); 
			//print_r($_SESSION['products']);//for troubleshooting
			
			
			
			//loop through all the cart elements and display
			foreach ($_SESSION["products"] as $cart_itm) {
						  
				//create variables
				$product_id = $cart_itm["product_id"];
				$name = $cart_itm["name"];
				$size = $cart_itm["size"];
				$price = $cart_itm["price"];
				$qty = $cart_itm["qty"];
				$thumb = $cart_itm["thumb"];						
				$totalPriceEach = ($qty * $price);
			  
			  
			  
			  //DISPLAY PRODUCT INFORMATION IN OUR CART DISPLAY
			  //write out the information for this product/type in our table
			  
			  echo "<tr>";	
			  	  echo '<input type="hidden" name="update_id[]" value="'.$product_id.'">';			  
				  echo '<td><img src="images/'.$thumb.'" alt=""/></td>';
				  //echo '<input type="hidden" name="bibthumb[]" value="'.ucwords($thumb).'"><br>';	
				  echo "<td>" . ucwords($name) . "</td>";
				  //echo '<input type="hidden" name="update_name[]" value="'.$name.'">';
				  echo "<td>" . ucwords($size) . "</td>";//type
				  //echo '<input type="hidden" name="update_size" value="'.$size.'">';
				  echo "<td>" . number_format($price, 2, '.', ',') . "</td>"; //price each
				  //echo '<input type="hidden" name="update_price" value="'.$price.'">';					  
				  
				  echo '<td><input type="text" name="update_qty[]" size="3" maxlength="3" value="'. $qty . '"/></td>'; //quantity in editable form field

				  echo "<td>" . number_format($totalPriceEach, 2, '.', ',') . "</td>"; //total for each product
				  //remove select
				  
				  echo '<td><a href="cart_update.php?removep='.$cart_itm["size"].'&item='.$cart_itm["name"].'&return_url='.$current_url.'">&times;<br><span>Remove</span></a></td>';				  
			  echo "</tr>";
			  
			  //Now add to the grand total each time through the loop
				$grandTotal = $grandTotal + $totalPriceEach;
				$_SESSION['total_price'] = $grandTotal; //add to the session
			  
				$totalItems = $totalItems + $qty;
				$_SESSION['items'] = $totalItems; //add to session
					  
			}//close for loop
				  
		} elseif ($cart_count == 0) { 
			  
			  //if there is no item in cart, set the total items and grand total price to zero
			  $_SESSION['total_price']=0;
			  $_SESSION['items'] = 0;
							  
			  echo "<tr>";
			  echo "<td colspan=\"7\">You have nothing in your cart yet.</td>";
			  echo "</tr>";			
		} 
		
		//Build summary section of cart display
		echo "<tr>";
		echo "<td colspan=\"6\">Number of Items: </td><td colspan=\"1\">" . $_SESSION['items'];
		echo "</td></tr>";
		echo "<tr>";
		echo "<td colspan=\"6\">Grand total: </td><td colspan=\"1\">$" . number_format($_SESSION['total_price'], 2, '.', ',') . "</td>";
		echo "</tr>";
		?>
		
	   </table>
       <input name="goToCheckout" id="goToCheckout" type="submit" value="Checkout" />
	   <input name="update" id="update" type="submit" value="Update Quantity" />
	   
       <a class="button" href="cart_update.php?emptycart=1&return_url=<?php echo $current_url; ?>">Empty Cart</a>
	   </form>
            
</div>

 </div>              
<!-- Related Products -->		

	
        

  
    
    
    
    <div id="footer">
		<?php include("includes/footer.php"); ?>
    </div>
</div>
</div>

</body>
</html>