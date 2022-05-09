<?php
session_start();

// if 'session_user' doesn't exist, go back to login
if (!array_key_exists('session_user', $_SESSION)) header("Location: /login");
?>
<html>

<head>
    <title>php_blog - HOME</title>
    <link rel="stylesheet" href="home.css" type="text/css">
</head>

<body>
    <h1>php_blog</h1>
    <form class="postingForm" method="post" action="/home/actionpost.php">
        <p>
            <textarea name="postContent" placeholder="what are you thinking about?" maxlength="1000" required="true"></textarea>
        </p>
        <p>
            <button class="postButton" type="submit" name="submit">POST</button>
        </p>
    </form>
    <?php
    //echo $_SESSION['session_user'];
    function printBlogPost($author, $timePost, $content)
    {
        echo "<div class=\"blogpost\">
            <p> <span class=\"author\">${author}</span> <span class=\"time\">@${timePost}</span></p>
            <p class=\"content\">${content}</p> 
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