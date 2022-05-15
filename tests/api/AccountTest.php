<?php

namespace APITests;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use PDOException;

require_once("TestCommons.php");

class AccountTest extends TestCase
{
    private $http;

    public function setUp(): void
    {
        $this->http = new Client(['base_uri' => 'http://localhost:3001/']);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }

    public static function setUpBeforeClass(): void
    {
        try {
            // delete test account just in case previous test run didn't work out
            self::tearDownAfterClass();
            TestCommons::db_query("INSERT INTO account (username, password) VALUES ('testuser1', 'testpass1')");
        } catch (PDOException $e) {
        }
    }

    public static function tearDownAfterClass(): void
    {
        // only specify username, just in case some dumbass registers with username='testuser1'
        TestCommons::db_query("DELETE FROM account WHERE username='testuser1'");
    }

    public function testGet()
    {
        // arrange
        $expectedResponse = 200;
        $expectedContentType = "application/json";
        $expectedBody = (object)["username" => "testuser1"];

        // act
        $response = $this->http->request('GET', 'api/accounts/');

        $actualStatusCode = $response->getStatusCode();
        $actualContentType = $response->getHeaders()["Content-Type"][0];
        $actualBody = json_decode($response->getBody());

        // assert
        $this->assertEquals($expectedResponse, $actualStatusCode);
        $this->assertEquals($expectedContentType, $actualContentType);

        $this->assertContainsEquals($expectedBody, $actualBody);
    }
}
