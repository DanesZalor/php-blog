<?php require $_SERVER['DOCUMENT_ROOT'] . '/common/actionloaddb.php' ?>
<?php
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

        $pdo = new PDO( // pgsql db connect
            "pgsql:host=${_SESSION['db_host']};port=5432;dbname=${_SESSION['db_name']};",
            $_SESSION['db_user'],
            $_SESSION['db_pass']
        );

        if (!$pdo) die("cant connect to pqsql db");

        $query_res = $pdo->query("SELECT * from account WHERE username='${_POST['INPUT_USERNAME']}' AND password='${_POST['INPUT_PASSWORD']}'");

        if ($query_res->rowCount() == 1) {
            $_SESSION['session_user'] = $_POST['INPUT_USERNAME'];
            header("Location: /home");
        } else echo "<p>wrong credentials</p>";
    }
    ?>
</body>

</html>