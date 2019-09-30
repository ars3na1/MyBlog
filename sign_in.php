<?php
error_reporting(E_ALL & ~E_NOTICE);
include 'BD.php';
$massage = "";
if(isset($_POST["pass"]) || isset($_POST["username"])){
  $massage = "Username is already taken or your password confirmation is wrong!";
}
if(strlen($_POST["pass"]) > 0 && strlen($_POST["username"]) > 0 && $_POST["pass"] == $_POST["cpass"]) {
  $username = mysqli_escape_string($con, $_POST["username"]);
  $pass = mysqli_escape_string($con, $_POST["pass"]);
  $hash_pass = hash('sha512', $pass);

  $sign_in = mysqli_query($con, "INSERT INTO users (`username`, `password`) VALUES ('$username', '$hash_pass')");
  if (mysqli_affected_rows($con) > 0) {
	  header('Location: login.php');
  }

}
?>

<html>
<head>
	<title>SING IN</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
	<style type="text/css">
		#container {
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
<header> <h2>Sign in to My blog</h2> </header>
	<nav> <ul>
		<li class="leftLinks bigLinks"><a href="index.php"><img class="linkImages borderStrong" src="home.jpg"></a></li>
		<li class="rightLinks bigLinks"><a class="blue" href="login.php">LOG IN</a></li>
		
		</ul>
	</nav>
		<form method="post" action="sign_in.php" class="usersForm">
			<p>Username:</p> <input type="text" name="username">
			<p>Password:</p> <input type="password" name="pass">
			<p>Confirm Pass:</p> <input type="password" name="cpass"></br>
			<input type="submit" value="SIGN IN" class="button">
			<?php if(is_string($massage) && strlen($massage) > 0) {
				echo '<p class = massage>' . $massage . '</p>';
			} ?>
			</form>
		</div>
</body>
</html>