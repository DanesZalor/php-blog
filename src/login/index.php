<?php require $_SERVER['DOCUMENT_ROOT'] . '/common/actionloaddb.php' ?>
<?php
// if this client has logged in alr, go /home
if (array_key_exists('session_user', $_SESSION)) header("Location: /home");

if (array_key_exists('newly_registered_user', $_SESSION)) $_POST['INPUT_USERNAME'] = $_SESSION['newly_registered_user'];
?>
<html>

<head>
    <title>php_blog - Login</title>
</head>

<body>
    <h1>Login</h1>

    <form method="post">
        <p class="inputField">
            <label>username: </label>
            <input type="text" name="INPUT_USERNAME" value=<?php echo $_POST['INPUT_USERNAME']; ?>>
            </input>
        </p>
        <p class="inputField">
            <label>password: </label>
            <input type="password" name="INPUT_PASSWORD" value=<?php echo $_POST['INPUT_PASSWORD']; ?>>
            </input>
        </p>
        <p class="inputFieldFooter">
            <button type="submit" name="submit" value="submit">Log In</button>
            <a href="/register"> Register </a>
        </p>
    </form>
    <?php

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $query_res = db_query("SELECT * from account WHERE username='${_POST['INPUT_USERNAME']}' AND password='${_POST['INPUT_PASSWORD']}'");

        if ($query_res->rowCount() == 1) {
            $_SESSION['session_user'] = $_POST['INPUT_USERNAME'];
            header("Location: /home");
        } else echo "<p>wrong credentials</p>";
    }
    ?>
</body>

</html>