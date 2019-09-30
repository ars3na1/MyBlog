<?php
include 'BD.php';
$name = mysqli_escape_string($con, $_POST["user_name"]);
$comment = mysqli_escape_string($con, $_POST["comment"]);
$id = mysqli_escape_string($con, $_GET["id"]);

$comment_input=mysqli_query($con, "INSERT INTO `loremipsum_comments` (`name`, `comment`, `id`) VALUES ('$name', '$comment', '$id')");

header('Location: article.php?id='.$id);