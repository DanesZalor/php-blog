<?php

namespace APITests;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use PDO;

class BlogpostTest extends APITestCase{  

    private static $testBlogpostId = 0;

    public static function setUpBeforeClass() : void {
        
        self::tearDownAfterClass();
        // make an account 'testuser1'
        TestCommons::db_query("INSERT INTO account (username, password) VALUES ('testuser1', 'testpass1')");
        
        // make a blogpost with owner 'testuser1'        
        TestCommons::db_query("INSERT INTO blogpost (posttime, poster, content) 
        VALUES ('2001-9-11 08:14:00', 'testuser1', 'this blog is a test i hate nato')");   
        
        self::$testBlogpostId = TestCommons::db_query("SELECT id FROM blogpost WHERE (posttime, poster) 
        = ('2001-9-11 08:14:00', 'testuser1')")->fetchAll(PDO::FETCH_NUM)[0][0];
    }

    public static function tearDownAfterClass(): void
    {
        TestCommons::db_query("DELETE FROM blogpost WHERE poster='testuser1'");
        TestCommons::db_query("DELETE FROM account WHERE username='testuser1'");
    }

    public function testGET_blogposts(){

        // arrange
        $expected_body = (object)[
            "id" => self::$testBlogpostId ,
            "posttime" => "2001-09-11 08:14:00",
            "poster"=> "testuser1",
            "content" => "this blog is a test i hate nato"
        ];
        $expected_statusCode = 200;
        
        // act
        $response = $this->request('GET', 'api/blogposts/', ['http_errors' => false]);
        $actualBody = json_decode($response->getBody());
        $actual_statusCode = $response->getStatusCode();

        // assert
        $this->assertContainsEquals($expected_body, $actualBody);
        $this->assertEquals($expected_statusCode, $actual_statusCode);
    }

}