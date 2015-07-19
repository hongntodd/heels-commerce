<?php
// Connect to the database server. If a connection can’t be made, an error will occur.
// Remember to fill in your username, password and database. Also change 'localhost' if necessary.


$con = mysqli_connect('localhost','gotheelsadmin','gotheels', 'database');

if (!$con) {
  die('Could not connect to MySQL server: '. mysqli_connect_errno() .' :: '. mysqli_connect_error());
} 


//$con = mysqli_connect('localhost','username','password', 'database') 
//or die("<p>The database server is not available.</p>");

?>
