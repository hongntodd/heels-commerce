<?php
session_start();
unset($_SESSION["loggedin"]);

setcookie("loggedin","", time() - 3600); // remove after 3600 seconds
setcookie("loggedinemail","", time() - 3600);
setcookie("loggedinfname","", time() - 3600);
setcookie("loggedinuser","", time() - 3600); header("Location:index.php");
?>