<?php
error_reporting(E_ALL & ~E_NOTICE);
include 'BD.php';
$a = mysqli_escape_string($con, $_GET['id']);

$get_art = mysqli_query($con, "SELECT `title`,`text` FROM `blog articles` WHERE `id` = '$a'");

$b = mysqli_fetch_assoc($get_art);

if((isset($_POST["editCatOld"]) && isset($_POST["editCatNew"])) || (isset($_GET["id"]) && isset($_POST["editArtNew"]) && isset($_POST["newtext"]))) {
$old_cat = mysqli_escape_string($con, $_POST["editCatOld"]);
$new_cat = mysqli_escape_string($con, $_POST["editCatNew"]);
$ArtID = mysqli_escape_string($con, $_GET["id"]);
$new_art_title = mysqli_escape_string($con, $_POST["editArtNew"]);
$new_art_text = mysqli_escape_string($con, $_POST["newtext"]);

$category_change=mysqli_query($con, "UPDATE `blog articles` SET `category` = '$new_cat' WHERE `category` = '$old_cat'");
$article_edit=mysqli_query($con, "UPDATE `blog articles` SET `title` = '$new_art_title', `text` = '$new_art_text' WHERE `id` = '$ArtID'");
	
	if(mysqli_affected_rows($con)) {
		header('Location: article.php?id='.$a);
	}
}

?>


<html>
	<head>
		<title>Edit news</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<style type="text/css">
			#editArticle {
				float: left;
				margin: 80px;
			}
			#editCategory {
				float: right;
				margin: 80px;
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
				margin: 15px;
				font-size: 20px;
			}
			.textCenter {
				text-align: center;
			}
		</style>
	</head>
	<body>
		<div id="container">
			<header><h2>Edit article or category</h2></header>
			<nav><a href="index.php"><img class="linkImages" src="home.jpg"></a></nav>
			<form id="editCategory" method="post" action="edit.php">
				<p class="paragraph">Category edit:</p>
				<p>Old name of category:</p> <input class="smallText textCenter" type="text" name="editCatOld" value="<?php echo $_GET['Category']?>">
				<p>New name of category:</p> <input class="smallText textCenter" type="text" name="editCatNew"><br>
				<input class="button" type="submit" value="Confirm">
			</form>
			<form id="editArticle" method="post" action="edit.php?id=<?php echo $a?>">
				<p class="paragraph">Edit article:</p>
				 
				<p>Title:</p> <input class="smallText textCenter" type="text" name="editArtNew" value="<?php echo $b['title']?>"> 
				<p>Text:</p> <textarea class="mainText" name="newtext"><?php echo $b['text']?></textarea><br>
				<input class="button" type="submit" value="Confirm">
			</form>
		</div>
	</body>
</html>

