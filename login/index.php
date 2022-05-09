<?php
session_start();

// if this client has logged in alr, go /home
if (array_key_exists('session_user', $_SESSION)) header("Location: /home");
?>
<html>

<head>
    <title>php_blog - Login</title>
</head>

<body>
    <h1>Login</h1>

    <form method="post">
        <p>
            <label>username: </label>
            <input type="text" name="INPUT_USERNAME" value=<?php echo $_POST['INPUT_USERNAME']; ?>>
            </input>
        </p>
        <p>
            <label>password: </label>
            <input type="password" name="INPUT_PASSWORD" value=<?php echo $_POST['INPUT_PASSWORD']; ?>>
            </input>
        </p>
        <button type="submit" name="submit" value="submit">Log In</button>
    </form>
    <?php

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $conn = new mysqli("localhost", "djdols", "djdols");
        if ($conn->connect_error) die("can't connect to DB");

        $query_res = $conn->query(
            "SELECT * FROM php_blog.account WHERE username = \"${_POST['INPUT_USERNAME']}\" AND password = \"${_POST['INPUT_PASSWORD']}\""
        );

        if ($query_res->num_rows == 1) {
            $_SESSION['session_user'] = $_POST['INPUT_USERNAME'];
            header("Location: /home");
        } else echo "<p>wrong credentials</p>";
    }
    ?>
</body>

</html>