<!DOCTYPE html>
<html>
<head>
	<title> Pictures </title>
</head>
<body>
<?php if (isset($_FILES['picture'])) {
	print_r($_FILES);
	move_uploaded_file($_FILES['picture']['tmp_name'], 'artPictures/' . $_FILES['picture']['name']);
}
?>

<form method="post" enctype="multipart/form-data" action="">
	<p>Picture:</p> <input type="file" name="picture" />
	<input class="button" type="submit" value="Upload" />
</form>
</body>
</html>