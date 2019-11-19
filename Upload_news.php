<?php
include 'BD.php';
$massage = "";
$picMassage = "";
$picId = 0;
$artId = 0;

if (isset($_POST["title"]) || isset($_POST["text"]) || isset($_POST["category"])) {
	$massage = "News upload is not succesful, please try again";
} 
if (isset($_POST["title"]) && isset($_POST["text"]) && isset($_POST["category"]) && isset($_FILES['picture'])){
$title = $_POST["title"];
$text = $_POST["text"];
$category = $_POST["category"]; 

	if (strlen($_POST["title"]) > 0 && strlen($_POST["text"]) > 0 && strlen($_POST["category"]) > 0){
$stmt = $con->prepare("INSERT INTO `blog articles` (`title`, `text`, `category`) VALUES (?, ?, ?)");
$stmt->bind_param('sss', $title, $text, $category);
$stmt->execute();
$stmt->close();

$stmt = $con->prepare("SELECT `ID` FROM `blog articles` ORDER BY `last edited` DESC LIMIT 1");
$stmt->execute();
$result = $stmt->get_result();
$res = $result->fetch_assoc();
$picId = $res['ID'];
$artId = $res['ID'];
	}
	if (isset($_FILES['picture'])) {
	$error_types = array(	
    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
    3 => 'The uploaded file was only partially uploaded.',
    4 => 'No file was uploaded.',
    6 => 'Missing a temporary folder.',
    7 => 'Failed to write file to disk.',
    8 => 'A PHP extension stopped the file upload.'
);
	$ext_error = false;
	$extensions = array('jpg');
	$file_ext = explode('.', $_FILES['picture']['name']);
	$file_ext = end($file_ext);
	
	if (!in_array($file_ext, $extensions)) {
		$ext_error = true;
	}

	if($_FILES['picture']['error'] > 0) {
		$picMassage = $error_types[$_FILES['picture']['error']];
	} else if($ext_error === true) {
		$picMassage = "Invalid file extension! Only .jpg pictures allowed.";
	} else {
	move_uploaded_file($_FILES['picture']['tmp_name'], 'artPictures/' . $picId . '.' . $file_ext);
		header('Location: article.php?id=' . $artId);
	}
  }
}
	
?>

<html>
	<head>
		<title>Upload news</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="assets\style.css">
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
		<li class="bigLinks"><a href="index.php"><img class="linkImages" src="assets\home.jpg"></a></li>
		</ul>
		</nav>
		<form method="post" enctype="multipart/form-data" action="Upload_news.php">
			<p>Title:</p> <textarea name="title" class="smallText"></textarea>
			<p>Picture:</p> <input type="file" name="picture"/>
			<p>Category:</p> <textarea name="category" class="smallText"></textarea>
			<p>Text:</p> <textarea name="text" class="mainText"></textarea></br>
			<input class="button" type="submit" value="Upload"/>
			<?php if (is_string($picMassage) && strlen($picMassage) > 0){
				echo '<p class = massage>' . $picMassage . '</p>';
			}
			if(is_string($massage) && strlen($massage) > 0) {
				echo '<p class = massage>' . $massage . '</p>';
			} 
			?>
		</form>
		</div>
	</body>
</html>
