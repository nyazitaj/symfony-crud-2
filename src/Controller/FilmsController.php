<?php

namespace App\Controller;

use App\Entity\Films;
use App\Entity\Seance;
use App\Entity\Salle;
use DateTimeImmutable;
use Doctrine\DBAL\Types\DateType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

class FilmsController extends AbstractController
{

    /**
     * @Route("/", name="film_read")
     */
    public function film_read( ManagerRegistry $doctrine): Response
    {

        $films = $doctrine -> getManager() -> getRepository(films::class) -> findAll();

        return $this->render('films/films-read.html.twig', [
            'films' => $films,
        ]);

    }

    /**
     * @Route("/film_view/{id}", name="film_view")
     */
    public function film_view( ManagerRegistry $doctrine, $id): Response
    {
        $seance = new Seance;
        $salle = new salle;

        $entityManager = $doctrine -> getManager();
        $film = $entityManager -> getRepository(Films::class) -> find($id);

        return $this->render('films/film-view.html.twig', [
            'film' => $film,
            'seance' => $seance,
            'salle' => $salle,
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

        $form = $this->createFormBuilder($film)
            ->add('title', TextType::class)
            ->add('realisateur', TextType::class)
            ->add('genre', TextType::class)
            ->add('image', TextType::class)
            ->add('link', TextType::class)
            ->add('description', TextareaType::class)
            ->add('duree', NumberType::class)
            ->add('status', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Ajouter'])
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if(!$film -> getId()) {
                $film -> setCreatedAt( new DateTimeImmutable() );
            }
            $film -> setUpdatedAt( new DateTimeImmutable() );


            $form = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($form);
            $entityManager->flush();

            return $this->redirectToRoute('film_read');
        }




        return $this->render('films/film-add.html.twig', [
            'form' => $form -> createView(),
            'idEditor' => $idEditor
        ]);
    }


    // Saving default film list in database (not working)
    /**
     * @Route("/film_default", name="film_default")
     */
    public function addDefaultFilmList( ManagerRegistry $doctrine, Request $request, $id=null): Response
    {


        // Adding default values in database.
        $filmArray = [
            [
                'title' => 'Infiltrator',
                'realisateur' => 'Brad Furman',
                'genre' => 'Thriller',
                'affiche' => '/assets/images/film-posters/Infiltrator.jpg',
                'link' => 'https://57webbee.com',
                'resume' => "L’agent fédéral Bob Mazur a pour mission d’infiltrerle cartel de drogue de Pablo Escobar.Son but : faire tomber 85 barons et une banqueinternationale.Son plan : s’inventer un passé, une identité, unefiancée.Son risque : le moindre faux pas lui serait fatal.",
                'duree' => '127',
                'status' => 'Disponible',
            ],
            [
                'title' => 'Brain Freeze',
                'realisateur' => 'Julien Knafo',
                'genre' => 'Comédie, Epouvante-horreur',
                'affiche' => '/assets/images/film-posters/mthumb.jpg',
                'link' => 'https://57webbee.com',
                'resume' => "Un engrais utilisé dans une riche communauté fermée devient la source d'une mutation génétique qui transforme ses habitants en zombies. Un adolescent et sa petite sœur peuvent-ils s'échapper de l'île en quarantaine avant de se transformer en herbe ?",
                'duree' => '91',
                'status' => 'Disponible',
            ],
            [
                'title' => 'See for Me',
                'realisateur' => 'Randall Okita',
                'genre' => 'Epouvante-horreur',
                'affiche' => '/assets/images/film-posters/see-for-me.jpg',
                'link' => 'https://57webbee.com',
                'resume' => "Sophie, une jeune femme aveugle, vit dans un manoir isolé, se retrouve prise au piège par des voleurs qui cherchent un coffre-fort caché. Son seul moyen de défense : une nouvelle application appelée \"See For Me\". Elle la connecte à un volontaire à travers le pays qui l'aide à survivre en voyant à sa place. Sophie est mise en relation avec Kelly, un vétéran de l'armée qui passe ses journées à jouer à des jeux vidéos de guerre.",
                'duree' => '92',
                'status' => 'Disponible',
            ],
            [
                'title' => 'Halloween Kills',
                'realisateur' => 'David Gordon Green',
                'genre' => 'Epouvante-horreur',
                'affiche' => '/assets/images/film-posters/halloween.png',
                'link' => 'https://57webbee.com',
                'resume' => "Laurie Strode, sa fille Karen et sa petite fille Allyson viennent d’abandonner le monstre au célèbre masque, enfermé dans le sous-sol de la maison dévorée par les flammes. Grièvement blessée, Laurie est transportée en urgence à l’Hôpital, avec la certitude qu’elle vient enfin de se débarrasser de celui qui la harcèle depuis toujours. Mais Michael Myers parvient à s’extirper du piège où Laurie l’avait enfermé et son bain de sang rituel recommence. Surmontant sa douleur pour se préparer à l’affronter encore une fois, elle va inspirer la ville entière qui décide de l’imiter et de se soulever pour exterminer ce fléau indestructible. Les trois générations de femmes vont s’associer à une poignée de survivants du premier massacre, et prennent les choses en main en formant une milice organisée autour de la chasse et la destruction du monstre une fois pour toutes. Le mal meurt cette nuit.",
                'duree' => '106',
                'status' => 'Disponible',
            ],
            /* [
                'title' => '',
                'realisateur' => '',
                'genre' => '',
                'affiche' => '/assets/images/film-posters/mthumb.jpg',
                'link' => 'https://57webbee.com',
                'resume' => "",
                'duree' => '',
                'status' => 'Disponible',
            ],
            [
                'title' => '',
                'realisateur' => '',
                'genre' => '',
                'affiche' => '/assets/images/film-posters/mthumb.jpg',
                'link' => 'https://57webbee.com',
                'resume' => "",
                'duree' => '',
                'status' => 'Disponible',
            ], */
        ];

        $films = new Films;

        $entityManager = $this->getDoctrine()->getManager();

        foreach ( $filmArray as $vls ) {
            $films -> setTitle( $vls['title'] );
            $films -> setRealisateur( $vls['realisateur'] );
            $films -> setGenre( $vls['genre'] );
            $films -> setImage( $vls['affiche'] );
            $films -> setLink( $vls['link'] );
            $films -> setDescription( $vls['resume'] );
            $films -> setDuree( $vls['duree'] );
            $films -> setStatus( $vls['status'] );
            $films -> setCreatedAt(  new DateTimeImmutable() );
            $films -> setUpdatedAt(  new DateTimeImmutable() );

            $entityManager->persist($films);
        }

        $entityManager->flush();

        return $this->redirectToRoute('film_read');

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
