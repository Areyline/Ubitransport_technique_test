<?php


namespace App\Controller;


use App\Entity\Score;
use Doctrine\ORM\EntityManagerInterface;

class CalculateClassAverage
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke()
    {
        return $this->em->getRepository(Score::class)
            ->calculateAverage();
    }
}