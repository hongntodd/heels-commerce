<?php
/*
Author: D. Jean Hester
Date: 2-15-10
Course:  Ecommerce Site Design
Version: 1.0 
Description:  Set the style for the current page in the navbar.  For use in Got Heels World example site.
*/
session_start();
 	//get the file name and set to $currentPage variable
	$currentPage = basename($_SERVER['SCRIPT_NAME']);
	$cart_count = count($_SESSION['products']); 

 
	
?>
<div class="cartview">
	<div class="cart_image"><a href="view_cart.php"><?php echo $cart_count; ?></a></div>
	<h1><a href="#cart_slide_down" id="cart_slide">VIEW CART <span class="cart_count"> <?php echo $cart_count; ?> </span></a> <a href="checkout.php">CHECKOUT</a></h1>
    <br>
    <div class="shopping-cart-top" id="cart_slide_down">
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
    
</div>
