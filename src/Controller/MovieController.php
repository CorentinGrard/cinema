<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/list-movies", name="movieList")
     */
    public function listAll(MovieRepository $movieRepository)
    {

        $movies = $movieRepository->findAll();

        return $this->render('movie.list.html.twig', [
            'movies' => $movies,
        ]);
    }

    /**
     * @Route("/category/{id}", name="movieListPerCategory")
     */
    public function listPerCategory(int $id, MovieRepository $movieRepository)
    {

        $movies = $movieRepository->findPerCategory($id);

        return $this->render('movie.list.html.twig', [
            'movies' => $movies,
        ]);
    }

    /**
     * @Route("/detail/{id}", name="movieDetail")
     */
    public function detail(Movie $movie)
    {
        return $this->render('movie.detail.html.twig', [
            'movie' => $movie,
        ]);
    }

    public function new(Request $request)
    {
        // creates a task object and initializes some data for this example
        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($task)
            ->add('task', TextType::class)
            ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();

        // ...
    }
}
