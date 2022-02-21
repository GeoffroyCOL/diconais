<?php

namespace App\Tests\Controller\Profile;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfileControllerTest extends WebTestCase
{    
    /**
     * testAccessProfilNotConnected
     * Test l'access en tant qu'utilisateur non connecté pour la route /profile
     *
     * @return void
     */
    public function testAccessProfilNotConnected(): void
    {
        $client = static::createClient();
        $client->request('GET', '/profile');
        $this->assertResponseRedirects('/login', Response::HTTP_FOUND);
    }
}