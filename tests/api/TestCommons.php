<?php

namespace APITests {

    use PDO;
    use PDOException;
    use Exception;
    use PHPUnit\Framework\TestCase;
    use GuzzleHttp\Client;

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
                printf("ERROR:" . $statement . "\n");
                if($catch_exception) throw $e;
            }
        }
    }

    class APITestCase extends TestCase{
        
        private $httpClient;

        public function setUp(): void{
            $this->httpClient = new Client(['base_uri' => 'http://localhost:3001/']);
        }

        public function tearDown(): void{
            $this->httpClient = null;
        }

        protected function request(string $method, $uri = '', array $options = []){
            try{
                return $this->httpClient->request($method, $uri, $options);
            }catch(Exception $e){
                return $e;
            }
        }

    }
}
