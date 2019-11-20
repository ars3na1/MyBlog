<?php
session_start();
include 'BD.php';
$stmt = $con->prepare('SELECT `title`,`text`,`id` FROM `blog articles`');
$stmt->execute();
$result = $stmt->get_result();

$articles = [];
while($art = $result->fetch_assoc()){
	$articles[] = [
		'title' => $art['title'],
		'text' => $art['text'],
		'id' => $art['id'],
	];
}
$stmt->close();
?>

<html>
<head> 
	<title> My blog </title>
	<meta charset="utf-8">
	<script>
function checkDelete(){
    return confirm('Are you sure you want to delete this?');
}
	</script>
	<link rel="stylesheet" type="text/css" href="assets\style.css"> 
	<style type="text/css">
		td, th {
			border: 1px solid #939393;
			padding: 7px;
			max-width: 250px;
			overflow: hidden;
		}
		table {
			border-collapse: collapse;
			max-height: 800px;
			overflow: auto;
			margin: 20px auto;
			}
		li {
			display: inline-block;
			margin: 10px;
		}
		img {
			height: 30px;
			width: 30px;
		}
		tr:nth-child(even) {
			background-color: #ffffff;
		}	
		#hide:hover .textShow {
			visibility:visible;
			color: #000000;
		}
		#hide .textShow {
			position: relative;
			visibility: hidden;
		}
	</style>
</head>

<body>
  <div id="container">	
	<header><h2> My personal blog </h2></header>
	<nav><ul>
		<li><a href="index.php"><img class="linkImages" src="assets\home.jpg"></a></li>
<?php
	if (isset($_SESSION["CURRENT_USER"])) {
		echo '<li id="hide"><a href="Upload_news.php"><img class="linkImages hover" src="assets\write_new.png"><span class="textShow">Upload news</span></a></li>';
		echo '<li class="rightLinks"><a class="blue" href="Logout.php">LOG OUT</a></li>';
	}
	else {
		echo '<li class="rightLinks"><a class="blue" href="login.php">LOG IN</a></li>
		<li class="rightLinks"><a class="blue" href="sign_in.php">SIGN IN</a></li>';
	}
		
		?>
		</ul>
	</nav>
	

	<table>
		<tr>
			<th>Category</th><th>Title</th><th>Uploaded</th><th>View</th>
<?php 
	if	(isset($_SESSION["CURRENT_USER"])) {	
		echo '<th>Edit</th>
			<th>Delete</th>';
		}
?>		
		</tr>
<?php 
if(isset($_GET["Category"])) 
{
	$id = $_GET["Category"];
	$stmt = $con->prepare("SELECT * FROM `blog articles` WHERE `Category`= ? ORDER BY `last edited` DESC");
	$stmt->bind_param('s', $id);
	$stmt->execute();
	$result = $stmt->get_result();
}
else 
{
	$stmt = $con->prepare('SELECT * FROM `blog articles` ORDER BY `last edited` DESC');
	$stmt->execute();
	$result = $stmt->get_result();
}
while($row = $result->fetch_assoc()) 
{
	echo '<tr>
	<td>' . $row['Category'] . '</td>
	<td>' . $row['title'] . '</td>
	<td>' . $row['last edited'] . '</td>
	<td><a href="article.php?id=' . $row['ID'] . '"><img src="assets\read.png"></a></td>';
	
	if (isset($_SESSION['CURRENT_USER'])) {

	echo '<td><a href="editArt.php?id=' . $row['ID'] . '&category=' . $row['Category'] . '"><img src="assets\edit.png"></a></td>
	<td><a href="delete.php?id=' . $row['ID'] . '" onclick="return checkDelete()"><img class="deleteButton" src="assets\delete.jpg"></a></td>
	</tr>';
	}
}
$stmt->close(); 
?>
	</table>
	
	<table>
	<tr>
		<th>Category</th> <?php if (isset($_SESSION["CURRENT_USER"])) {
			echo '<th>Edit</th><th>Delete</th>';
		}
		?>
	</tr>
		<?php 
		$stmt = $con->prepare("SELECT DISTINCT  `Category` FROM `blog articles`");
		$stmt->execute();
		$category = $stmt->get_result();

		while($cat = $category->fetch_assoc()) {
	echo '<tr>
	<td><a href="index.php?Category=' . $cat['Category'] . '">' . $cat['Category'] . '</a></td>';
	if (isset($_SESSION["CURRENT_USER"])) {
		echo '<td><a href="editCat.php?Category=' . $cat['Category'] . '"><img src="assets\edit.png"></a></td>
		<td><a href="delete.php?Category=' . $cat['Category'] . '" onclick="return checkDelete()"><img class="deleteButton" src="assets\delete.jpg"></a></td>
		</tr>';	
	}
	 
}
$stmt->close();
?>

    </div>
  </body>
</html>
