<?php

namespace App\DataFixtures;


use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Service\MovieGenerator;

class MovieFixtures extends Fixture
{
    private $movieGenerator;

    public function __construct(MovieGenerator $movieGenerator)
    {
        $this->movieGenerator = $movieGenerator;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 1000; $i++) {
            $this->movieGenerator->generateRandomMovie($manager);
        }
    }
}
