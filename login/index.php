<?php
session_start();

/* heroku deploy 
$_SESSION['db_host'] = "ec2-54-164-40-66.compute-1.amazonaws.com";
$_SESSION['db_name'] = "d5jpsu05ngdp98";
$_SESSION['db_user'] = "gufvvvxbtvglqn";
$_SESSION['db_port'] = "5432";
$_SESSION['db_pass'] = "f4121ca0b5c6dbe1a289575016152315b6c81ad4701eb0fb39a5b6e4f7fb0c5a";
*/

// local
$_SESSION['db_host'] = "localhost";
$_SESSION['db_name'] = "php_blog";
$_SESSION['db_user'] = "djdols";
$_SESSION['db_port'] = "5432";
$_SESSION['db_pass'] = "";


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

        //$dbconn = pg_connect("host=${_SESSION['db_host']} port=5432 dbname=${_SESSION['db_name']} user=${_SESSION['db_user']} password=${_SESSION['db_pass']}");
        $pdo = new PDO(
            "pgsql:host=${_SESSION['db_host']};port=5432;dbname=${_SESSION['db_name']};",
            $_SESSION['db_user'],
            $_SESSION['db_pass']
        );

        if ($pdo) echo "Connected";
        else die("cant connect to pqsql db");

        $query_res = $pdo->query("SELECT * from account WHERE username='${_POST['INPUT_USERNAME']}' AND password='${_POST['INPUT_PASSWORD']}'");

        if ($query_res->rowCount() == 1) {
            $_SESSION['session_user'] = $_POST['INPUT_USERNAME'];
            header("Location: /home");
        } else echo "<p>wrong credentials</p>";
    }
    ?>
</body>

</html>