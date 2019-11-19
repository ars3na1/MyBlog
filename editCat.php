<?php
error_reporting(E_ALL & ~E_NOTICE);
include 'BD.php';

if(isset($_POST["editCatOld"]) && isset($_POST["editCatNew"])) {
$old_cat = $_POST["editCatOld"]);
$new_cat = $_POST["editCatNew"]);

$stmt = $con->prepare("UPDATE `blog articles` SET `category` = ? WHERE `category` = ?");

	
	if(mysqli_affected_rows($con)) {
		header('Location: index.php');
	}
}

?>


<html>
	<head>
		<title>Edit news</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="assets\style.css">
		<style type="text/css">
			#editCategory {
				margin: auto;
			}
			#container {
				overflow: auto;
			}
			input, textarea {
				margin: 10px;
			}
			.maintext {
				max-width: 300px;
			}
			.paragraph {
				font-weight: bold;
				margin: 11px;
				font-size: 18px;
			}
			.textCenter {
				text-align: center;
			}
		</style>
	</head>
	<body>
		<div id="container">
			<header><h2>Edit category</h2></header>
			<nav><a href="index.php"><img class="linkImages" src="assets\home.jpg"></a></nav>
			<form id="editCategory" method="post" action="editCat.php">
				<p class="paragraph">Old name of category:</p> <input class="smallText textCenter" type="text" name="editCatOld" value="<?php echo $_GET['Category']?>">
				<p class="paragraph">New name of category:</p> <input class="smallText textCenter" type="text" name="editCatNew"><br>
				<input class="button" type="submit" value="Confirm">
			</form>
		</div>
	</body>
</html>

