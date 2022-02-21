<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{    
    /**
     * testExistLoginUrl
     * Test l'existance de la route pour la connexion
     */
    public function testExistLoginUrl(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
    }
    
    /**
     * testLoginWithGoodCredentials
     * Test la connexion et la redirection d'une connexion
     */
    public function testLoginWithGoodCredentials(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Connexion')->form();
        $form['_username'] = 'admin';
        $form['_password'] = '0000';
        $crawler = $client->submit($form);

        $this->assertResponseRedirects('/admin', Response::HTTP_FOUND);
    }
    
    /**
     * testExistLogoutUrl
     * est l'existance de la route pour la déconnexion
     */
    public function testExistLogoutUrl(): void
    {
        $client = static::createClient();
        $client->request('GET', '/logout');
        $this->assertResponseRedirects('', Response::HTTP_FOUND);
    }
}