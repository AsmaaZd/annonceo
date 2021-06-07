<?php

namespace App\Repository;

use App\Entity\Note;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Note|null find($id, $lockMode = null, $lockVersion = null)
 * @method Note|null findOneBy(array $criteria, array $orderBy = null)
 * @method Note[]    findAll()
 * @method Note[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }

    // /**
    //  * @return Note[] Returns an array of Note objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    // select avg(note) from note 
    // where user1_id=6
    //user1 celui qui recois


    
    public function findNoteMoyenne($userId)
    {
        $builder= $this->createQueryBuilder('a');
        return $builder
        ->select("avg(a.note),count(a.note)")
        ->andWhere('a.user1 = :idUser')
        ->andWhere('a.status = :status')
        ->setParameter('idUser', $userId)
        ->setParameter('status', 1)
        ->getQuery()
        ->getOneOrNullResult()
        ;

    }

    public function findUser1User2($user2,$user1)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.user1 = :val')
            ->andWhere('n.user2 = :val2')
            ->setParameter('val', $user1)
            ->setParameter('val2', $user2)
            ->getQuery()
            ->getResult()
        ;
    }
    // findUser1User2($this->getUser());

    /*
    public function findOneBySomeField($value): ?Note
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
