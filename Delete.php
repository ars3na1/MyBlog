<?php
include 'BD.php';

if(isset($_GET["id"])) {
$article_id = mysqli_escape_string($con, $_GET["id"]);
	if (is_numeric($article_id) && $article_id > 0){
$delete_a=mysqli_query($con, "DELETE FROM `blog articles` WHERE id='$article_id'");
	}
} else if(isset($_GET["Category"])) {
$category = mysqli_escape_string($con, $_GET["Category"]);
	if(is_string($category) && strlen($category) > 0) {
$delete_c=mysqli_query($con, "DELETE FROM `blog articles` WHERE category='$category'");
	}
}

if(mysqli_affected_rows($con)) {
	header('Location: index.php');
}
?>
