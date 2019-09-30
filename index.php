<?php
session_start();
include 'BD.php';

$result=mysqli_query($con, 'SELECT `title`,`text`,`id` FROM `blog articles`');

$articles = [];
while($art=mysqli_fetch_assoc($result)){
	$articles[] = [
		'title' => $art['title'],
		'text' => $art['text'],
		'id' => $art['id'],
	];
}

$kol=mysqli_query($con, "SELECT DISTINCT  `Category` FROM `blog articles`");
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
	<link rel="stylesheet" type="text/css" href="style.css"> 
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
		<li><a href="index.php"><img class="linkImages" src="home.jpg"></a></li>
<?php
	if (isset($_SESSION["CURRENT_USER"])) {
		echo '<li id="hide"><a href="Upload_news.php"><img class="linkImages hover" src="write_new.png"><span class="textShow">Upload news</span></a></li>';
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
	$id = mysqli_escape_string($con, $_GET["Category"]);
	$result_home = mysqli_query($con, "SELECT * FROM `blog articles` WHERE `Category`='$id' ORDER BY `last edited` DESC");
}
else 
{
	$result_home = mysqli_query($con, 'SELECT * FROM `blog articles` ORDER BY `last edited` DESC');
}
while($row = mysqli_fetch_assoc($result_home)) 
{
	echo '<tr>
	<td>' . $row['Category'] . '</td>
	<td>' . $row['title'] . '</td>
	<td>' . $row['last edited'] . '</td>
	<td><a href="article.php?id=' . $row['ID'] . '"><img src="read.png"></a></td>';
	
	if (isset($_SESSION['CURRENT_USER'])) {

	echo '<td><a href="edit.php?id=' . $row['ID'] . '"><img src="edit.png"></a></td>
	<td><a href="delete.php?id=' . $row['ID'] . '" onclick="return checkDelete()"><img class="deleteButton" src="delete.jpg"></a></td>
	</tr>';
	}
} 
?>
	</table>
	
	<table>
	<tr>
		<th>Category</th> <?php if (isset($_SESSION["CURRENT_USER"])) {
			echo '<th>Edit</th><th>Delete</th>';
		}
		?>
	</tr>
		<?php while($cat = mysqli_fetch_assoc($kol)) {
	echo '<tr>
	<td><a href="index.php?Category=' . $cat['Category'] . '">' . $cat['Category'] . '</a></td>';
	if (isset($_SESSION["CURRENT_USER"])) {
		echo '<td><a href="edit.php?Category=' . $cat['Category'] . '"><img src="edit.png"></a></td>
		<td><a href="delete.php?Category=' . $cat['Category'] . '" onclick="return checkDelete()"><img class="deleteButton" src="delete.jpg"></a></td>
		</tr>';	
	}
	 
}
?>

</div>
</body>
</html>
