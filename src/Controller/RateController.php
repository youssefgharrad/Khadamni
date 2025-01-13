<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Entity\Rate;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\RateRepository;
use Doctrine\ORM\EntityManagerInterface;

class RateController extends AbstractController
{
    /**
     * @Route("/{id}/rate", name="app_rate")
     */
    public function index(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {  
        $id = $request->attributes->get('id');
        return $this->render('rate/index.html.twig', ['id' => $id]);
    
        
    }
    /**
     * @Route("/{id}/note", name="app_note")
     */
    public function note(Request $request, EntityManagerInterface $entityManager, Security $security,RateRepository $rateRepository ): Response
    {  
       
        $id = $request->attributes->get('id');
        var_dump($request->request->all());
        $rating = $request->request->get('rating');
        $user = $security->getUser();
        $userId = $user->getId();
        $id_u = $userId; // or replace with the actual value
    $id_F = $id; //
    $rateRepository1 = $entityManager->getRepository(Rate::class);
   $rates = $rateRepository1->findByIDUidf($userId, $id);
        
            if(!$rates)
            {
                
                $rate = new Rate();
                $rate->setIdU($userId);
                $rate->setIdF($id);
                
                $rate->setNote($rating);
                $entityManager->persist($rate);
                $entityManager->flush();
                return $this->redirectToRoute('app_utilisateur_card', ['id' => $id]);
            }
       
    //$rating = $request->request->get('rating');
             /* $rate = new Rate();
                $rate->setIdU($userId);
                $rate->setIdF($id);
                
                $rate->setNote($rating);
                $entityManager->persist($rate);
                $entityManager->flush();*/
        return new Response('Rating not added ', 305);
    
        
    }
}
