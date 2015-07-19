<!DOCTYPE html>
<html>
<head>
<?php 
ob_start();
session_start();
include("includes/functions.php"); ?>
<meta charset="utf-8" />
<title>GOT HEELS <?php  //echo $sectionName; ?></title>
<link href="heels_style.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Lato:700,400,300' rel='stylesheet' type='text/css'>
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
           
			<div>
				<h2>Success</h2>
				<p>Your Transaction ID : '<?php echo urldecode($httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]); ?></p>
				<p>Payment Received! Your Package will be shipped in the next day</p>
                <p>Buyer Name: <?php echo urldecode($httpParsedResponseAr["FIRSTNAME"]); ?></p>
                <p>Buyer Address: <?php echo urldecode($httpParsedResponseAr["SHIPTOSTREET"]); ?></p>
                <p>Buyer City: <?php echo urldecode($httpParsedResponseAr["SHIPTOCITY"]); ?></p>
                <p>Buyer Address: <?php echo urldecode($httpParsedResponseAr["SHIPTOSTATE"]); ?></p>
                <p>Buyer Address: <?php echo urldecode($httpParsedResponseAr["SHIPTOZIP"]); ?>, <?php echo urldecode($httpParsedResponseAr["SHIPTOCOUNTRYNAME"]); ?></p>
                <pre>
					<?php print_r($httpParsedResponseAr); ?>
				</pre>
			</div>
            
            
            
            </div>
            
           	<div class="newarrival clearfix">               
            	<h2>New Arrival Shoes</h2>
                 <div class="feature_box">    
           			<?php featuredLolcat(4); ?>
                </div>
            </div>
            
            
        </div>
        

    
    <div id="footer">
		<?php include("includes/footer.php"); ?>
    </div>
    
    </div>
    <script src="js/jquery-1.9.1.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="ie10-viewport-bug-workaround.js"></script>

    <!-- jssor slider scripts-->
    <!-- use jssor.js + jssor.slider.js instead for development -->
    <!-- jssor.slider.mini.js = (jssor.js + jssor.slider.js) -->
    <script type="text/javascript" src="js/jssor.slider.mini.js"></script>
    <script>

        jQuery(document).ready(function ($) {
            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 2000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                                   //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideEasing: $JssorEasing$.$EaseOutQuint,          //[Optional] Specifies easing for right to left animation, default value is $JssorEasing$.$EaseOutQuad
                $SlideDuration: 800,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 1,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $ArrowNavigatorOptions: {                           //[Optional] Options to specify and enable arrow navigator or not
                    $Class: $JssorArrowNavigator$,                  //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Scale: false                                   //Scales bullets navigator or not while slider scale
                },

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 1,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 12,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 4,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1,                                //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                    $Scale: false                                   //Scales bullets navigator or not while slider scale
                }
            };

            //Make the element 'slider1_container' visible before initialize jssor slider.
            $("#slider1_container").css("display", "block");
            var jssor_slider1 = new $JssorSlider$("slider1_container", options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth) {
                    jssor_slider1.$ScaleWidth(parentWidth - 30);
                }
                else
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        });
    </script>


</body>
</html>