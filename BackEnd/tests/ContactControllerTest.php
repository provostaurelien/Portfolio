<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactControllerTest extends WebTestCase
{
    public function testSendMail()
    {
        // Créer un client HTTP
        $client = static::createClient();

        // Mock du service MailerInterface
        $mockMailer = $this->createMock(MailerInterface::class);

        // Vérifier que la méthode "send" est appelée une fois avec un objet Email
        $mockMailer->expects($this->once())
            ->method('send')
            ->with($this->callback(function (Email $email) {
                return $email->getFrom()[0]->getAddress() === 'test@test.fr'
                    && $email->getTo()[0]->getAddress() === 'tonemail@example.com'
                    && $email->getSubject() === 'Nouveau message de contact'
                    && str_contains($email->getTextBody(), 'je suis intéressé par votre travail');
            }));

        // Remplacer le service MailerInterface par le mock dans le conteneur
        self::getContainer()->set(MailerInterface::class, $mockMailer);

        // Effectuer la requête
        $client->request(
            'POST',
            '/api/contact',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'name' => 'Test User',
                'email' => 'test@test.fr',
                'message' => 'je suis intéressé par votre travail'
            ])
        );

        // Vérifier la réponse HTTP
        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Email envoyé avec succès']),
            $client->getResponse()->getContent()
        );
    }
}

