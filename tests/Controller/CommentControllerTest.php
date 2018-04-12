<?php

namespace App\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class CommentControllerTest extends WebTestCase
{
    private $fixtures;

    public function setUp()
    {
        $this->fixtures = $this->loadFixtures(array('App\DataFixtures\PostFixtures'))
        ->getReferenceRepository();
    }

    public function testNewComment()
    {
        $data = json_encode(["comment" => "new comment"]);
        $client = $this->makeClient(true);
        $postId = $this->fixtures->getReference('post')->getId();

        $crawler = $client->request('POST', '/api/posts/'.$postId.'/comments', array(), array(), array(), $data);

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertStatusCode(201, $client);
        $this->assertJson($client->getResponse()->getContent());

        $this->assertArrayHasKey('author', $data);
        $this->assertArrayHasKey('comment', $data);
        $this->assertEquals("new comment", $data['comment']);
        $this->assertEquals("Janusz", $data['author']['surname']);
    }

    public function testCommentValidation()
    {
        $data = json_encode(["comment" => "",]);
        $client = $this->makeClient(true);
        $postId = $this->fixtures->getReference('post')->getId();

        $crawler = $client->request('POST', '/api/posts/'.$postId.'/comments', array(), array(), array(), $data);

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertStatusCode(400, $client);
        $this->assertArrayHasKey('errors', $data);
        $this->assertArrayHasKey('comment', $data['errors']);
    }
}
