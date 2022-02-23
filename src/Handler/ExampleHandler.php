<?php

namespace App\Handler;

use App\Entity\Example;
use App\Entity\Ideogramme;
use App\Repository\ExampleRepository;
use Doctrine\ORM\EntityManagerInterface;

class ExampleHandler
{
    public function __construct(
        private ExampleRepository $repository,
        private EntityManagerInterface $manager
    )
    {}

    public function getExamplesByIdeogramme(Ideogramme $ideogramme): array
    {
        return $this->repository->findBy(['ideogramme' => $ideogramme]);
    }

    public function delete(Example $example): void
    {
        $this->manager->remove($example);
        $this->manager->flush();
    }
}