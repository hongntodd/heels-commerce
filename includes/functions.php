<?php
/*
Author: D. Jean Hester
Date:  February 15, 2010
Course:  Ecommerce Site Design
Version: 1.0 
Description:  Functions for use in LOLCAT World example site.
*/


##################################################################
#Function MySQL connection script
#Date:  2-15-10
#Version:  1.0
##################################################################

function dbConnect($type) {
	if ($type == 'query') {
		$user = 'gotheelsquery';
		$pwd = 'gotheels';
	} elseif ($type == 'admin') {
		$user = 'gotheelsadmin';
		$pwd = 'gotheels';
	} else {
		exit('Unrecognized connection type');
	}
	//connection code goes here
	$conn = new mysqli('localhost', $user, $pwd, 'gotheels') or die ('Cannot open database');
	//echo "database connected<br>";  //for troubleshooting
	return $conn;
}
/*to use this function, inluclude this file, and 
call the function like this for the query user:
	$conn = dbConnect('query');

OR call the function like this for the admin user:
	$conn = dbConnect('admin');
	
To adapt this for other projects, change the username, password, and database name in the above code.


*/
function connect() {
    return new PDO('mysql:host=localhost;dbname=gotheels', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}



##################################################################
#Function MySQL disconnection script
#Date:  2-15-10
#Version:  1.0
##################################################################

//use this function to close a database connection
//$conn is what we used to create a connection earlier, when we called the function dbConnect()
function dbClose($conn) {
	mysqli_close($conn);
}


##################################################################
#Function for footer copyright notice
#Date:  4-26-09
#Version:  1.0
##################################################################

function setCopyright($startYear) {
			ini_set('date.timezone', 'America/Los_Angeles');
			$thisYear = date('Y');
			
			if ($startYear == $thisYear) {
				echo $startYear;
			} else {
				echo "$startYear - $thisYear";
			}
}


##################################################################
#Function to set the section name for use in page title, header, and elsewhere in page.
#Date:  2-15-10
#Version: 1.0
##################################################################

//function setSectionName() {
	//determine current page
	/*the built-in function basename() takes the pathname of a file and extracts the filename.  $_SERVER['SCRIPT_NAME'] comes 
	from one of PHP's built-in superglobal arrays, and always give the absolute (site root-relative) pathname for the current page. */
	//$currentPage = basename($_SERVER['SCRIPT_NAME']);
	
	//set page name based on $currentPage
	//we will use this to set section name in header of each page, and elsewhere
	
/*	switch ($currentPage) {
		case "index.php":
			return "Home";
			break;
		case "products.php":
			return "All Shoes";
			break;
		case "product_details.php":
			return "Product Details";
			break;
		case "categories.php":
			return "CATegories";
			break;
		case "contact.php":
			return "Contact";
			break;
		case "about.php":
			return "About Us";
			break;
		default:
			return ""; //set the variable to an empty string to prevent the wrong section name
	}
}*/
/*to call this function in a page, create a variable that will be assigned the return value of the function.  for example,
call the function like this:  $mySectionName = setSectionName();   You can then use $mySectionName throughout the page. */


##################################################################
#Function that lists all categories
#Date:  2-15-10
#Version: 1.0
##################################################################

function listCategories() {
			//connect to db
			$conn = dbConnect('query');
			
			//we need to set up a query to get the category information
			//create SQL from  two tables - products and category - via the lookup table
			$sql = "SELECT * FROM category";
				
			//submit the SQL query to the database and get the result
			$result = $conn->query($sql) or die(mysqli_error());	

			//open list HTML

			
			//loop through and display categories
			while ($row = $result->fetch_assoc()) {
				//loop through the results of the product query and display product info.
				//Plus build the link dynamically to a page listing just those categories
				
				echo '<li><a href="categories.php?category_id='.$row['category_id'] .' "> ' . $row['category_name'] . '</a></li>';						
			}
			
			//close list HTML
			$result->free_result();
			dbClose($conn);
}


##################################################################
#Function to select random featured products based on # passed
#Date:  2-15-10
#Version: 1.0
##################################################################

//$number passed in call, indicates how many to get
	function featuredLolcat($number) { 
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
				echo '<p><a href="product_details.php?product_id='.$row['product_id'] .' "> ' . $row['product_name'] . '</a></p><br/>';
				echo '<a href="product_details.php?product_id='.$row['product_id'] .' "><img src="images/' . $row['thumb_filename'] .'" /></a>';
				echo '</div>';
			}
			
			$result->free_result();
			dbClose($conn); 
			
}




##################################################################
#Function that strips out backslashes for security
#Written by David Powers, and included in the codebase for "PHP Solutions: Dynamic Web Design Made Easy"
##################################################################

function nukeMagicQuotes() {
  if (get_magic_quotes_gpc()) {
    function stripslashes_deep($value) {
      $value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
      return $value;
      }
    $_POST = array_map('stripslashes_deep', $_POST);
    $_GET = array_map('stripslashes_deep', $_GET);
    $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
    }
  }
  
##################################################################
//pagination
##################################################################


function create_navbar($start_number, $items_per_page, $count) {
// Creates a navigation bar
	$current_page = $_SERVER["PHP_SELF"];
	if (($start_number < 0) || (! is_numeric($start_number))) {
		$start_number = 0;
	}
	$navbar = "";
	$prev_navbar = "";
	$next_navbar = "";
	if ($count > $items_per_page) {
		$nav_count = 0;
		$page_count = 1;
		$nav_passed = false;
		while ($nav_count < $count) {
			// Are we at the current page position?
			if (($start_number <= $nav_count) && ($nav_passed != true)) {
				$navbar .= "<b><a href=\"$current_page?start=$nav_count\">[$page_count] </a></b>";
				$nav_passed = true;
				// Do we need a "prev" button?
				if ($start_number != 0) {
					$prevnumber = $nav_count - $items_per_page;
					if ($prevnumber < 1) {
						$prevnumber = 0;
					}
					$prev_navbar = "<a href=\"$current_page?start=$prevnumber\"> &lt;&lt;Prev - </a>";
				}
				$nextnumber = $items_per_page + $nav_count;
				// Do we need a "next" button?
				if ($nextnumber < $count) {
					$next_navbar = "<a href=\"
					$current_page?start=$nextnumber\"> - Next&gt;&gt; </a><br>";
				}
			} else {
				// Print normally.
				$navbar .= "<a href=\"$current_page?start=$nav_count\">[$page_count] </a>";
			}
			$nav_count += $items_per_page;
			$page_count++;
		}
		$navbar = $prev_navbar . $navbar . $next_navbar;
		return $navbar;
	}
}  

//paypal settings
$PayPalMode 			= 'sandbox'; // sandbox or live
$PayPalApiUsername 		= 'jjhomeus-facilitator_api1.yahoo.com'; //PayPal API Username
$PayPalApiPassword 		= 'Q9B9RWFCWN4X22M9'; //Paypal API password
$PayPalApiSignature 	= 'An5ns1Kso7MWUdW4ErQKJJJ4qi4-AOb4s4ZhnRsfj4r8SraGD.TY-i-k'; //Paypal API Signature
$PayPalCurrencyCode 	= 'USD'; //Paypal Currency Code
$PayPalReturnURL 		= 'http://localhost/gotheels/paypal/process.php'; //Point to process.php page
$PayPalCancelURL 		= 'http://localhost/gotheels/paypal/cancel_url.html'; //Cancel URL if user clicks cancel

?>