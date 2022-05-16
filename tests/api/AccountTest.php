<?php

namespace APITests;

use GuzzleHttp\RequestOptions;

require_once("TestCommons.php");

class AccountTest extends APITestCase
{

    public static function setUpBeforeClass(): void
    {
        self::tearDownAfterClass();
        TestCommons::db_query("INSERT INTO account (username, password) VALUES ('testuser1', 'testpass1')");
    }

    public static function tearDownAfterClass(): void
    {
        TestCommons::deleteALLfrom('testuser1');
        TestCommons::deleteALLfrom('testuser2');
    }
    public function testGET()
    {
        // arrange
        $expectedStatusCode = 200;
        $expectedContentType = "application/json";
        $expectedBody = (object)["username" => "testuser1"];

        // act
        $response = $this->request('GET', 'api/accounts/');

        $actualStatusCode = $response->getStatusCode();
        $actualContentType = $response->getHeaders()["Content-Type"][0];
        $actualBody = json_decode($response->getBody());

        // assert
        $this->assertEquals($expectedStatusCode, $actualStatusCode);
        $this->assertEquals($expectedContentType, $actualContentType);
        $this->assertContainsEquals($expectedBody, $actualBody);
    }

    public function testPOST_with_incomplete_params()
    {   
        // arange
        $expectedStatusCode = 400;
        $expectedBody = (object)["msg" => "required username:string, password:string confirmPass:string"];

        // act
        $response = $this->request('POST', 'api/accounts/', [
            'http_errors' => false, RequestOptions::JSON => ['username'=>'testuser1']
        ]);
        $actualStatusCode = $response->getStatusCode();
        $actualBody = json_decode($response->getBody());

        // assert
        $this->assertEquals($expectedStatusCode, $actualStatusCode);
        $this->assertEquals($expectedBody, $actualBody);
    }

    
    public function testPOST_with_complete_params()
    {   
        // arange
        $expectedStatusCode = 201;
        $expectedBody = (object)["msg" => "Successfully added"];

        // act
        $response = $this->request('POST', 'api/accounts/', [
            'http_errors' => false, 
            RequestOptions::JSON => ['username'=>'testuser2', 'password'=>'testpass2', 'confirmPass'=>'testpass2']
        ]);
        $actualStatusCode = $response->getStatusCode();
        $actualBody = json_decode($response->getBody());

        // assert
        $this->assertEquals($expectedStatusCode, $actualStatusCode);
        $this->assertEquals($expectedBody, $actualBody);
    }
}
