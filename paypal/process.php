<?php
session_start();
include_once("../includes/functions.php");
include_once("paypal.class.php");

$paypalmode = ($PayPalMode=='sandbox') ? '.sandbox' : '';

if($_POST) //Post Data received from product list page.
{
	//Other important variables like tax, shipping cost
	$TotalTaxAmount 	= 0;  //2.58 Sum of tax for all items in this order. 
	$HandalingCost 		= 0;  //2.00 Handling cost for this order.
	$InsuranceCost 		= 0;  //1.00 shipping insurance cost for this order.
	$ShippinDiscount 	= -3.00; //Shipping discount for this order. Specify this as negative number.
	$ShippinCost 		= 3.00; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.

	//we need 4 variables from product page Item Name, Item Price, Item Number and Item Quantity.
	//Please Note : People can manipulate hidden field amounts in form,
	//In practical world you must fetch actual price from database using item id. 
	//eg : $ItemPrice = $mysqli->query("SELECT item_price FROM products WHERE id = Product_Number");
	$paypal_data ='';
	$total = 0;
	
    foreach($_POST['item_name'] as $key=>$itmname)
    {
		$mysqli = dbConnect('admin');
        $product_id 	= filter_var($_POST['item_id'][$key], FILTER_SANITIZE_STRING); 
		
		$results = $mysqli->query("SELECT * FROM product WHERE product_id='$product_id' LIMIT 1");
		$obj = $results->fetch_object();
		
        $paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'='.urlencode($_POST['item_name'][$key]);
        $paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.urlencode($_POST['item_id'][$key]);
        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode($_POST['item_price'][$key]);	
		$paypal_data .= '&L_PAYMENTREQUEST_0_SIZE'.$key.'='.urlencode($_POST['item_size'][$key]);	
		$paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'='.urlencode($_POST['item_qty'][$key]);
        
		// item price X quantity
        $subtotal = ($_POST['item_price'][$key]*$_POST['item_qty'][$key]);
		
        //total price
        $total = $total + $subtotal;
		
		//create items for session
		$paypal_product['items'][] = array('itm_name'=>$_POST['item_name'][$key],
											'itm_price'=>$_POST['item_price'][$key],
											'itm_id'=>$_POST['item_id'][$key],
											'itm_size'=>$_POST['item_size'][$key],  
											'itm_qty'=>$_POST['item_qty'][$key]
											);
    }
				
	//Grand total including all tax, insurance, shipping cost and discount
	$GrandTotal = ($total + $TotalTaxAmount + $HandalingCost + $InsuranceCost + $ShippinCost + $ShippinDiscount);
	
								
	$paypal_product['assets'] = array('tax_total'=>$TotalTaxAmount, 
								'handaling_cost'=>$HandalingCost, 
								'insurance_cost'=>$InsuranceCost,
								'shippin_discount'=>$ShippinDiscount,
								'shippin_cost'=>$ShippinCost,
								'grand_total'=>$GrandTotal);
	
	//create session array for later use
	$_SESSION["paypal_products"] = $paypal_product;
	
	//Parameters for SetExpressCheckout, which will be sent to PayPal
	$padata = 	'&METHOD=SetExpressCheckout'.
				'&RETURNURL='.urlencode($PayPalReturnURL ).
				'&CANCELURL='.urlencode($PayPalCancelURL).
				'&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
				$paypal_data.				
				'&NOSHIPPING=0'. //set 1 to hide buyer's shipping address, in-case products that does not require shipping
				'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($total).
				'&PAYMENTREQUEST_0_TAXAMT='.urlencode($TotalTaxAmount).
				'&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($ShippinCost).
				'&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($HandalingCost).
				'&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($ShippinDiscount).
				'&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($InsuranceCost).
				'&PAYMENTREQUEST_0_AMT='.urlencode($GrandTotal).
				'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
				'&LOCALECODE=GB'. //PayPal pages to match the language on your website.
				'&LOGOIMG=http://hongtodd.com/site/gotheels/images/logo_pp.png'. //site logo
				'&CARTBORDERCOLOR=FFFFFF'. //border color of cart
				'&ALLOWNOTE=1';
		
		//We need to execute the "SetExpressCheckOut" method to obtain paypal token
		$paypal= new MyPayPal();
		$httpParsedResponseAr = $paypal->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
		
		//Respond according to message we receive from Paypal
		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
		{
				//Redirect user to PayPal store with Token received.
			 	$paypalurl ='https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
				https://www.paypal.com/cgi-bin/webscr
				header('Location: '.$paypalurl);
		}
		else
		{
			//Show error message
			echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
			echo '<pre>';
			print_r($httpParsedResponseAr);
			echo '</pre>';
		}

}

