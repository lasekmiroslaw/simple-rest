<?php

namespace App\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    private $fixtures;

    public function setUp()
    {
        $this->fixtures = $this->loadFixtures(array('App\DataFixtures\PostFixtures'))
        ->getReferenceRepository();
    }

    public function testNewPost()
    {
        $data = json_encode([
          "title" => "new post",
          "description" => "new description"
        ]);

        $client = $this->makeClient(true);
        $crawler = $client->request('POST', '/api/posts', array(), array(), array(), $data);

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertStatusCode(201, $client);
        $this->assertJson($client->getResponse()->getContent());

        $this->assertArrayHasKey('author', $data);
        $this->assertArrayHasKey('description', $data);
        $this->assertEquals("new post", $data['title']);
        $this->assertEquals("Janusz", $data['author']['surname']);
    }

    public function testPostValidation()
    {
        $data = json_encode([
          "title" => "",
          "description" => ""
        ]);

        $client = $this->makeClient(true);
        $crawler = $client->request('POST', '/api/posts', array(), array(), array(), $data);

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertStatusCode(400, $client);
        $this->assertArrayHasKey('errors', $data);
        $this->assertArrayHasKey('title', $data['errors']);
    }

    public function testGetPosts()
    {
        $this->loadFixtures(array('App\DataFixtures\PostFixtures'));

        $client = $this->makeClient(true);
        $crawler = $client->request('GET', '/api/posts');

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertStatusCode(200, $client);
        $this->assertJson($client->getResponse()->getContent());
        $this->assertArrayHasKey('posts', $data);
        $this->assertCount(11, $data['posts']);
    }

    public function testGetPost()
    {
        $postId = $this->fixtures->getReference('post')->getId();

        $client = $this->makeClient(true);
        $crawler = $client->request('GET', '/api/posts/'.$postId);

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertStatusCode(200, $client);
        $this->assertJson($client->getResponse()->getContent());
        $this->assertEquals(['author', 'title', 'description', 'date', 'comments'], array_keys($data));

        $this->assertEquals('first post', $data['title']);
        $this->assertEquals('Janusz', $data['author']['name']);
    }

    public function testDeletePost()
    {
        $client = $this->makeClient(true);
        $postId = $this->fixtures->getReference('post')->getId();

        $crawler = $client->request('DELETE', '/api/posts/'.$postId);

        $this->assertStatusCode(204, $client);
    }
}
