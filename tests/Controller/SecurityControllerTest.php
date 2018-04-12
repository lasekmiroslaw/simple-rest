<?php

namespace App\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityControllerTest extends WebTestCase
{
    protected function setUp()
    {
        $this->loadFixtures(array('App\DataFixtures\UserFixtures'));
    }

    public function testThatValidUserIsRedirected()
    {
        $client = $this->makeClient(true);
        $crawler = $client->request('GET', '/login');
        $crawler = $client->followRedirect();

        $this->assertTrue($client->getResponse()->isRedirect('/api/posts'));
    }
}
