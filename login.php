<?php
session_start();
include 'BD.php';
$massage = "";
if (isset($_POST["username"]) && isset($_POST["pass"])) {
	$user=mysqli_escape_string($con, $_POST["username"]);
	$pass=mysqli_escape_string($con, $_POST["pass"]);
	$pass2=hash('sha512', $pass);

	$user_logged = mysqli_query($con, "SELECT * FROM `users` WHERE `username`='$user' AND `password`='$pass2'");
	if (mysqli_num_rows($user_logged) > 0) { 
	    $_SESSION["CURRENT_USER"] = $_POST["username"];
        header('Location: index.php');
	}
	else {
		 $massage = "Your username or password is wrong, please try again";
	}
}
?>

<html>
	<head>
		<title>My blog- log in</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="style.css">
		<style type="text/css">
			#container{
				background: none;
				border: 0px;
			}
			input {
				margin: 7px;
			}
			.borderStrong {
				border: 1px solid #000000
			}
		</style>
	</head>
	<body>
	<div id="container">
		<header><h2>LOG IN</h2></header>
		<nav> <ul>
		<li class="leftLinks bigLinks"><a href="index.php"><img class="linkImages borderStrong" src="home.jpg"></a></li>
		<li class="rightLinks bigLinks"><a class="blue" href="sign_in.php">SIGN IN</a></li>
		</ul>
		</nav>
		<form method="post" action="login.php" class="usersForm">
			<p>Name:</p> <input type="text" name="username" class="in">
			<p>Password:</p> <input type="password" name="pass"><br>
			<input type="submit" value="Submit" class="button">
			<?php
				if (is_string($massage) && strlen($massage) > 0) {
					echo '<p class = "massage">' . $massage . '</p>';
				}
		?>
		</form>
	</div>
	</body>
</html>