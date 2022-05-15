<?php

namespace APITests {

    use PDO;
    use PDOException;

    final class TestCommons
    {
        private static $host = "localhost";
        private static $dbname = "php_blog";
        private static $dbuser = "djdols";
        private static $port = "5432";
        private static $dbpass = "";

        private static $dbc;

        public static function db_query($statement, $fetch_mode = PDO::FETCH_DEFAULT, $catch_exception=false)
        {
            self::$dbc = new PDO(
                "pgsql:host=" . self::$host . ";port=" . self::$port . ";dbname=" . self::$dbname . ";",
                self::$dbuser,
                self::$dbpass,
            );
            try {
                if (!self::$dbc) die("Failed to query ${statement}\nCan't connect to Database.");
                return self::$dbc->query($statement, $fetch_mode);
            } catch (PDOException $e) {
                printf("ERROR:" . $statement);
                if($catch_exception) throw $e;
            }
        }
    }
}
