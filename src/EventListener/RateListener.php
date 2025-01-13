<?php
namespace App\EventListener;

use App\Entity\Rate;
use App\Repository\RateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use App\Repository\UtilisateurRepository;

class RateListener
{
    private $entityManager;
    private $rateRepository;
    private $ur;

    public function __construct(EntityManagerInterface $entityManager, RateRepository $rateRepository,UtilisateurRepository $ur)
    {
        $this->entityManager = $entityManager;
        $this->rateRepository = $rateRepository;
        $this->ur = $ur;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->updateRate($args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->updateRate($args);
    }

    private function updateRate(LifecycleEventArgs $args)
    {
         //$this->getDoctrine()->getRepository(Utilisateur::class)->find($id);
        $entity = $args->getEntity();
        if ($entity instanceof Rate) {
            $idF = $entity->getIdF();
            $averageNote = $this->rateRepository->getAverageNoteByIdF($idF);
            $user = $this->ur->find($idF);

            $user->setRate($averageNote);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
    }
}