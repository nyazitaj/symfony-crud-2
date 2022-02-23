<?php

namespace App\Controller;

use App\Entity\Films;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class FilmsController extends AbstractController
{

    /**
     * @Route("/", name="film_read")
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

    /**
     * @Route("/film_view/{id}", name="film_view")
     */
    public function film_view( ManagerRegistry $doctrine, $id): Response
    {

        $entityManager = $doctrine -> getManager();
        $film = $entityManager -> getRepository(Films::class) -> find($id);

        return $this->render('films/film-view.html.twig', [
            'film' => $film,
        ]);

    }


    /**
     * @Route("/film_add", name="film_add")
     * @Route("/film_update/{id?1}", name="film_update")
     */
    public function index( ManagerRegistry $doctrine, Request $request, $id=null): Response
    {

        $entityManager = $doctrine -> getManager();
        $idEditor = false;

        if($id) {
            $film = $entityManager -> getRepository(Films::class) -> find($id);
        
            if(!$film) {
                return $this->redirectToRoute('film_read');
            }
            $idEditor = true;
        }
        else {
            $film = new Films;
        }

        // $film = new Films;

        // $film -> setTitle('Les dents de la mer');
        // $film -> setRealisateur('Steven Spilberg');
        // $film -> setGenre('Horreur');

        // $entityManager -> persist($film);
        // $entityManager -> flush();

        // return new Response('Saved new films with id '.$film->getTitle());

        /* return $this->render('films/film-add.html.twig', [
            'film_title' => $film->getTitle(),
        ]); */



        $form = $this->createFormBuilder($film)
            ->add('title', TextType::class)
            ->add('realisateur', TextType::class)
            ->add('genre', TextType::class)
            ->add('image', TextType::class)
            ->add('link', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Ajouter'])
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $form = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($form);
            $entityManager->flush();

            return $this->redirectToRoute('film_read');
            /* return $this->render('films/film-add.html.twig', [
                'form' => $form -> createView(),
            ]); */
        }




        return $this->render('films/film-add.html.twig', [
            'form' => $form -> createView(),
            'idEditor' => $idEditor
        ]);
    }

    /**
     * @Route("/film_delete/{id}", name="film_delete")
     */
    public function film_delete(  ManagerRegistry $doctrine, $id ): Response
    {

        $entityManager = $doctrine -> getManager();
        $film = $entityManager -> getRepository(Films::class) -> find($id);

        if( $film ) {
            $entityManager -> remove($film);
            $entityManager -> flush();
        }

        return $this->redirectToRoute('film_read');

    }

}
