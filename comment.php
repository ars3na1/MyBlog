<?php
include 'BD.php';
$name = $_POST["user_name"];
$comment = $_POST["comment"];
$id = $_GET["id"];

$stmt = $con->prepare("INSERT INTO `loremipsum_comments` (`name`, `comment`, `id`) VALUES (?, ?, ?)");
$stmt->bind_param('ssi', $name, $comment, $id);
$stmt->execute();

header('Location: article.php?id=' . $id);
