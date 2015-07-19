<?php 
	ob_start();
	session_start();
	include("includes/functions.php");
	//call the setSectionName function and assign it to $sectionName for use throughout the page
	//$sectionName = setSectionName();
	$disable = false;
	if (isset($_GET['product_size'])) {
		$size = $_GET['product_size'];
		$disable = true;
	} else {
		$size = 'Please select a size';	
		$disable = false;
	}
		
	//check for the product_id on the query string
	if ( isset($_GET['product_id']) && is_numeric($_GET['product_id']) ) {
		
		//set the variable so it's easier to use later in script
		$product_id = $_GET['product_id']; //for troubleshooting
		
		//echo "product_id is $product_id <br>";
	} else {
		$product_id = 0;
		echo "No product id on the url.";
	}
	
	//call the db connection script, passing in the type of user.
	$conn = dbConnect('query'); 

	//PART 1. Get basic product info and image
	//note that we're using LEFT JOIN to get image information as well as product info
	//the ON condition is where we match up the foreign key in the image table with a primary key in the product table
	
	$sql = "SELECT * FROM product 
			LEFT JOIN image
			ON product.product_id = image.product_id
			WHERE product.product_id = $product_id";

	//submit the SQL query to the database and get the result
	$result = $conn->query($sql) or die(mysqli_error());
	$row = $result->fetch_assoc();
	
	$productName = $row['product_name'];
	$price = $row['product_price'];
	
	//zoom image session
	$sqlzoom = "SELECT * FROM imagezoom_lookup, imagezoom
				WHERE imagezoom_lookup.imagezoom_id= imagezoom.imagezoom_id
				AND imagezoom_lookup.product_id = " . $product_id;
	$resultz = $conn->query($sqlzoom) or die(mysqli_error());
	$rowz = $result->fetch_assoc();		
	$typez = array();
			
	while ($rowz = $resultz->fetch_assoc()) {
		//loop through the sql result, add each product_id and type_id to array to use later 
		$typez[] = array( 
							'product_id' => $rowz['product_id'], 
							'imagezoom_id' => $rowz['imagezoom_id'] ,
							'zoom_filename' => $rowz['zoom_filename'],
							'zoom_thumb' => $rowz['zoom_thumb']										
						); 
	}		
								 
	$sql2 = "SELECT *
			FROM product, product_type_lookup, type, image
			WHERE product.product_id = $product_id
			AND product_type_lookup.product_id = $product_id
			AND product_type_lookup.type_id = type.type_id
			AND image.product_id = product.product_id
			ORDER BY product.product_id";
	
	
	  //submit the SQL query to the database and get the result
	  $result2 = $conn->query($sql2) or die(mysqli_error());
	  $row2 = $result->fetch_assoc();
	  
	  //set up array to store the results of the lookup table query
	  $types = array();
	  
	  while ($row2 = $result2->fetch_assoc()) {
		  //loop through the sql result, add each product_id and type_id to array to use later 
			  $types[] = array( 
								  'product_id' => $row2['product_id'], 
								  'type_id' => $row2['type_id'] ,
								  'type_icon' => $row2['type_icon'],
								  'type_icon_un' => $row2['type_icon_un'],
								  'type_name' => $row2['type_name'],
								  'inventory' => $row2['inventory'],
								  'thumb_filename' => $row2['thumb_filename'],
								  'price' => $row2['price'],
								  'type_name' => $row2['type_name'],
								  'type_description' => $row2['type_description']
							  ); 
	  }
	  
			
	//now that we are finished with results, release the db resources to allow a new query.
			$result2->free_result();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>GOT HEELS <?php  //echo $sectionName; ?></title>
