<?php

namespace App\Controller;

use App\Entity\Person;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/person")
 */
class PersonController extends AbstractController
{
    /**
     * @Route("/detail/{id}", name="personDetail")
     */
    public function detail(Person $person): Response
    {
        return $this->render('person.detail.html.twig', [
            'person' => $person,
        ]);
    }
}
