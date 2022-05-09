<?php

$conn = new mysqli("localhost", "djdols", "djdols");
if ($conn->connect_error) die("can't connect to DB");

session_Start();

$postTime = date('Y/m/d H:i:s');
$postAuthor = $_SESSION['session_user'];
$postContent = trim($_POST['postContent']);

$conn->query("INSERT INTO php_blog.blogpost (postTime, poster, content) VALUES (\"${postTime}\", \"${postAuthor}\", \"${postContent}\")");

header("Location: /home/index.php");
