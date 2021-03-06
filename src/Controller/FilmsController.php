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
                'resume' => "L???agent f??d??ral Bob Mazur a pour mission d???infiltrerle cartel de drogue de Pablo Escobar.Son but : faire tomber 85 barons et une banqueinternationale.Son plan : s???inventer un pass??, une identit??, unefianc??e.Son risque : le moindre faux pas lui serait fatal.",
                'duree' => '127',
                'status' => 'Disponible',
            ],
            [
                'title' => 'Brain Freeze',
                'realisateur' => 'Julien Knafo',
                'genre' => 'Com??die, Epouvante-horreur',
                'affiche' => '/assets/images/film-posters/mthumb.jpg',
                'link' => 'https://57webbee.com',
                'resume' => "Un engrais utilis?? dans une riche communaut?? ferm??e devient la source d'une mutation g??n??tique qui transforme ses habitants en zombies. Un adolescent et sa petite s??ur peuvent-ils s'??chapper de l'??le en quarantaine avant de se transformer en herbe ?",
                'duree' => '91',
                'status' => 'Disponible',
            ],
            [
                'title' => 'See for Me',
                'realisateur' => 'Randall Okita',
                'genre' => 'Epouvante-horreur',
                'affiche' => '/assets/images/film-posters/see-for-me.jpg',
                'link' => 'https://57webbee.com',
                'resume' => "Sophie, une jeune femme aveugle, vit dans un manoir isol??, se retrouve prise au pi??ge par des voleurs qui cherchent un coffre-fort cach??. Son seul moyen de d??fense : une nouvelle application appel??e \"See For Me\". Elle la connecte ?? un volontaire ?? travers le pays qui l'aide ?? survivre en voyant ?? sa place. Sophie est mise en relation avec Kelly, un v??t??ran de l'arm??e qui passe ses journ??es ?? jouer ?? des jeux vid??os de guerre.",
                'duree' => '92',
                'status' => 'Disponible',
            ],
            [
                'title' => 'Halloween Kills',
                'realisateur' => 'David Gordon Green',
                'genre' => 'Epouvante-horreur',
                'affiche' => '/assets/images/film-posters/halloween.png',
                'link' => 'https://57webbee.com',
                'resume' => "Laurie Strode, sa fille Karen et sa petite fille Allyson viennent d???abandonner le monstre au c??l??bre masque, enferm?? dans le sous-sol de la maison d??vor??e par les flammes. Gri??vement bless??e, Laurie est transport??e en urgence ?? l???H??pital, avec la certitude qu???elle vient enfin de se d??barrasser de celui qui la harc??le depuis toujours. Mais Michael Myers parvient ?? s???extirper du pi??ge o?? Laurie l???avait enferm?? et son bain de sang rituel recommence. Surmontant sa douleur pour se pr??parer ?? l???affronter encore une fois, elle va inspirer la ville enti??re qui d??cide de l???imiter et de se soulever pour exterminer ce fl??au indestructible. Les trois g??n??rations de femmes vont s???associer ?? une poign??e de survivants du premier massacre, et prennent les choses en main en formant une milice organis??e autour de la chasse et la destruction du monstre une fois pour toutes. Le mal meurt cette nuit.",
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