<link href="heels_style.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="multizoom.css" type="text/css" />
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
});
</script>
<script type="text/javascript" src="multizoom.js"></script>
<script type="text/javascript">
<!--image zoom script-->
jQuery(document).ready(function($){

	$('#image1').addimagezoom({ // single image zoom
		zoomrange: [3, 10],
		magnifiersize: [300,300],
		magnifierpos: 'right',
		cursorshade: true,
		largeimage: 'hayden.jpg' //<-- No comma after last option!
	})

	$('#image2').addimagezoom() // single image zoom with default options
	
	$('#multizoom1').addimagezoom({ // multi-zoom: options same as for previous Featured Image Zoomer's addimagezoom unless noted as '- new'
		descArea: '#description', // description selector (optional - but required if descriptions are used) - new
		speed: 1500, // duration of fade in for new zoomable images (in milliseconds, optional) - new
		descpos: true, // if set to true - description position follows image position at a set distance, defaults to false (optional) - new
		imagevertcenter: true, // zoomable image centers vertically in its container (optional) - new
		magvertcenter: true, // magnified area centers vertically in relation to the zoomable image (optional) - new
		zoomrange: [3, 10],
		magnifiersize: [250,250],
		magnifierpos: 'right',
		cursorshadecolor: '#fdffd5',
		cursorshade: true //<-- No comma after last option!
	});
	
	$('#multizoom2').addimagezoom({ // multi-zoom: options same as for previous Featured Image Zoomer's addimagezoom unless noted as '- new'
		descArea: '#description2', // description selector (optional - but required if descriptions are used) - new
		disablewheel: true // even without variable zoom, mousewheel will not shift image position while mouse is over image (optional) - new
				//^-- No comma after last option!	
	});
	

});
</script>
<script>
$(document).ready(function() {
$("#message_added").addClass('animated zoomIn').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',
	function(){
		$(this).removeClass('animated zoomIn');
		$(this).addClass('animated zoomOut')
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
    <?php
		if(isset($_GET['added'])&& $_GET['added'] ==1){
    		echo "<div class='alert alert-info' id='message_added'>";
			echo "Item was added to cart!";
    		echo "</div>";		
		}
	?>       
        <div id="navigation">
			<?php include("includes/nav.php"); ?>
        </div>

       
   <div class="mainwrap clearfix">
   
   
   
        <div id="contentdetail" class="showall">
            <h2><?php //echo $sectionName . ": ". $productName; ?></h2>
            
           
<?php 
	$current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
  //process the query and display details results
  
  if ($row) {
	  //set a variable for the id of the current row we are looping in
	  $currentProduct_id = $row['product_id'];
	  
	  //loop through the results of the basic info query Part 1
	  
		//build the image code
		//remember that getimagesize is a builtin function of PHP, returnsan array, 
		//and index[3] is the height and width
		
		if ($row && !empty($row['filename'])) { //if there is a product AND  there is an image
			//create a variable and assign path to image in images folder
			$imageFile = 'images/' . $row['filename']; 
			//get the size of the image
			$imageSize = getimagesize($imageFile); 
		
			//the code for the image
		   // echo '<img src="'. $imageFile. '" alt="'. $row['product_name'] . '" ' . $imageSize[3] . '/>';
			
		 } //if no image then nothing done, move on to text info
		 
								 
		 //image zoom shows
echo '<div class="top clearfix">';		 
	 echo '<div class="zoom_image">';	
			 echo '<div class="targetarea diffheight">';
			 echo '<img id="multizoom2" alt="zoomable" title="" src="'.$typez[0]['zoom_thumb'].'"/>';
			 echo '</div>';
			 echo '<div class="multizoom2 thumbs">';
		   for ($i = 0; $i < count($typez) ;$i++) {								
			  if ($currentProduct_id = $typez[$i]['product_id']) {

				  $imageFile = 'images/' . $typez[$i]['zoom_filename'];  
				  $imageThumb = 'images/' . $typez[$i]['zoom_thumb'];
				  
					 
//							  	echo '<div id="description2">"'.$productName.'"</div>';

					  echo '<a href="'.$imageThumb.'" data-large="'.$imageFile.'" data-title=""><img src="'.$imageThumb.'" alt="" title=""/></a>';
			  }		 
		 }
		 echo '</div>';
		 echo '</div>';
	 
	  //display the types product is available in
	  echo '<div class="size_available">';	 
	  
	  	  echo '<form action="cart_update.php" method="post">';
	  		echo '<h4>'.$productName.' - <span>$'.$price.'</span></h4><br>';
	  		echo '<p>Size available: </p>';
	  $length_types = count($types);						
	  
		  
		  //loop through the results of the types query Part 2
		  echo '<ul style="padding-left: 0px;">';
		  for ($row2 = 0; $row2 < $length_types; $row2++) {
			  if ($currentProduct_id == $types[$row2]['product_id']) {


				  //here we check inventory levels
				  if ($types[$row2]['inventory'] > 0) {
					
					//needed to create this variable for inclusion in input HTML below.
					$product_id = $types[$row2]['product_id'];					
					$type_description = $types[$row2]['type_description'];
					$type_name = $types[$row2]['type_name'];
					$type_icon = $types[$row2]['type_icon'];	
					$thumb_filename = $types[$row2]['thumb_filename'];	
					$price = $types[$row2]['price'];								  									  
													   
					//set image of size and echo product_id and size of shoes   
					
					?>                    
					<a href="<?php echo $_SERVER['PHP_SELF']; ?>?product_size=<?php echo $type_name; ?>&amp;product_id=<?php echo $product_id; ?>"><img src="images/<?php echo $type_icon; ?>" class="size_thumbnail" alt="<?php echo $type_description; ?>"/> </a>
   					<?php
										

				  } else {
					  $type_icon_un = $types[$row2]['type_icon_un']; 
					  echo "<a href='#'><img src='images/" .$type_icon_un."' class='size_thumbnail disabled' disable='disabled' alt='This size is sold out' title='This size is sold out'/> </a>";
					  
				  }

			  }
		  }
		  echo '</ul><br>';
		  echo 'Quantity <input style="text-align: center;" type="text" name="qty" value="1" size="5" /><br><br>';
            echo 'Size: '.$size.'<br><br>';
			if($disable == true) {
				echo '<input name="add_to_cart" type="submit" value="Add to Cart" />';				
			} else {
				echo '<input name="add_to_cart" type="submit" value="Add to Cart" disabled="disabled" />';			
			}
			
				
		 echo '<input type="hidden" name="price" value="'.$price.'" />';	
		 echo '<input type="hidden" name="name" value="'.$productName.'" />';
		 echo '<input type="hidden" name="product_id" value="'.$product_id.'" />';
		 echo '<input type="hidden" name="thumb" value="'.$thumb_filename.'" />';
		 echo '<input type="hidden" name="return_url" value="'.$current_url.'" />';
		 echo '<input type="hidden" name="size" value="'.$size.'" />';
	 
	  echo '</form>';
	  
	  
  } else {
	  
	  echo "No such record found.";
	  //TO DO - add code that randomly selects a product "We didn't find
	  //the product you were looking for, but check this one out..."
  }
  
  //now that we are finished with basic info results, release the db resources to allow a new query.
  $result->free_result();
  //close db connection
  dbclose($conn);
 
?>

 </div>
</div>

<?php
  echo '<div class="detail">';
			echo '<div class="product_detail">';
				echo "<h4>" . $row['product_name']."</h4>";
				echo "<p>" . $row['product_description'] . "</p>";
			echo '</div>';
        echo '</div>';
?>


<!-- Shopping cart display, view cart -->
<div class="shopping-cart">
<h2>Your Shopping Cart</h2>

		
<?php
if(isset($_SESSION["products"]))
{
    $total = 0;
    echo '<ol>';
    foreach ($_SESSION["products"] as $cart_itm)
    {
        echo '<li class="cart-itm">';
       
		echo '<div class="cart-item-image"><img src="images/'.$cart_itm["thumb"].'" alt=""/></div>';
		echo '<div class="cart-item-content">';
        	echo '<h3>'.$cart_itm["name"].'</h3>';
			echo '<div class="cart-item-box">';
				echo '<p>Size : '.$cart_itm["size"].'<br>';
				echo 'Qty : '.$cart_itm["qty"].'</p>';			
			
		echo '<div class="remove-itm"><a href="cart_update.php?removep='.$cart_itm["size"].'&item='.$cart_itm["name"].'&product_id='.$cart_itm["product_id"].'&return_url='.$current_url.'">&times;<br><span>Remove</span></a></div>';
		echo '<div class="p-price">$'.$currency.$cart_itm["price"].'</div>';
		echo '</div>';
		echo '</div>';
        echo '</li>';
        $subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
        $total = ($total + $subtotal);
    }
    echo '</ol>';
	echo '<strong>Total : $'.$currency.$total.'</strong>';
    echo '<span class="check-out-txt"> <a href="view_cart.php">View Cart</a></span>';
	echo '<span class="empty-cart"><a href="cart_update.php?emptycart=1&return_url='.$current_url.'">Empty Cart</a></span>';
}else{
    echo 'Your Cart is empty';
}
?>
</div>



               
        	<!-- Related Products -->	
        <?php	
        
      
        echo '</div>';
        $conn = dbConnect('query');
            $number = 3;
        
            $sqlRelated = "SELECT * FROM product a
                            left join image on image.product_id = a.product_id
                            where a.product_id in (
                                select distinct product.product_id from product, product_category_lookup
                                where product.product_id = product_category_lookup.product_id
                                and product_category_lookup.category_id IN (
                                    select category_id 
                                    from product_category_lookup 
                                    where product_id = " . $product_id . ")
                                )
                            and a.product_id <> " . $product_id . "
                            order by RAND()
                            Limit $number";
        //echo $sqlRelated;		
            $result = $conn->query($sqlRelated) or die(mysqli_error($conn));
            //$row = $result->fetch_assoc();
            
            
			
			
            echo '<div id="related_items">';
            echo '<h2>You may also like: </h2>';
            //loop through and display categories
            echo '<div id="related_box">';
            while ($row = $result->fetch_assoc()) {
                //var_dump($row);
                //loop through the results of the product query and display product info.
                //Plus build the link dynamically to a detail page
                
                echo '<div class="related">';
                echo '<p><a href="product_details.php?product_id='.$row['product_id'] .' "> ' . $row['product_name'] . '</a></p><br/>';
                echo '<a href="product_details.php?product_id='.$row['product_id'] .' "><img src="images/' . $row['thumb_filename'] .'" /></a>';
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
        ?>   
</div><!-- End div mainwrap -->	
        

  
    
    
    
    <div id="footer">
		<?php include("includes/footer.php"); ?>
    </div>
</div>

</body>
</html>