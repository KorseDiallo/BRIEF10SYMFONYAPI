<?php

namespace App\Controller;

use App\Entity\Candidature;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CandidatureController extends AbstractController
{
    #[Route('/api/candidater', name: 'app_candidater')]
    public function creerFormation(Request $request,SerializerInterface $serializer,EntityManagerInterface $em): JsonResponse
    {
        // dd($request->getContent());
        $candidature=$serializer->deserialize($request->getContent(),Candidature::class,'json');
        //dd($candidature);
        $em->persist($candidature);
        $em->flush();
        return new JsonResponse(['message' => 'Candidature enregistrer avec Succès'], Response::HTTP_CREATED);
    }

 
}
