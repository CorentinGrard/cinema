<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{

    /**
     * @Route("/count-by-category", name="countByCategory")
     */
    public function countByCategory(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->getFilmNumberPerCategory();
        return $this->render('_footer.html.twig', [
            'categories' => $categories,
        ]);
    }
}
