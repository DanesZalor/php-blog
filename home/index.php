<?php
session_start();

// if 'session_user' doesn't exist, go back to login
if (!array_key_exists('session_user', $_SESSION)) header("Location: /login");
?>
<html>

<head>
    <title>php_blog - HOME</title>
</head>

<body>
    <h1>php_blog</h1>
    <form method="post" action="/home/actionpost.php">
        <p>
            <textarea name="postContent" placeholder="what are you thinking about?" maxlength="1000" required="true" rows="4" cosl="100"></textarea>
        </p>
        <p>
            <button type="submit" name="submit">Post</button>
        </p>
    </form>
    <?php
    //echo $_SESSION['session_user'];
    function printBlogPost($author, $timePost, $content)
    {
        echo "<div>
            <p> <span>${author}</span> @<span>${timePost}</span></p>
            <p>${content}</p> 
        </div>";
    }

    $conn = new mysqli("localhost", "djdols", "djdols");
    if ($conn->connect_error) die("can't connect to DB");

    $res = $conn->query("SELECT * FROM php_blog.blogpost ORDER BY postTime DESC");
    foreach ($res->fetch_all(MYSQLI_ASSOC) as $row) {
        printBlogPost($row['poster'], $row['postTime'], $row['content']);
    }

    ?>
</body>

</html>