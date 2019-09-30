<?php

require_once 'BD.php';
$id = mysqli_escape_string($con, $_GET["id"]);

$get_comment=mysqli_query($con, "SELECT `name`, `comment` FROM `loremipsum_comments` WHERE `id`='$id'");
$text=mysqli_query($con, "SELECT `title`,`text` FROM `blog articles` WHERE `id`='$id'");
$article=mysqli_fetch_assoc($text);

?>
<html>
	<head>
		<title>
			<?php echo $article['title'];
		?>
		</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<style type="text/css">
			h1 {
				text-align: center;
				margin: 20px;
			}
			form {
				margin: 15px;
			}
			.comments, .commentName {
				border: 1px solid #cccccc;
				padding: 3px;
				max-width: 250px;
				margin: 10px;
				height: 150px;
				overflow: auto;
				background-color: #f7ffff;
			}
			.commentName {
				height: 20px; 
				text-align: center;
				float: left;
				width: 200px;
			}
			.comments {
				margin-bottom: 45px;
			}
		</style>
	</head>
	<body>
		<div id="container">
			<header>
				<h2>My blog</h2>
				</header>
				<nav>
				<a href='index.php'><img class="linkImages" src="home.jpg"></a>	
				</nav>
			<article>
				<h1>
		<?php echo $article['title'];
		?>
				</h1>
				<p>
				<?php echo $article['text'];
				?>
				</p>
			</article>
			<aside>			
			<form method="post" action="comment.php?id=<?php echo $id?>">
			<p>Your name:</p> <input type="text" name="user_name"></br>
			<p>Your comment:</p> <textarea name="comment"></textarea></br>
			<input type="submit" value="Confirm">
			</form>
				<?php 
				while($row=mysqli_fetch_assoc($get_comment))
				{
				echo '<span class="commentName">'.$row['name']. ':'.'</span>
	<div class="comments">'.$row['comment'].'</div>';
				} 
		?>
			</aside>
		</div>
	</body>
	</html>