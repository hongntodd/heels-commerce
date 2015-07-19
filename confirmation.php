<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php include("includes/functions.php"); ?>


<?php
	//call the setSectionName function and assign it to $sectionName for use throughout the page
	//$sectionName = setSectionName();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LOLCAT World: <?php  //echo $sectionName; ?></title>
<link href="cat_style.css" rel="stylesheet" type="text/css" />

</head>

<body>

<div id="outerWrapper">

    <div id="header">
        Got Heels: <span class="sectionName"><?php  //echo $sectionName; ?></span>
    </div>
        
    <div id="contentWrapper">
    
        <div id="navBar">
			<?php include("includes/navbar.php"); ?>
        </div>
        
        <div id="rightColumn1">
            <h2><?php echo date("F j, Y"); ?></h2>
        </div>
        
        <div id="content">
            
			<p>Yay you!  You bought our stuff!</p>
            
            
        </div>
        
    </div>
    
    <div id="footer">
		<?php include("includes/footer.php"); ?>
    </div>
</div>

</body>
</html>