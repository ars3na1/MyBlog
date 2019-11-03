<?php
error_reporting(E_ALL & ~E_NOTICE);
include 'BD.php';
$category=mysqli_query($con, "SELECT DISTINCT  `Category` FROM `blog articles`");
$defCat = $_GET['category'];
$a = mysqli_escape_string($con, $_GET['id']);

$get_art = mysqli_query($con, "SELECT `title`,`text` FROM `blog articles` WHERE `id` = '$a'");

$b = mysqli_fetch_assoc($get_art);

if(isset($_GET["id"]) && isset($_POST["editTitle"]) && isset($_POST["editText"]) && isset($_POST["editCategory"]) ) {
$ArtID = mysqli_escape_string($con, $_GET["id"]);
$new_art_title = mysqli_escape_string($con, $_POST["editTitle"]);
$new_art_text = mysqli_escape_string($con, $_POST["editText"]);
$new_cat = mysqli_escape_string($con, $_POST["editCategory"]);

$article_edit=mysqli_query($con, "UPDATE `blog articles` SET `title` = '$new_art_title', `text` = '$new_art_text', `Category` = '$new_cat' WHERE `id` = '$ArtID'");
	
	if(mysqli_affected_rows($con)) {
		header('Location: article.php?id='.$a);
	}
}

?>


<html>
	<head>
		<title>Edit news</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="assets\style.css">
		<style type="text/css">
			#editArticle {
				margin: auto;
			}
			#container {
				overflow: auto;
			}
			input, textarea {
				margin: 10px;
			}
			p {
				margin: 15px;
			}
			.maintext {
				max-width: 300px;
			}
			.paragraph {
				font-weight: bold;
			}
			.textCenter {
				text-align: center;
			}
		</style>
	</head>
	<body>
		<div id="container">
			<header><h2>Edit article</h2></header>
			<nav><a href="index.php"><img class="linkImages" src="assets\home.jpg"></a></nav>
			<form id="editArticle" method="post" action="editArt.php?id=<?php echo $a?>">
				<p class="paragraph">Title:</p> <input class="smallText textCenter" type="text" name="editTitle" value="<?php echo $b['title']?>">
				<p class="paragraph">Category:</p>
				<select name="editCategory" value="<?php echo $defCat?>">
<?php while ($cat = mysqli_fetch_assoc($category))  {
	echo '<option value="' . $cat['Category'] . '"'; 
	if ($defCat == $cat['Category']) echo "selected"; 
	echo '>' . $cat['Category'] . '</option>';
}?>
</select> 
				<p class="paragraph">Text:</p> <textarea class="mainText" name="editText"><?php echo $b['text']?></textarea><br>
				<input class="button" type="submit" value="Confirm">
			</form>
		</div>
	</body>
</html>