<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\Type\MovieType;
use App\Repository\MovieRepository;
use App\Service\MovieGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/movie")
 */
class MovieController extends AbstractController
{

    /**
     * @Route("/", name="movieHome")
     */
    public function home(MovieRepository $movieRepository)
    {
        $movies = $movieRepository->findThreeByDate();
        return $this->render('home.html.twig', [
            'movies' => $movies,
        ]);
    }

    /**
     * @Route("/generator", name="movieGenerator")
     */
    public function generator(MovieGenerator $movieGenerator, EntityManagerInterface $entityManager)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $movieGenerator->generateRandomMovie($entityManager);
        return $this->redirectToRoute('movieList');
    }

    /**
     * @Route("/list", name="movieList")
     */
    public function listAll(MovieRepository $movieRepository)
    {

        $movies = $movieRepository->findAll();

        return $this->render('movie/list.html.twig', [
            'movies' => $movies,
        ]);
    }

    /**
     * @Route("/category/{id}", name="movieListPerCategory")
     */
    public function listPerCategory(int $id, MovieRepository $movieRepository)
    {

        $movies = $movieRepository->findPerCategory($id);

        return $this->render('movie/list.html.twig', [
            'movies' => $movies,
        ]);
    }

    /**
     * @Route("/detail/{slug}", name="movieDetail")
     */
    public function detail($slug, MovieRepository $movieRepository)
    {
        $movie = $movieRepository->findBySlug($slug);
        $casting = $movie->getCasting();
        return $this->render('movie/detail.html.twig', [
            'movie' => $movie,
            'casting' => $casting
        ]);
    }

    /**
     * @Route("/new", name="movieNew")
     */
    public function new(Request $request, EntityManagerInterface $entityManager)
    {
        // creates a task object and initializes some data for this example
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $movie = $form->getData();

            $entityManager->persist($movie);
            $entityManager->flush();

            return $this->redirectToRoute('movieList');
        }

        return $this->render('movie/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
