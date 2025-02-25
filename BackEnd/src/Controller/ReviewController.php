<?php

namespace App\Controller;

use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class ReviewController extends AbstractController
{
    private $router;

    // Injection du service RouterInterface
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }
// Fonction pour récupérer les avis
    public function getReviews(EntityManagerInterface $em): JsonResponse
    {
        $reviews = $em->getRepository(Review::class)->findAll();
        return $this->json($reviews);
    }
// Fonction pour ajouter un avis
public function addReview(Request $request, EntityManagerInterface $em): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    // Vérification des champs obligatoires
    if (!isset($data['author'], $data['content'], $data['score'], $data['recaptchaToken'])) {
        return $this->json(['error' => 'Missing fields or reCAPTCHA token'], 400);
    }

    // Récupération du secret depuis les paramètres
    $recaptchaSecret = $this->getParameter('recaptcha_secret');

    // Appel à l'API Google pour vérifier le token reCAPTCHA
    $recaptchaToken = $data['recaptchaToken'];
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaToken");
    $responseKeys = json_decode($response, true);

    if (!$responseKeys['success'] || $responseKeys['score'] < 0.5) {
        return $this->json(['error' => 'Invalid reCAPTCHA token or low score', 'details' => $responseKeys], 403);
    }

    // Étape 2 : Vérification que le score est un entier entre 1 et 5
    $score = filter_var($data['score'], FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 5]
    ]);

    if ($score === false) {
        return $this->json(['error' => 'Le score doit être un entier entre 1 et 5'], 422);
    }

    // Étape 3 : Création et sauvegarde de l'avis
    $review = new Review();
    $review->setAuthor($data['author']);
    $review->setContent($data['content']);
    $review->setScore($score);

    $em->persist($review);
    $em->flush();

    return $this->json(['message' => 'Avis ajouté'], 201);
}
public function addReviewWithoutRecaptcha(Request $request, EntityManagerInterface $em): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    if (!isset($data['author'], $data['content'], $data['score'])) {
        return $this->json(['error' => 'Missing fields'], 400);
    }

    // Vérification que le score est un entier entre 1 et 5
    $score = filter_var($data['score'], FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 5]
    ]);

    if ($score === false) {
        return $this->json(['error' => 'Le score doit être un entier entre 1 et 5'], 422);
    }

    // Création et sauvegarde de l'avis
    $review = new Review();
    $review->setAuthor($data['author']);
    $review->setContent($data['content']);
    $review->setScore($score);

    $em->persist($review);
    $em->flush();

    return $this->json(['message' => 'Avis ajouté (sans validation reCAPTCHA)'], 201);
}
}
