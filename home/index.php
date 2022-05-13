<?php require $_SERVER['DOCUMENT_ROOT'] . '/common/actionloaddb.php' ?>
<?php
session_start();

// if 'session_user' doesn't exist, go back to login
if (!array_key_exists('session_user', $_SESSION)) header("Location: /login");
?>
<html>

<head>
    <title>php_blog - HOME</title>
    <link rel="stylesheet" href="/home/home.css" type="text/css">
</head>

<body>
    <h1>php_blog</h1>
    <a href="/home/actionlogout.php">Logout</a>
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

    if (!$dbc) die("cant connect to pqsql db");

    $query_res = $dbc->query("SELECT * FROM blogpost ORDER BY posttime DESC");

    foreach ($query_res as $row)
        printBlogPost($row['poster'], $row['posttime'], $row['content']);

    ?>
</body>

</html>