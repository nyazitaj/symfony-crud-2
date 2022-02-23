<?php

namespace App\Controller;

use App\Entity\Films;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmsController extends AbstractController
{
    /**
     * @Route("/film_add", name="film_add")
     */
    public function index( ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine -> getManager();
        $film = new Films;

        $film -> setTitle('Les dents de la mer');
        $film -> setRealisateur('Steven Spilberg');
        $film -> setGenre('Horreur');

        $entityManager -> persist($film);
        $entityManager -> flush();

        // return new Response('Saved new films with id '.$film->getTitle());

        return $this->render('films/film-add.html.twig', [
            'film_title' => $film->getTitle(),
        ]);

    }

    /**
     * @Route("/film_read", name="film_read")
     */
    public function film_read( ManagerRegistry $doctrine): Response
    {
        /* $films = $this->getDoctrine()
            ->getRepository(films::class)
            ->find($id);

        if (!$films) {
            throw $this->createNotFoundException(
                'The film list is empty '.$id
            );
        } */

        $films = $doctrine -> getManager() -> getRepository(films::class) -> findAll();

        /* if( !isset($films) ) {
            return $this -> redirectToRoute('acceuil');
        } */

        return $this->render('films/films-read.html.twig', [
            'films' => $films,
        ]);

    }

}
