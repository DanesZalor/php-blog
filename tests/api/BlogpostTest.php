<?php

namespace APITests;

use GuzzleHttp\RequestOptions;
use PDO;

class BlogpostTest extends APITestCase{  

    private static $testBlogpostId1 = 0;
    private static $testBlogpostId2 = 0;
    private static $testblogposts;

    public static function setUpBeforeClass() : void {
        
        self::tearDownAfterClass();
        // make an account 'testuser1'
        TestCommons::db_query("INSERT INTO account (username, password) VALUES ('testuser1', 'testpass1')");
        
        // make 2 blogpost with owner 'testuser1'        
        TestCommons::db_query("INSERT INTO blogpost (posttime, poster, content) 
        VALUES ('2001-09-11 08:14:00', 'testuser1', 'this blog is a test i hate nato')");  
        
        TestCommons::db_query("INSERT INTO blogpost (posttime, poster, content) 
        VALUES ('2001-09-11 08:30:00', 'testuser1', 'hello world')"); 
        
        self::$testBlogpostId1 = TestCommons::db_query("SELECT id FROM blogpost WHERE (posttime, poster) 
        = ('2001-09-11 08:14:00', 'testuser1')")->fetchAll(PDO::FETCH_NUM)[0][0];

        self::$testBlogpostId2 = TestCommons::db_query("SELECT id FROM blogpost WHERE (posttime, poster) 
        = ('2001-09-11 08:30:00', 'testuser1')")->fetchAll(PDO::FETCH_NUM)[0][0];

        self::$testblogposts = [
            (object)[
                "id" => self::$testBlogpostId1 ,
                "posttime" => "2001-09-11 08:14:00",
                "poster"=> "testuser1",
                "content" => "this blog is a test i hate nato"
            ],(object)[
                "id" => self::$testBlogpostId2 ,
                "posttime" => "2001-09-11 08:30:00",
                "poster"=> "testuser1",
                "content" => "hello world"
            ]
        ];
    }

    public static function tearDownAfterClass(): void
    {
        TestCommons::db_query("DELETE FROM blogpost WHERE poster='testuser1'");
        TestCommons::db_query("DELETE FROM account WHERE username='testuser1'");
    }

    // GET api/blogposts/
    public function testGET_blogposts(){

        // arrange
        $expected_body = self::$testblogposts;

        $expected_statusCode = 200;
        
        // act
        $response = $this->request('GET', 'api/blogposts/', ['http_errors' => false]);
        $actualBody = json_decode($response->getBody());
        $actual_statusCode = $response->getStatusCode();

        // assert
        $this->assertContainsEquals($expected_body[0], $actualBody);
        $this->assertContainsEquals($expected_body[1], $actualBody);
        $this->assertEquals($expected_statusCode, $actual_statusCode);
    }

    // GET api/blogposts/ fromAuthor="testuser1"
    public function testGET_blogposts_fromAuthor(){
        
        // arrange
        $expected_body = self::$testblogposts;

        $expected_statusCode = 200;

        $response = $this->request('GET', 'api/blogposts/', [
            'http_errors' => false,
            RequestOptions::JSON => ['fromAuthor' => 'testuser1']
        ]);
        $actualBody = json_decode($response->getBody());
        $actual_statusCode = $response->getStatusCode();

        $this->assertEquals($expected_body, $actualBody);
        $this->assertEquals($expected_statusCode, $actual_statusCode);
    }

}