<?php
include 'BD.php';
$massage = "";
if (isset($_POST["title"]) || isset($_POST["text"]) || isset($_POST["category"])) {
	$massage = "News upload is not succesful, please try again";
} 
if (isset($_POST["title"]) && isset($_POST["text"]) && isset($_POST["category"])){
$title = mysqli_escape_string($con, $_POST["title"]);
$text = mysqli_escape_string($con, $_POST["text"]);
$category = mysqli_escape_string($con, $_POST["category"]); 

	if (strlen($_POST["title"]) > 0 && strlen($_POST["text"]) > 0 && strlen($_POST["category"]) > 0){
$upload_news = mysqli_query($con, "INSERT INTO `blog articles` (`title`, `text`, `category`) VALUES ('$title', '$text', '$category')");

		if (mysqli_affected_rows($con) > 0) {
		  header('Location: index.php');
		}
	}
}	
?>

<html>
	<head>
		<title>Upload news</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="style.css">
		<style type="text/css">
			#container{
				background: none;
				border: 0px;
			}
			form {
				text-align: center;
				font-size: 18px;
			}
		</style>
	</head>
	<body>
		<div id="container"> 
		<header><h2>Upload news</h2></header>
		<nav> <ul>
		<li class="bigLinks"><a href="index.php"><img class="linkImages" src="home.jpg"></a></li>
		</ul>
		</nav>
		<form method="post" action="Upload_news.php">
			<p>Title:</p> <textarea name="title" class="smallText"></textarea>
			<p>Category:</p> <textarea name="category" class="smallText"></textarea>
			<p>Text:</p> <textarea name="text" class="mainText"></textarea></br>
			<input class="button" type="submit" value="Upload">
			<?php if(is_string($massage) && strlen($massage) > 0) {
				echo '<p class = massage>' . $massage . '</p>';
			} ?>
		</form>
		</div>
	</body>
</html>