<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VisitorControllerTest extends WebTestCase
{
    private static int $postCount = 0; // Variable pour partager la valeur entre les tests

    public function testPostVisitorIncrement(): void
    {
        // Assurez-vous que le kernel est arrêté avant de créer un client
        self::ensureKernelShutdown();
        $client = self::createClient();

        // 1. Appeler l'endpoint POST /api/visitor/increment
        $client->request('POST', '/api/visitor/increment');

        // Vérifier que la réponse est valide
        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());

        // Décoder la réponse JSON
        $postResponseData = json_decode($client->getResponse()->getContent(), true);

        // Vérifier que la clé "count" existe et que c'est un entier
        $this->assertArrayHasKey('count', $postResponseData);
        $this->assertIsInt($postResponseData['count']);

        // Stocker la valeur du compteur après l'incrémentation pour le prochain test
        self::$postCount = $postResponseData['count'];
    }

    /**
     * @depends testPostVisitorIncrement
     */
    public function testGetVisitorCount(): void
    {
        // Assurez-vous que le kernel est arrêté avant de créer un client
        self::ensureKernelShutdown();
        $client = self::createClient();

        // 2. Appeler l'endpoint GET /api/visitor
        $client->request('GET', '/api/visitor');

        // Vérifier que la réponse est valide
        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());

        // Décoder la réponse JSON
        $getResponseData = json_decode($client->getResponse()->getContent(), true);

        // Vérifier que la clé "count" existe et correspond à la valeur retournée par le POST
        $this->assertArrayHasKey('count', $getResponseData);
        $this->assertEquals(self::$postCount, $getResponseData['count']);
    }
}

