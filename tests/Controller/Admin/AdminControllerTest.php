<?php

namespace App\Tests\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{    
    /**
     * testAccessProfilNotConnected
     * Test l'access en tant qu'utilisateur non connecté pour la route /admin
     *
     * @return void
     */
    public function testAccessProfilNotConnected(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin');
        $this->assertResponseRedirects('/login', Response::HTTP_FOUND);
    }
}