<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FormationController extends AbstractController
{
    #[Route('/api/CreerFormation', name: 'app_formation')]
    public function creerFormation(Request $request,SerializerInterface $serializer,EntityManagerInterface $em): JsonResponse
    {
        $formation=$serializer->deserialize($request->getContent(),Formation::class,'json');
        $em->persist($formation);
        $em->flush();
        return new JsonResponse(['message' => 'Formation enregistrer avec Succès'], Response::HTTP_CREATED);
    }

   #[Route('/api/supprimerFormation/{id}', name: 'supprimer_formation')]
   public function supprimerFormation(int $id,EntityManagerInterface $em,FormationRepository $formationRepository){
        $formation= $formationRepository->find($id);
        if($formation){
           $em->remove($formation);
           $em->flush();
           return new JsonResponse(['message' => 'La Formation a été supprimée avec Succès'], Response::HTTP_OK);
        }else{
            return new JsonResponse(['message' => 'Formation non trouvée'], Response::HTTP_OK);
        }
   }
}
