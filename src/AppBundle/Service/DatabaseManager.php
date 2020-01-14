<?php


namespace AppBundle\Service;


use Doctrine\ORM\EntityManagerInterface;

class DatabaseManager
{
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function persist(object $object)
    {
        $this->entityManager->persist($object);
    }

    public function flush()
    {
        $this->entityManager->flush();
    }

}