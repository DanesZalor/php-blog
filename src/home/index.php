<?php require $_SERVER['DOCUMENT_ROOT'] . '/common/actionloaddb.php' ?>
<?php
session_start();

// if 'session_user' doesn't exist, go back to login
if (
    !array_key_exists('session_user', $_SESSION) || 
    !array_key_exists('session_pw', $_SESSION)
) header("Location: /login");
?>
<html>

<head>
    <title>php_blog - HOME</title>
    <link rel="stylesheet" href="/home/home.css" type="text/css">
</head>

<body>
    <h1>php_blog</h1>
    <a href="/home/actionlogout.php">Logout</a>
    <div id="postingForm">
        <p>
            <textarea id="postingForm_content" 
                placeholder="what are you thinking about?" 
                maxlength="1000" required="true">
            </textarea>
        </p>
        <p><button id="postButton">POST</button></p>
    </div>

    <div id="blogfeed">
        <!-- put blogfeed doms goes here -->
    </div>

    <script type="text/javascript">
        var user = {
            username: '<?php echo $_SESSION['session_user'] ?>',
            password: '<?php echo $_SESSION['session_pw'] ?>'
        };
    </script>
    <script src="home/index.js"></script>
</body>

</html>