//Paypal redirects back to this page using ReturnURL, We should receive TOKEN and Payer ID
if(isset($_GET["token"]) && isset($_GET["PayerID"]))
{
	//we will be using these two variables to execute the "DoExpressCheckoutPayment"
	//Note: we haven't received any payment yet.
	
	$token = $_GET["token"];
	$payer_id = $_GET["PayerID"];
	
	//get session variables
	$paypal_product = $_SESSION["paypal_products"];
	$paypal_data = '';
	$total = 0;

    foreach($paypal_product['items'] as $key=>$p_item)
    {		
		$paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'='. urlencode($p_item['itm_qty']);
        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode($p_item['itm_price']);
        $paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'='.urlencode($p_item['itm_name']);
        $paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.urlencode($p_item['itm_id']);
		$paypal_data .= '&L_PAYMENTREQUEST_0_SIZE'.$key.'='.urlencode($p_item['itm_size']);
        
		// item price X quantity
        $subtotal = ($p_item['itm_price']*$p_item['itm_qty']);
		
        //total price
        $total = ($total + $subtotal);
    }

	$padata = 	'&TOKEN='.urlencode($token).
				'&PAYERID='.urlencode($payer_id).
				'&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
				$paypal_data.
				'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($total).
				'&PAYMENTREQUEST_0_TAXAMT='.urlencode($paypal_product['assets']['tax_total']).
				'&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($paypal_product['assets']['shippin_cost']).
				'&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($paypal_product['assets']['handaling_cost']).
				'&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($paypal_product['assets']['shippin_discount']).
				'&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($paypal_product['assets']['insurance_cost']).
				'&PAYMENTREQUEST_0_AMT='.urlencode($paypal_product['assets']['grand_total']).
				'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode);

	//We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
	$paypal= new MyPayPal();
	$httpParsedResponseAr = $paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
	
	//Check if everything went ok..
	if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
	{

			
			
				/*
				//Sometimes Payment are kept pending even when transaction is complete. 
				//hence we need to notify user about it and ask him manually approve the transiction
				*/
				
				if('Completed' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"])
				{
                    unset($_SESSION['products']);
					?>
                    
                    <!DOCTYPE html>
<html>
<head>

<meta charset="utf-8" />
<title>GOT HEELS <?php  //echo $sectionName; ?></title>
<link href="../heels_style.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Lato:700,400,300' rel='stylesheet' type='text/css'>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/search.js"></script>

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
    	<?php include("../includes/loginnav.php"); ?>
    </div>
    <div class="header_bg">
    <div id="header" class="clearfix">
    	<div class="pagelogo">
            <a href="../index.php"><div class="logo"></div></a>
            
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
            <?php include("../includes/navbar.php"); ?>
        </div>
    </div>
    </div>
        
    <div id="contentWrapper">        
        <div id="navigation">
			<?php include("../includes/nav.php"); ?>
        </div>

			<div id="content">
						<div>
							<h2>Success</h2>
							<p>Your Transaction ID : <?php echo urldecode($httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]); ?></p>
							<p>Payment Received! Your Package will be shipped in the next day</p>							
							
						</div>            
           	
            




                     <?php
				}
				elseif('Pending' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"])
				{
					echo '<div style="color:red">Transaction Complete, but payment is still pending! '.
					'You need to manually authorize this payment in your <a target="_new" href="http://www.paypal.com">Paypal Account</a></div>';
				}

				// we can retrive transection details using either GetTransactionDetails or GetExpressCheckoutDetails
				// GetTransactionDetails requires a Transaction ID, and GetExpressCheckoutDetails requires Token returned by SetExpressCheckOut
				$padata = 	'&TOKEN='.urlencode($token);
				$paypal= new MyPayPal();
				$httpParsedResponseAr = $paypal->PPHttpPost('GetExpressCheckoutDetails', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

				if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
				{
					
					//echo '<br /><b>Stuff to store in database :</b><br />';
					
					//echo '<pre>';
					/*
					#### SAVE BUYER INFORMATION IN DATABASE ###					
					//use urldecode() to decode url encoded strings.
					
					$buyerName = urldecode($httpParsedResponseAr["FIRSTNAME"]).' '.urldecode($httpParsedResponseAr["LASTNAME"]);
					$buyerEmail = urldecode($httpParsedResponseAr["EMAIL"]);
					
					//Open a new connection to the MySQL server
					$mysqli = new mysqli('host','username','password','database_name');
					
					//Output any connection error
					if ($mysqli->connect_error) {
						die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
					}		
					
					$insert_row = $mysqli->query("INSERT INTO BuyerTable 
					(BuyerName,BuyerEmail,TransactionID,ItemName,ItemNumber, ItemAmount,ItemQTY)
					VALUES ('$buyerName','$buyerEmail','$transactionID','$ItemName',$ItemNumber, $total,$ItemQTY)");
					
					if($insert_row){
						print 'Success! ID of last inserted record is : ' .$mysqli->insert_id .'<br />'; 
					}else{
						die('Error : ('. $mysqli->errno .') '. $mysqli->error);
					}
					
					*/
					?>
					<!--<pre>
						<?php //print_r($httpParsedResponseAr); ?>
					</pre>-->
                    <p> Buyer Name:<?php echo urldecode($httpParsedResponseAr["PAYMENTREQUEST_0_SHIPTONAME"]); ?></p>
                    <p> Buyer Email:<?php echo urldecode($httpParsedResponseAr["EMAIL"]); ?></p>
                    <p> Buyer Address:<?php echo urldecode($httpParsedResponseAr["PAYMENTREQUEST_0_SHIPTOSTREET"]); ?>, <?php echo urldecode($httpParsedResponseAr["PAYMENTREQUEST_0_SHIPTOCITY"]); ?>,
					<?php echo urldecode($httpParsedResponseAr["PAYMENTREQUEST_0_SHIPTOSTATE"]); ?>, <?php echo urldecode($httpParsedResponseAr["PAYMENTREQUEST_0_SHIPTOZIP"]); ?> <?php echo urldecode($httpParsedResponseAr["PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE"]); ?>
                    </p>
                    <p>Thank you for your purchase. Have a wonderful day!</p>
                    </div>
                    <?php
					
					
				} else  {
					echo '<div style="color:red"><b>GetTransactionDetails failed:</b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
					echo '<pre>';
					print_r($httpParsedResponseAr);
					echo '</pre>';

				}
	
	}else{
			echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
			echo '<pre>';
			print_r($httpParsedResponseAr);
			echo '</pre>';
	}
}
?>
           	<div class="newarrival clearfix">               
            	<h2>New Arrival Shoes</h2>
                 <div class="feature_box">    
           				<?php 
						function featured($number) { 
							//connect to db
							$conn = dbConnect('query');
							
							//get product info from  product and image tables
										   
							$sqlRandom = "SELECT * FROM product
										  LEFT JOIN image
										  ON product.product_id = image.product_id
										  ORDER BY RAND()
										  LIMIT $number";
				
							//submit the SQL query to the database and get the result
							$result = $conn->query($sqlRandom) or die(mysqli_error());	
				
							//loop through and display categories
							while ($row = $result->fetch_assoc()) {
								//loop through the results of the product query and display product info.
								//Plus build the link dynamically to a detail page
								echo '<div class="feature">';
								echo '<p><a href="../product_details.php?product_id='.$row['product_id'] .' "> ' . $row['product_name'] . '</a></p><br/>';
								echo '<a href="../product_details.php?product_id='.$row['product_id'] .' "><img src="../images/' . $row['thumb_filename'] .'" /></a>';
								echo '</div>';
							}
							
							$result->free_result();
							dbClose($conn); 
							
				}
				featured(4);
				?>

                </div>
            </div>
            
            
        </div>   

    <div id="footer">
		<?php include("../includes/footer.php"); ?>
    </div>
    
    </div>
</body>
</html>
					

