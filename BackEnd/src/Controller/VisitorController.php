<?php

namespace App\Controller;

use App\Entity\Visitor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class VisitorController extends AbstractController
{
    /**
     * @Route("/api/visitor", methods={"GET"}) 
     */
    public function getVisitorCount(EntityManagerInterface $em): JsonResponse
    {
        // Récupérer ou initialiser l'entité Visitor
        $visitor = $em->getRepository(Visitor::class)->find(1);
        if (!$visitor) {
            $visitor = new Visitor();
            $em->persist($visitor);
            $em->flush();
        }

        return $this->json(['count' => $visitor->getCount()]);
    }

    /**
     * @Route("/api/visitor/increment", methods={"POST"})
     */
    public function incrementVisitorCount(EntityManagerInterface $em): JsonResponse
    {
        // Récupérer ou initialiser l'entité Visitor
        $visitor = $em->getRepository(Visitor::class)->find(1);
        if (!$visitor) {
            $visitor = new Visitor();
            $em->persist($visitor);
        }

        // Incrémenter le compteur
        $visitor->increment();
        $em->persist($visitor);
        $em->flush();

        return $this->json(['count' => $visitor->getCount()]);
    }
}


