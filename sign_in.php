<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
include 'BD.php';
$massage = "";
if(isset($_POST["pass"]) || isset($_POST["username"])){
  $massage = "Username is already taken or your password confirmation is wrong!";
}
if(strlen($_POST["pass"]) > 0 && strlen($_POST["username"]) > 0 && $_POST["pass"] === $_POST["cpass"]) {

  $stmt = $con->prepare("INSERT INTO users (`username`, `password`) VALUES (?, ?)");
  $stmt->bind_param("ss", $username, $pass);
  $username = $_POST["username"];
  $pass = hash('sha512', $_POST["pass"]);
  $stmt->execute();

  if (mysqli_affected_rows($con) > 0) {
  	$_SESSION["CURRENT_USER"] = $_POST["username"];
	  header('Location: index.php');
 }

}
?>

<html>
<head>
	<title>SING IN</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="assets\style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript">
			$(document).ready(function() {
				$("#pass").keypress(function() {
					var a = $("#pass").val();
					var pass = a.trim();
					if(pass.length <= 6 ) {
						$("#lengthCheck").css("visibility", "visible");					
				} else {
						$("#lengthCheck").css("visibility", "hidden");
				}})
						$("#cpass").keypress(function() {
							var b = $('input[name="cpass"]').val();
							var str = b.trim();
							if (str.length > 6 ) {
								$("#signInButton").prop("disabled", false);
							} else {
								$("#signInButton").prop("disabled", true);
							}
						})
					})
		</script>
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
		#lengthCheck {
			visibility: hidden;
		}	
	</style>
</head>
<body>
<div id="container">
<header> <h2>Sign in to My blog</h2> </header>
	<nav> <ul>
		<li class="leftLinks bigLinks"><a href="index.php"><img class="linkImages borderStrong" src="assets\home.jpg"></a></li>
		<li class="rightLinks bigLinks"><a class="blue" href="login.php">LOG IN</a></li>
		
		</ul>
	</nav>
		<form method="post" action="sign_in.php" class="usersForm">
			<p>Username:</p> <input type="text" name="username">
			<p>Password:</p> <input type="password" id="pass" name="pass">
			<p id="lengthCheck">Must be at least 8 characters!</p>
			<p>Confirm Pass:</p> <input type="password" id="cpass" name="cpass"></br>
			<input type="submit" value="SIGN IN" id="signInButton" class="button" disabled>
			<?php if(is_string($massage) && strlen($massage) > 0) {
				echo '<p class = massage>' . $massage . '</p>';
			} ?>
			</form>
		</div>
</body>
</html>
