<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReviewControllerTest extends WebTestCase
{
    public function testGetReviews()
    {
        // Créer un client HTTP
        $client = static::createClient();

        // Effectuer une requête GET
        $client->request('GET', '/api/reviews');

        // Vérifier que la réponse est réussie
        $this->assertResponseIsSuccessful();

        // Vérifier que le contenu est un JSON valide
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testAddReview()
    {
        // Créer un client HTTP
        $client = static::createClient();

        // Effectuer une requête POST pour ajouter un avis
        $client->request(
            'POST',
            '/api/reviews',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'author' => 'Test User',
                'content' => 'Ceci est un test.',
                'score' => 5
            ])
        );

        // Vérifier que la réponse est réussie
        $this->assertResponseIsSuccessful();

        // Vérifier que le contenu correspond au message attendu
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Avis ajouté']),
            $client->getResponse()->getContent()
        );
    }
}
