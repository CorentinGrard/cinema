<?php

namespace App\Service;

use App\Entity\Movie;
use App\Entity\Person;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use \DateTime;
use Faker;

class MovieGenerator
{
    private $categoryRepository;
    private $faker;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->faker = Faker\Factory::create('fr_FR');
    }

    public function generateRandomMovie(EntityManagerInterface $entityManager)
    {
        $movie = new Movie();

        $numberActor = $this->faker->numberBetween(1, 5);
        for ($j = 0; $j < $numberActor; $j++) {
            $actor = new Person();
            $actor->setFirstName($this->faker->firstName());
            $actor->setLastName($this->faker->lastName());
            $actor->setBiography($this->faker->realText(100));
            $movie->addCasting($actor);
            $entityManager->persist($actor);
        }

        $realisator = new Person();
        $realisator->setFirstName($this->faker->firstName());
        $realisator->setLastName($this->faker->lastName());
        $realisator->setBiography($this->faker->realText(100));

        $movie->setTitle($this->faker->sentence(6, true));
        $movie->setDescription($this->faker->realText(100));
        $movie->setReleaseDate(DateTime::createFromFormat("Y-m-d", $this->faker->date()));
        $movie->setRealisator($realisator);

        $categoryId = $this->faker->numberBetween(1, 4);
        $movie->setCategory($this->categoryRepository->find($categoryId));


        $entityManager->persist($realisator);
        $entityManager->persist($movie);
        $entityManager->flush();
    }
}
