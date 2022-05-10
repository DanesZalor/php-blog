<?php
session_start();
$pdo = new PDO( // pgsql db connect
    "pgsql:host=${_SESSION['db_host']};port=5432;dbname=${_SESSION['db_name']};",
    $_SESSION['db_user'],
    $_SESSION['db_pass']
);

if (!$pdo) die("cant connect to pqsql db");

session_Start();

$postTime = date('Y/m/d H:i:s');
$postAuthor = $_SESSION['session_user'];
$postContent = trim($_POST['postContent']);

$pdo->query("INSERT INTO blogpost (posttime, poster, content) VALUES ('${postTime}', '${postAuthor}', '${postContent}')");

header("Location: /home/index.php");
