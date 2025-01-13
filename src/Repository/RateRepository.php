<?php

namespace App\Repository;

use App\Entity\Rate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @method Rate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rate|null findOneBy(array $criteria)
 * @method Rate[]    findAll()
 * @method Rate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RateRepository extends ServiceEntityRepository 
{ 
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rate::class);
    }
    public function findByIDUidf(int $idu, int $idf): ?Rate
{
   
    $rate = $this->createQueryBuilder('e')
        ->andWhere('e.idU = :idu')
        ->andWhere('e.idF = :idf')
        ->setParameters(['idu' => $idu, 'idf' => $idf])
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();
        
    
    return $rate;
}
public function getAverageNoteByIdF(int $idF): float
{
    $qb = $this->createQueryBuilder('r')
        ->select('AVG(r.note) as average_note')
        ->andWhere('r.idF = :idF')
        ->setParameter('idF', $idF);
    
    $result = $qb->getQuery()->getSingleScalarResult();
    
    return $result ?: 0.0;
}
}