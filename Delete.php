<?php
include 'BD.php';

if (isset($_GET["id"])) {
$art_id = $_GET["id"];
	if (is_numeric($art_id) && $art_id > 0){
$stmt = $con->prepare("DELETE FROM `blog articles` WHERE id = ?");
$stmt->bind_param('i', $art_id);
$stmt->execute();
$stmt->close();
	}
} else if (isset($_GET["Category"])) {
$cat = $_GET["Category"];
	if(is_string($cat) && strlen($cat) > 0) {
$stmt = $con->prepare("DELETE FROM `blog articles` WHERE category = ?");
$stmt->bind_param('s', $cat);
$stmt->execute();
	}
}
if(mysqli_affected_rows($con)) {
	header('Location: index.php');
}
?>
