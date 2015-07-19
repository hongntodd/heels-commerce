<?php
include("includes/functions.php");
// PDO connect *********
$pdo = connect();
$keyword = '%'.$_POST['keyword'].'%';
$sql = "SELECT * FROM product WHERE product_name LIKE (:keyword) ORDER BY product_id ASC LIMIT 0, 10";
$query = $pdo->prepare($sql);
$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$query->execute();
$list = $query->fetchAll();
foreach ($list as $rs) {
	// put in bold the written text
	$country_name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['product_name']);
	$country_id = $rs['product_id'];
	// add new option
    echo '<li onclick="set_item(\''.str_replace("'", "\'", $rs['product_name']).'\')"><a href="product_details.php?product_id='.$country_id.'">'.$country_name.'</a></li>';
}
?>