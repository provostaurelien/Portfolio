<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact_send_email", methods={"POST"})
     */
    public function sendEmail(Request $request, MailerInterface $mailer): JsonResponse
    {
        // Décodage du contenu JSON de la requête
        $data = json_decode($request->getContent(), true);

        // Validation des champs requis
        if (!isset($data['name'], $data['email'], $data['message'])) {
            return $this->json(['error' => 'Les champs name, email et message sont obligatoires.'], 400);
        }

        // Validation de l'adresse e-mail
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return $this->json(['error' => 'L\'adresse e-mail fournie est invalide.'], 400);
        }

        try {
            // Création de l'e-mail
            $email = (new Email())
                ->from($data['email']) // L'expéditeur est l'utilisateur qui remplit le formulaire
                ->to('contact@devap.fr') // Votre adresse e-mail
                ->subject('Nouveau message via le formulaire de contact')
                ->text(sprintf(
                    "Nom : %s\nEmail : %s\nMessage :\n\n%s",
                    $data['name'],
                    $data['email'],
                    $data['message']
                ));

            // Envoi de l'e-mail
            $mailer->send($email);

            return $this->json(['message' => 'Email envoyé avec succès.']);
        } catch (\Exception $e) {
            // Gestion des erreurs lors de l'envoi de l'e-mail
            return $this->json(['error' => 'Une erreur est survenue lors de l\'envoi de l\'e-mail.', 'details' => $e->getMessage()], 500);
        }
    }
}
