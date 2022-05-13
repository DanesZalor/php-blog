<?php require $_SERVER['DOCUMENT_ROOT'] . '/common/actionloaddb.php' ?>
<?php
session_start();

$postTime = date('Y/m/d H:i:s');
$postAuthor = $_SESSION['session_user'];
$postContent = trim($_POST['postContent']);

db_query("INSERT INTO blogpost (posttime, poster, content) VALUES ('${postTime}', '${postAuthor}', '${postContent}')");

header("Location: /home/index.php");
