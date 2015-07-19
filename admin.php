<?php
session_start();
date_default_timezone_set("America/Los_Angeles");
error_reporting(E_ALL);
ini_set('display_errors','1');

require('includes/functions.php');
$con = dbConnect('admin');
	if(!isset($_SESSION['loggedin'])) {//sop if user not logged in
		die('You have no permission to view this page');// or use header() to redirect users
	} 
	elseif(isset($_SESSION['loggedin']) && ($_SESSION['adminuser'] == 0)) {
		die('You need the right previleges to access this page');
	}
	elseif(isset($_SESSION['loggedin']) && ($_SESSION['adminuser'] == 1)) {
		echo "Hello {$_SESSION['loggedinfname']} - ADMIN";
	}

?>

<table border="0" cellpadding="3" cellspacing="0" width="500">
  <tr><td align="left" valign="top" width="500">

<?php
$let = '' ; // assign default value
$finduser = '' ; // assign default value
$uid = '' ; // assign default value
$viewall = '' ; // assign default value
$searchwords = '' ; // assign default value
$id = '' ; // assign default value
$username = '' ; // assign default value
$err = '' ; // assign default value
$clause = '' ; // assign default value

 // count users

$totalquery = $con->query("SELECT customer_id FROM customer "); // note the way $user_email in the query exactly the same
$total = $totalquery->num_rows;
//sets the values for the variables regardless of GET/POST method
if(isset($_POST['viewall'])){
    $viewall = $_POST['viewall'];
} else {
if(isset($_GET['viewall'])){
    $viewall = $_GET['viewall'];
}}

if(isset($_GET['let'])){
	 //echo "<p>1 - {$_GET['let']}</p>";
	 //mysqli_real_escape_string requires two variables; the connection variable, and the string variable. 
    $let = $con->real_escape_string($_GET['let']);
    //echo "<p>2 - $let</p>";
}

if(isset($_POST['finduser'])){
    $finduser = $_POST['finduser'];
}else {
if(isset($_GET['finduser'])){
    $finduser = $_GET['finduser'];
}}

if(isset($_POST['searchwords'])){
    $searchwords = $con->real_escape_string($_POST['searchwords']);
}else {
if(isset($_GET['searchwords'])){
    $searchwords = $_GET['searchwords'];
}}

if(isset($_GET['uid'])){
    $uid = $con->real_escape_string($_GET['uid']);
} else {
if(isset($_POST['uid'])){
    $uid = $con->real_escape_string($_POST['uid']);
}}

//Set this to the number of records per page 
$limit = 5;

if(isset($_GET['offset'])){
    $offset = $con->real_escape_string($_GET['offset']);
}
else{
//Set the initial offset 
if (!isset($offset)) $offset = 0; 
}

// search for users by the first letter in username

