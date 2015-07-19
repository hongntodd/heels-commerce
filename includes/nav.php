
<ul class="nav">
	<li><a href="index.php" <?php if ($currentPage == 'index.php') {echo 'id="here"';} ?>>HOME</a></li>
    <li><a href="products.php" <?php if ($currentPage == 'products.php') {echo 'id="here"';} ?>>ALL SHOES</a></li>    
    <?php listCategories(); ?>    
</ul>