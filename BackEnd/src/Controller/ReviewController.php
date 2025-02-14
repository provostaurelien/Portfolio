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

    $review = new Review();
    $review->setAuthor($data['author']);
    $review->setContent($data['content']);
    $review->setScore($score);

    $em->persist($review);
    $em->flush();

    return $this->json(['message' => 'Avis ajouté'], 201);
}
}
