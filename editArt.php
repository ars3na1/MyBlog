<?php
error_reporting(E_ALL & ~E_NOTICE);
include 'BD.php';

$id = $_GET['id'];
$defCat = $_GET['category'];

$stmt = $con->prepare("SELECT `title`, `text` FROM `blog articles` WHERE `id` = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$a = $stmt->get_result();
$art = $a->fetch_assoc();
$stmt->close();

if(isset($_GET["id"]) && isset($_POST["editTitle"]) && isset($_POST["editText"]) && isset($_POST["editCategory"]) ) {
	$stmt = $con->prepare("UPDATE `blog articles` SET `title` = ?, `text` = ?, `Category` = ? WHERE `id` = ?");
	$stmt->bind_param('sssi', $_POST["editTitle"], $_POST["editText"], $_POST["editCategory"], $id);
	$stmt->execute();
	
	if(mysqli_affected_rows($con)) {
		header('Location: article.php?id=' . $id);
	}
}
$stmt = $con->prepare("SELECT DISTINCT  `Category` FROM `blog articles`");
$stmt->execute();
$category = $stmt->get_result();
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
			<form id="editArticle" method="post" action="editArt.php?id=<?php echo $id?>">
				<p class="paragraph">Title:</p> <input class="smallText textCenter" type="text" name="editTitle" value="<?php echo $art['title']?>">
				<p class="paragraph">Category:</p>
				<select name="editCategory" value="<?php echo $defCat?>">
<?php while ($cat = $category->fetch_assoc())  {
	echo '<option value="' . $cat['Category'] . '"'; 
	if ($defCat == $cat['Category']) echo "selected"; 
	echo '>' . $cat['Category'] . '</option>';
}
$stmt->close();
?>
</select> 
				<p class="paragraph">Text:</p> <textarea class="mainText" name="editText"><?php echo $art['text']?></textarea><br>
				<input class="button" type="submit" value="Confirm">
			</form>
		</div>
	</body>
</html>
