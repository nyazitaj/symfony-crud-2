<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NavController extends AbstractController {


    /**
     * @Route("/", name="accueil")
     */
    public function accueil()
    {

        return $this -> render(
            'navigation/accueil.html.twig'
        );

    }

    /**
     * @Route("/films", name="films")
     */
    public function films()
    {
        $films = [
            "Les dents de la mer",
            "Fast and Furious",
            "Spiderman"
        ];

        return $this -> render(
            'films/films.html.twig', ['films' => $films]
        );

    }

    /**
     * @Route("/homeRedirect", name="homeRedirect")
     */
    public function homeRedirect()
    {

        return $this -> redirectToRoute('accueil');

    }

}