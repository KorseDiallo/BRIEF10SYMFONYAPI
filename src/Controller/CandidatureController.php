<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Repository\FormationRepository;
use App\Repository\StatutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CandidatureController extends AbstractController
{
    #[Route('/api/candidater/{formationId}/{statutId}', name: 'app_candidater')]
    public function creerFormation(EntityManagerInterface $em,Security $security,int $formationId,int $statutId,FormationRepository $formationRepository,StatutRepository $statutRepository ): JsonResponse {
        
        $user = $this->getUser();

        if (!$user) {
            return new JsonResponse(['message' => 'Utilisateur non connecté'], Response::HTTP_UNAUTHORIZED);
        }

        $formation = $formationRepository->find($formationId);
        
        $statut = $statutRepository->find($statutId);

        if (!$formation || !$statut) {
            return new JsonResponse(['message' => 'Formation ou statut non trouvé'], Response::HTTP_NOT_FOUND);
        }

        $candidature = new Candidature();
        
        $candidature->setUsers($user)
                    ->setFormations($formation)
                    ->setStatut($statut);

        $em->persist($candidature);
        $em->flush();

        return new JsonResponse(['message' => 'Candidature enregistrée avec succès'], Response::HTTP_CREATED);
    }

    
}
