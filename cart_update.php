<?php
ob_start();
session_start();
include_once("includes/functions.php");
$conn= dbConnect('admin');



//empty cart by distroying current session
if(isset($_GET["emptycart"]) && $_GET["emptycart"]==1)
{
	$return_url = base64_decode($_GET["return_url"]); //return url
	session_destroy();
	header('Location:'.$return_url);
}

//add item in shopping cart

if(isset($_POST["add_to_cart"])) {
	$product_id 	= filter_var($_POST["product_id"], FILTER_SANITIZE_NUMBER_INT); //product id
	$name 			= filter_var($_POST["name"], FILTER_SANITIZE_STRING); //product name
	$qty 			= filter_var($_POST["qty"], FILTER_SANITIZE_NUMBER_INT); //product code
	$price		 	= filter_var($_POST["price"], FILTER_SANITIZE_NUMBER_INT); //product price
	$size 			= $_POST["size"]; //product size
	$thumb 			= filter_var($_POST["thumb"], FILTER_SANITIZE_STRING); //product thumb image
	$return_url 	= base64_decode($_POST["return_url"]); //return url
	
	
		//prepare array for the session variable
		$new_product = array(array('product_id'=>$product_id, 'name'=>$name, 'size'=>$size, 'qty'=>$qty, 'price'=>$price, 'thumb'=>$thumb));
		//print_r($_SESSION["products"]);
		
		
		if(isset($_SESSION["products"])) { //if we have the session
		
						
			foreach ($_SESSION["products"] as $cart_itm) //loop through session array
			{
				if($cart_itm["product_id"] == $product_id && $cart_itm["size"] == $size && $cart_itm["qty"] == $qty){ //the item exist in array	
					$product[] = array('product_id'=>$cart_itm["product_id"], 'name'=>$cart_itm["name"], 'size'=> $qty, 'qty'=>$cart_itm["qty"], 'price'=>$cart_itm["price"], 'thumb'=>$cart_itm["thumb"]);
					//echo 'found';
				} elseif($cart_itm["product_id"] == $product_id && $cart_itm["size"] == $size && $cart_itm["qty"] != $qty) {
					//echo 'qty change';
					$cart_itm["size"] = $qty;					
				} else {
					//item doesn't exist in the list, just retrive old info and prepare array for session var
					$product[] = array('product_id'=>$cart_itm["product_id"], 'name'=>$cart_itm["name"], 'size'=> $cart_itm["size"], 'qty'=>$cart_itm["qty"], 'price'=>$cart_itm["price"], 'thumb'=>$cart_itm["thumb"]);
					$_SESSION["products"] = array_merge($product, $new_product);
					//echo 'anything';
				}
			}	
				
		}else{
			//create a new session var if does not exist
			$_SESSION["products"] = $new_product;	
			header('Location:'.$return_url);
			
		}		//redirect back to original page
		header('Location:'.$return_url);
		
	}
	
	


//remove item from shopping cart
if(isset($_GET["removep"]) && isset($_GET["return_url"]) && isset($_SESSION["products"]))
{
	$product_size 	= $_GET["removep"]; //get the product code to remove
	$product_id 	= $_GET["product_id"]; //get the product code to remove
	$product_name 	= $_GET["item"]; //get the product code to remove
	$return_url 	= base64_decode($_GET["return_url"]); //get return url

	foreach ($_SESSION["products"] as $key =>$value) //loop through session array var
	{
		if($value["size"] == $product_size && $value["name"] == $product_name) { //if item doesn't exist in the list
			
			echo 'found';
			$coundt= count($_SESSION["products"]);
			if ($coundt == 1) {
				unset($_SESSION["products"]);
			} else {
				unset($_SESSION["products"][$key]);
			}
		}
	}
	
	//redirect back to original page
	header('Location:'.$return_url);
}

?>