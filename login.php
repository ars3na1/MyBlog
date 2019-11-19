<?php
session_start();
include 'BD.php';
$massage = "";
if (isset($_POST["username"]) && isset($_POST["pass"])) {

	$stmt = $con->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
	$stmt->bind_param("ss", $username, $pass);

	$username = $_POST["username"];
	$pass = hash('sha512', $_POST["pass"]);

	$stmt->execute();
	$stmt->store_result();

	if ($stmt->num_rows() > 0) { 
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
		<link rel="stylesheet" type="text/css" href="assets\style.css">
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
		<li class="leftLinks bigLinks"><a href="index.php"><img class="linkImages borderStrong" src="assets\home.jpg"></a></li>
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
