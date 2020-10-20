<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function findAll()
    {
        return $this->createQueryBuilder('m')
            ->join("m.realisator", "p")
            ->addSelect("p")
            ->orderBy("m.title")
            ->getQuery()
            ->getResult();
    }

    public function findPerCategory($id)
    {
        return $this->createQueryBuilder('m')
            ->join("m.realisator", "p")
            ->addSelect("p")
            ->orderBy("m.title")
            ->andWhere("m.category = :val")
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult();
    }

    public function findBySlug($slug){
        return $this->createQueryBuilder('m')
            ->join("m.realisator", "p")
            ->addSelect("p")
            ->andWhere("m.slug = :val")
            ->setParameter('val', $slug)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findThreeByDate()
    {
        return $this->createQueryBuilder('m')
            ->join("m.realisator", "p")
            ->addSelect("p")
            ->orderBy("m.releaseDate")
            ->getQuery()
            ->setMaxResults(3)
            ->getResult();
    }

    public function findOneById(int $id): ?Movie
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
