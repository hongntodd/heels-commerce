<?php include("includes/functions.php"); ?>

<?php
	//call the setSectionName function and assign it to $sectionName for use throughout the page.
	//$sectionName = setSectionName();
	if (isset($_GET['start']) ) {
		$start_number = $_GET['start'];
	} else {
		$start_number = 0;
	}
		
	$items_per_page = 4;
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
        
        <div id="content" class="showall">                        
           
                    
            <?php
            
            //connect to db
            $conn = dbConnect('query');
            
            //we need to set up a query to get the category information
            //create SQL from  two tables - products and category - via the lookup table
    
            $sql = "SELECT *
            FROM product, product_category_lookup, category
            WHERE product.product_id = product_category_lookup.product_id
            AND product_category_lookup.category_id = category.category_id
            ORDER BY product.product_id";
            
            //submit the SQL query to the database and get the result
            $result = $conn->query($sql) or die(mysqli_error());
        
    
                
            //set up array to store the results of the lookup table query
            $categories = array();
            
            while ($row = $result->fetch_assoc()) {
                //loop through the sql result, add each product_id and _category_id to the array to use later 
                $categories[] = array( 
                    'product_id' => $row['product_id'], 
                    'category_id' => $row['category_id'] ,
                    'category_name' => $row['category_name'] 
                ); 
            }
            
            //now that we are finished with the categories results set, release the db resources to allow a new query.
            $result->free_result();
            
            ////////////////////////////////////
            
            //do the same for the next lookup table - the product and type pairs
            $sql = "SELECT *
            FROM product, product_type_lookup, type
            WHERE product.product_id = product_type_lookup.product_id
            AND product_type_lookup.type_id = type.type_id
            ORDER BY product.product_id";
                
            //submit the SQL query to the database and get the result
            $result = $conn->query($sql) or die(mysqli_error());
            
            //set up array to store the results of the lookup table query
            $types = array();
            
            while ($row = $result->fetch_assoc()) {
                //loop through the sql result, add each product_id and type_id to array to use later 
                    $types[] = array( 
                                        'product_id' => $row['product_id'], 
                                        'type_id' => $row['type_id'] ,
                                        'type_name' => $row['type_name'],
                                        'product_price' =>$row['product_price']
                                    ); 									
            }
            //now that we are finished with the types set, release the db resources to allow a new query.
            $result->free_result();
            
            
            ////////////////////////////////////
            
            //count number of products
            $sql = "SELECT * FROM product
                    LEFT JOIN image
                    ON product.product_id = image.product_id";
    
            //submit the SQL query to the database and get the result
            $result = $conn->query($sql) or die(mysqli_error());
            
            // set up navbar
            $navbar = create_navbar($start_number, $items_per_page, $result->num_rows);	
            
            $result->free_result();
            
            //get product info from  product and image tables
            $sql = "SELECT * FROM product
                    LEFT JOIN image
                    ON product.product_id = image.product_id
                    LIMIT $start_number, $items_per_page";
                    
            $result = $conn->query($sql) or die(mysqli_error());
                    
            while ($row = $result->fetch_assoc()) {
                //loop through the results of the product query and display product info.
                //Plus build the link dynamically to the details page
                
                echo '<div class="productt">';
                echo '<a href="product_details.php?product_id='.$row['product_id'] .'"><img src="images/' . $row['thumb_filename'] .'" /></a>';
                echo '<p><a href="product_details.php?product_id='.$row['product_id'] .' "> ' . $row['product_name'] . '</a></p>';	
                echo '<p class="price">Price: $'.$row['product_price'].'</p>';				
                echo '</div>';
            } //end of the while loop
            
            //release the db resources to allow a new query
            $result->free_result();
    
            //close our database connection
            dbClose($conn);
            echo "<div class=\"navpage\">$navbar</div>";
            ?>
        </div>
        
    </div>
    <div id="footer">
		<?php include("includes/footer.php"); ?>
    </div>
</div>

</body>
</html>