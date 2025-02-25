<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\RouterInterface;

class ContactController extends AbstractController
{
    private $router;

    // Injection du service RouterInterface
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }
    // Fonction pour envoyer l'email via mailer
    public function sendEmail(Request $request, MailerInterface $mailer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['name'], $data['email'], $data['message'])) {
            return $this->json(['error' => 'Missing fields'], 400);
        }

        $email = (new Email())
            ->from($data['email'])
            ->to('tonemail@example.com')
            ->subject('Nouveau message de contact')
            ->text("Nom: {$data['name']}\nEmail: {$data['email']}\nMessage: {$data['message']}");

        $mailer->send($email);

        

        return $this->json(['message' => 'Email envoyé avec succès']);
    }
}
