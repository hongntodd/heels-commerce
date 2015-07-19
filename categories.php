<?php
	//call the setSectionName function and assign it to $sectionName for use throughout the page.
	//$sectionName = setSectionName();

	if ( isset($_GET['category_id']) && is_numeric($_GET['category_id']) ) {
		
		//set the variable so it's easier to use later in script
		$category_id = $_GET['category_id']; //for troubleshooting
		
		//echo "product_id is $product_id <br>";
	} else {
		$category_id = 0;
		echo "No product id on the url.";
	}

?>
<!DOCTYPE html>
<html>
<head>
<?php include("includes/functions.php"); ?>
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
                        
           <?php
			
			//connect to db
			$conn = dbConnect('query');
			
			//we need to set up a query to get the category information
			//create SQL from  two tables - products and category - via the lookup table

			$sql = "SELECT *
			FROM product, product_category_lookup, category
			WHERE product.product_id = product_category_lookup.product_id
			AND product_category_lookup.category_id = category.category_id
			AND category.category_id = $category_id 
			ORDER BY product.product_id";
//echo $sql;
			//submit the SQL query to the database and get the result
			$result = $conn->query($sql) or die(mysqli_error());

			while ($row0 = $result->fetch_assoc()) {
				$sql = "SELECT * FROM image
						WHERE image.product_id = " . $row0['product_id'];
						
				$result2 = $conn->query($sql) or die(mysqli_error());
						
				while ($row = $result2->fetch_assoc()) {
					//loop through the results of the product query and display product info.
					//Plus build the link dynamically to the details page
					
					echo '<div class="productt">';
					echo '<a href="product_details.php?product_id='.$row['product_id'] .'"><img src="images/' . $row['thumb_filename'] .'" /></a>';
					echo '<p><a href="product_details.php?product_id='.$row['product_id'] .' "> ' . $row0['product_name'] . '</a></p>';						
					echo '<p class="price">Price: $'.$row0['product_price'].'</p>';				
					echo '</div>';
				} //end of the while loop
			
			} //end while
			//release the db resources to allow a new query
			$result->free_result();
			$result2->free_result();

			//close our database connection
			dbClose($conn);
			//echo "$navbar<br />";
			
			
			?>
		</div>
     </div>       

        
    
    <div id="footer">
		<?php include("includes/footer.php"); ?>
    </div>
</div>

</body>
</html>