if ($let){
$letter_total= $con->query("select customer_id, email from user where email like '$let%'");
$numrows_letter= $letter_total->num_rows;

$letter= $con->query("select customer_id, email from customer where email like '$let%' LIMIT $offset, $limit");

function mysqli_result($result, $iRow = 0, $sField = '')
{
    $return = false;
    if ($result->data_seek($iRow))
    {
        $record = $result->fetch_array();
        if (empty($sField) && isset($record[0]))
        {
            $return = $record[0];
        }
        elseif (!empty($sField) && isset($record[$sField]))
        {
            $return = $record[$sField];
        }
    }
    return $return;
}

 if ($letter->num_rows > 0) {
 	$row = $letter->fetch_array(MYSQLI_NUM);
 	
        $numrows= $letter->num_rows;
            
        $x=0;
        while ($x<$numrows){
        	
        	//there is no equivalent to mysql_result function
        	//try mysqli_result::fetch_array instead
        	
        $id= mysqli_result($letter,$x, 'customer_id');  
 $username= mysqli_result($letter,$x, 'email');
 // $letter->data_seek($x);
 //while ($row = $letter->fetch_array(MYSQLI_ASSOC)){
 //printf("<a href=\"%s?uid=%s\">%s</a><br/>\n", $_SERVER['PHP_SELF'],$row[id], $row[username]);
 //}
printf("<a href=\"%s?uid=%s\">%s</a><br/>\n", $_SERVER['PHP_SELF'],$id, $username);
        $x++;
      
        }
//print "<br/>". get_nav_letter($offset, $limit, $numrows_letter);
print "<br/>". get_nav($offset, $limit, $numrows_letter,"letter");

?>
</td></tr>
<tr><td>
<a href="<?php echo $_SERVER['PHP_SELF']."?viewall=viewall"; ?>">View list</a>
</td></tr>
<tr><td>
<a href="<?php echo $_SERVER['PHP_SELF']; ?>">Main Menu</a>
<?php
 }
else{
print "<tr><td align=left colSpan=3 valign=top width=500>
    No records found for letter <b>$let</b></td></tr>";
?>
<tr><td><br/>
<a href="<?php echo $_SERVER['PHP_SELF']."?viewall=viewall"; ?>">View list</a>
</td></tr>
<tr><td>
<a href="<?php echo $_SERVER['PHP_SELF']; ?>">Main Menu</a>
<?php

  }

// if passed searchwords, try to find matching user(s)

} elseif ($finduser){

//if (!ereg("[[:alnum:]]",$searchwords)):
if (!preg_match('/[[:alnum:]]/i', $searchwords)){
echo "<p>Your <font color=\"#FF0000\"><b>search</b></font> must be alphanumeric characters.";
echo "<br/>Letters a-z and numbers 0-9.</p>";

} else {

//add or remove fields to search to array
$fieldstosearch = array("user_fname","user_lname","email");

for($i=0;$i<count($fieldstosearch);$i++) {
$clause .= sprintf("(%s LIKE '%%%s%%') OR ", $fieldstosearch[$i], urldecode($searchwords));
}
//use substring function to remove last four characters from clause
if(count($fieldstosearch) > 1) {
$clause = "(".substr($clause, 0, -4).")";
}
else {
$clause = substr($clause, 0, -4);

}
//print field(s) query, this is optional
print $clause."<p>";

$searchq = $con->query("SELECT customer_id from customer WHERE $clause");
$numrows_search =$searchq->num_rows;

$realsql = "SELECT * from email WHERE $clause LIMIT $offset, $limit";
$result = $con->query($realsql);
if ($result->num_rows > 0) {
$itemnum=$offset+1;
while($row = $result->fetch_array()) {
printf("%s <a href=\"%s?uid=%s\">%s</a><br/>\n", $itemnum++, $_SERVER['PHP_SELF'],
$row["customer_id"], $row["customer_fname"],$row["customer_lname"]);
}
}
else {
print "Sorry No records found";
}

print "<br/>". get_nav($offset, $limit, $numrows_search, "usersearch");

}
?>

<tr><td><br/>
<a href="<?php echo $_SERVER['PHP_SELF']."?viewall=viewall"; ?>">View list</a>
</td></tr>
<tr><td>
<a href="<?php echo $_SERVER['PHP_SELF']; ?>">Main Menu</a>

<?php
// if passed the userid take one of several actions after pulling up user profile
} elseif ($uid){

// if the delete button is pressed, delete user
if(isset($_POST['deleteuser'])){

$delete = $con->query("delete from customer WHERE customer_id=$uid");
?>
<tr><td align=left colspan=3 valign=top width=500><b>
<?php print("User has been deleted"); ?>
</b></td></tr>

<tr><td><br/>
<a href="<?php echo $_SERVER['PHP_SELF']."?viewall=viewall"; ?>">View list</a>
</td></tr>
<tr><td>
<a href="<?php echo $_SERVER['PHP_SELF']; ?>">Main Menu</a>
<?php
}

// if new information is submitted, update the user information
else{
if (isset($_POST['submit'])) {
	
if($_POST['newpassword'] !=''){

if (!preg_match("/^[A-Za-z0-9]{4,12}$/i",$_POST['newpassword'])){
$err ="<tr>
<td align=left colspan=3 valign=top width=356><b>
Your <font color=\"#9c2108\">Password</font>:
<br/>-must be 4-12 characters long<br/>-can contain numbers
<br/>-cannot contain spaces<br/>-cannot contain non-alphanumeric symbols such as \".?!#@$%*&\"
</b></td></tr>\n";
}
else{
$_POST['newpassword'] = md5($_POST['newpassword']); //encrypt password
$sql = "UPDATE customer SET password='".$con->real_escape_string($_POST['newpassword'])."' WHERE customer_id='$uid'";
$result = $con->query($sql);
}
}

/*
//if your user table stored firstname and lastname, you would also update them if necessary
$sql3 = "UPDATE user SET lastname="'.$_POST['lastname']. "' WHERE id=$uid";
$sql2 = "UPDATE user SET firstname='".$_POST['firstname']. "' WHERE id=$uid";
*/

if($_POST['newemail'] !=''){
	//use preg_match 
//if(!preg_match('/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i', $_POST['newemail'])){

  //FILTER_VALIDATE_EMAIL filter validates value as an e-mail address.
if(!filter_var($_POST['newemail'], FILTER_VALIDATE_EMAIL)){
 $err .= "<tr>
 <td align=left colspan=3 valign=top width=500><b>
 Your <font color=\"#9c2108\">E-mail address </font>
 is not valid. </b></td></tr>\n";}
else{
$sql1= "UPDATE customer SET email='".$con->real_escape_string($_POST['newemail'])."' WHERE customer_id='$uid'";
$result1 = $con->query($sql1);
}
}

/*
//if your user table stored firstname and lastname, you would also update them if necessary
$result3 = $con->query($sql3);
$result2 = $con->query($sql2);
*/


if(!$err){

?>
 <tr><td align=left colspan=3 valign=top width=500><b>Thank you! Information updated:</b>
<br/><br/>

<a href="<?php echo $_SERVER['PHP_SELF']."?uid=$uid"; ?>">View updated record</a></td></tr>
<?php
}
else{
print ("$err");
print ("<tr><td align=left colspan=3 valign=top width=500>
<a href=\"".$_SERVER['PHP_SELF']."?uid=$uid\">
Go Back.</a></td></tr>");

}
?>

<tr><td><br/>
<a href="<?php echo $_SERVER['PHP_SELF']."?viewall=viewall"; ?>">View list</a>
</td></tr>
<tr><td>
<a href="<?php echo $_SERVER['PHP_SELF']; ?>">Main Menu</a>
<?php

  } else {

// display the user profile

    // query the DB

    $sql = "SELECT * FROM customer WHERE customer_id='$uid'";
    //echo "$sql<br/>";
    $result = $con->query($sql);
    $myrow = $result->fetch_array();

   // echo $con->error();
    ?>

<p>
<b>
<font color="#9c2108">member: <?php echo $myrow["email"]; ?></font>
</b>
</p>

<br/>

<form method="post" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
<input type=hidden name="uid" value="<?php echo $myrow["customer_id"]; ?>">

<table border="0" cellpadding="1" cellspacing="0">
        <tr>
          <td align=left width=150>Username :</td>
          <td align=left width=350>
          <?php echo $myrow["email"] ?> </td></tr>
        <tr>
          <td align=left>Present Password :</td>
 <td align=left>
 <?php echo $myrow["password"] ?></td></tr>
<tr>
          <td align=left>New password? :</td>
          <td align=left><input type="password" name="newpassword" value="">
</td></tr>
<!-- if your user table stored firstname and lastname, you would output the stored values in fields for update  
<tr>
          <td align=left>First Name :</td>
          <td align=left>
<input type="Text" name="firstname" value="<?php echo $myrow["firstname"]; ?>">
</td></tr>
        <tr>
          <td align=left>Last Name :</td>
          <td align=left>
<input type="Text" name="lastname" value="<?php echo $myrow["lastname"]; ?>">
</td></tr>
-->
        <tr>
          <td align=left>Email Address :</td>
          <td align=left><?php echo $myrow["email"]; ?></td></tr>
<tr>
    <td align=left>New Email Address? :</td>
    <td align=left><input type="Text" name="newemail" value="">
</td></tr>
<!--
<tr><td align=left>
Last Login:</td>
<td align=left> <?php print $myrow["last_login"]; ?></td></tr>
<tr><td align=left>Account created:</td>
<td align=left> <?php echo $myrow["registered"]; ?></td></tr>
-->
<tr><td>
<br>
<input type="Submit" name="submit" value="Update information">
<br/><br/>
<input type="Submit" name="deleteuser" value="Delete User">
</td></tr>

<?php
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '' ; // assign '' or any default value;
   if (!$referer == '') {
      echo '<tr><td><br/><a href="' . $referer . '" title="Return to the previous page">&laquo; Go back</a></td></tr>';
   } else {
      echo '<tr><td><br/><a href="javascript:history.go(-1)" title="Return to the previous page">&laquo; Go back</a></td></tr>';
   }
?>
<tr><td><br/>
<a href="<?php echo $_SERVER['PHP_SELF']."?viewall=viewall"; ?>">View list</a>
</td></tr>

<tr><td>
<a href="<?php  echo $_SERVER['PHP_SELF']; ?>">Main Menu</a>
</td></tr>
    </form>
</table>

<?php
}
}

// show a list of all users

} elseif($viewall){
 // display list of users
$result_all = $con->query("SELECT customer_id, email FROM customer order by email LIMIT $offset, $limit");

print("There are currently <b>$total</b> Users.");
print("<br/><br/>\n");

while ($myrow = $result_all->fetch_array()) {
printf("<a href=\"%s?uid=%s\">%s</a><br/>\n", $_SERVER['PHP_SELF'],
$myrow["customer_id"], $myrow["email"]);
}

print "<br/>". get_nav($offset, $limit, $total);

?>
</td></tr>

<tr><td><br/>
<a href="<?php echo $_SERVER['PHP_SELF']."?viewall=viewall"; ?>">View list</a>
</td></tr>

<tr><td>
<a href="<?php echo $_SERVER['PHP_SELF']; ?>">Main Menu</a>
<?php

// main page of user admin application

} else{ 

print "";
print("There are currently <b>$total</b> Users.");
print("<br/><br/>\n");
print "Search by letter<p>";

for ($i = 65 ; $i < 91 ; $i++){

// if $i is non-zero and is divisible by 5 print a line break.
//# Create a new row every five columns
if (($i % 5 == 0) && ($i!=0)){
 echo "<br />";
}
//# Add a column
printf ('<a href = "%s?let=%s">%s</a> ', $_SERVER['PHP_SELF'], chr($i+32), chr($i));
}
 
?>
<br/><br/>
<form method="post" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
Search for: <input type="text" name="searchwords" value=""><br>
<input type="submit" name="finduser" value="Find User">
</form>

<br/><br/> Or View all Users
<form method="post" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
<input type=submit name="viewall" value="Viewall">
</form>

<?php
}
?>
</td></tr>
</table>

<?php

echo "<p><a href=\"logout.php\">Logout</a></p>";


function get_nav($offset, $limit, $totalnum, $type = "normal") {
$navigation ='';
    if ($totalnum > $limit) {
    
//sprintf() returns the result as a formatted string vs
//printf() outputs the result as a formatted string
//if you use printf instead of sprintf in the function you will notice a number
//being output along with everything else, this is because printf returns
//the length of the outputted string.

 $navigation .= sprintf('<table><tr><td>');
    // Print File # - # of # (Customize to your need here)
 $navigation .= sprintf('Record(s) %s', ( $offset + 1 ));
      $navigation .= sprintf(' - ');
    if( $offset + $limit >= $totalnum ){
      $navigation .= sprintf($totalnum);
    }else{ $navigation  .= sprintf ( $offset + $limit ); }
$navigation .= sprintf(' of %s    |   </td>', $totalnum);

$navigation .= sprintf('<td>Page </td>',"\n");

//print previous
if ($offset != 0) {
    $boffset = $offset-$limit;
if($type=='letter'){
$navigation .= sprintf('<td><a href="%s?let=%s&offset=%s"><<</a></td>',
        $_SERVER['PHP_SELF'],$GLOBALS['let'],$boffset);
}elseif($type =='usersearch'){
$navigation .= sprintf('<td><a href="%s?finduser=yes&offset=%s&searchwords=%s"><<</a></td>',
        $_SERVER['PHP_SELF'],$boffset,urlencode($GLOBALS['searchwords']));
}
else{
$navigation .= sprintf('<td><a href="%s?viewall=viewall&offset=%s"><<</a></td>',
$_SERVER['PHP_SELF'],$boffset);
}
}

// calculate number of pages needing links
$pages = intval($totalnum/$limit);

// $pages now contains int of pages needed unless there is a remainder from division
if ($totalnum%$limit) $pages++;

//print pages
for ($i=1; $i <= $pages; $i++) { // loop thru
$newoffset=$limit*($i-1);
if ($newoffset != $offset) {
if($type=='letter'){
$navigation .= sprintf('<td><a href="%s?let=%s&offset=%s">%s</a></td>%s',
        $_SERVER['PHP_SELF'], $GLOBALS['let'], $newoffset, $i, "\n");
}
elseif($type =='usersearch'){
$navigation .= sprintf('<td><a href="%s?finduser=yes&offset=%s&searchwords=%s">%s</a></td>%s',
    $_SERVER['PHP_SELF'], $newoffset,urlencode($GLOBALS['searchwords']), $i, "\n");
}
else{
$navigation .= sprintf('<td><a href="%s?viewall=viewall&offset=%s">%s</a></td>%s',
$_SERVER['PHP_SELF'], $newoffset, $i, "\n");
}
}
else {
$navigation .= sprintf('<td>%s</td>%s', $i, "\n");
}
}

//print next
$noffset = $pages*$limit-$limit;
if ($offset != $noffset){
    $boffset = $offset+$limit;
if($type=='letter'){
$navigation .= sprintf('<td><a href="%s?let=%s&offset=%s">>></a></td>',
        $_SERVER['PHP_SELF'], $GLOBALS['let'], $boffset);
}
elseif($type =='usersearch'){
$navigation .= sprintf('<td><a href="%s?finduser=yes&offset=%s&searchwords=%s">>></a></td>',
        $_SERVER['PHP_SELF'], $boffset,urlencode($GLOBALS['searchwords']));
}
else{
$navigation .= sprintf('<td><a href="%s?viewall=viewall&offset=%s">>></a></td>',
        $_SERVER['PHP_SELF'], $boffset);
}
}
$navigation .= sprintf('</tr></table>');
}

else {
$navigation = "";
}
 
return $navigation;
}

?>