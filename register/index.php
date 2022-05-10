<?php require $_SERVER['DOCUMENT_ROOT'] . '/common/actionloaddb.php' ?>
<?php
// if this client has logged in alr, go /home
if (array_key_exists('session_user', $_SESSION)) header("Location: /home");
?>
<html>

<head>
    <title>php_blog - Register</title>
</head>

<body>
    <h1>Register</h1>
    <form action="post">
        <table>
            <tr>
                <td><label>username: </label></td>
                <td>
                    <input type="text" name="INPUT_USERNAME" value=<?php echo $_POST['INPUT_USERNAME']; ?>>
                    </input>
                </td>
            </tr>
            <tr>
                <td><label>password: </label></td>
                <td><input type="password" name="INPUT_PASSWORD"></input></td>
            </tr>
            <tr>
                <td><label>confirm password: </label></td>
                <td><input type="password" name="INPUT_PASSWORD"></input></td>
            </tr>
        </table>
        <button type="submit" name="submit" value="submit">Register</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $pdo = new PDO( // pgsql db connect
            "pgsql:host=${_SESSION['db_host']};port=5432;dbname=${_SESSION['db_name']};",
            $_SESSION['db_user'],
            $_SESSION['db_pass']
        );
        if (!$pdo) die("cant connect to pqsql db");
    }
    ?>
</body>

</html>