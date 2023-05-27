<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestUsersControllerTest extends WebTestCase
{
    public function testSearch():void
    {
        $client = static::createClient();

        // perform a search with some parameters
        $crawler = $client->request('GET', '/test/users', [
            'is_active' => true,
            'is_member' => false,
            'last_login_from' => '2022-01-01',
            'last_login_to' => '2022-12-31',
            'user_types' => '1,2'
        ]);

        $response = $client->getResponse();

        // check that the response is successful (HTTP status code 2xx)
        $this->assertTrue($response->isSuccessful());

        // check that the response is in JSON format
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json')
        );

        // Assert that the response contains a JSON-decoded array with at least one user
        $responseContent = json_decode($response->getContent(), true);

        //Assert that the response contains motr than one item
        $this->assertGreaterThanOrEqual(1, count($responseContent));
    }
}
