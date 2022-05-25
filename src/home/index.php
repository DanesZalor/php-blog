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
    <div class="postingForm">
        <p>
            <textarea name="postContent" placeholder="what are you thinking about?" maxlength="1000" required="true"></textarea>
        </p>
        <p>
            <button class="postButton" type="submit" name="submit">POST</button>
        </p>
    </div>
</body>

</html>