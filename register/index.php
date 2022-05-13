<?php require $_SERVER['DOCUMENT_ROOT'] . '/common/actionloaddb.php' ?>
<html>

<head>
    <title>php_blog - Register</title>
</head>

<body>
    <h1>Register</h1>
    <form method="post">
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
                <td><input type="password" name="INPUT_PASSWORD2"></input></td>
            </tr>
        </table>
        <button type="submit" name="submit" value="submit">Register</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if ($_POST['INPUT_PASSWORD'] != $_POST['INPUT_PASSWORD2'])
            echo "<p class=\"ErrorMSG\">Passwords don't match</p>";

        else {
            if (!$dbc) die("cant connect to pqsql db");

            $query_res = $dbc->query("SELECT * FROM account WHERE username='${_POST['INPUT_USERNAME']}'");
            if ($query_res->rowCount() > 0)
                echo "<p class=\"ErrorMSG\">username already taken</p>";

            else {
                $query_res = $dbc->query(
                    "INSERT INTO account (username, password) VALUES (
                        '${_POST['INPUT_USERNAME']}', '${_POST['INPUT_PASSWORD']}'
                    )"
                );

                session_destroy();
                session_start();
                $_SESSION['newly_registered_user'] = $_POST['INPUT_USERNAME'];
                header('Location: /login');
            }
        }
    }
    ?>
</body>

</html>