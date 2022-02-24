<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController {

    /* function index() {
        var_dump(
            "Salut tu es sur l'index"
        );

        die();
    } */

    /* function test( $req ) {
        // $prenom = $_GET['prenom'];

        // $req = Request::createFromGlobal();
        $prenom = $req -> query -> get('prenom', 0);

        echo '<pre>';

        var_dump(
            'Salut ' . $prenom
        );

        echo '</pre>';

        die();
    } */

    /* function profile( $prenom ) {

        dd(
            'Salut ' . $prenom
        );


        die();
    } */



    /**
     * @Route("/profile_prenom/{prenom}", name="profile")
     */
    /* public function profile_prenom($prenom)
    {
        dd(
            'Mon prénom est ' . $prenom
        );
    } */


    /**
     * @Route("/profile_nom/{nom}", name="nom")
     */
    // public function profile_nom($nom)
    // {
    //     /* dd(
    //         'Mon nom famille est  ' . $nom
    //     ); */

    //     // return new Response('Test');

    //     // return new Response('<div class="test">' .$nom . '</div>');

    //     return $this -> render(
    //         'default/index.html.twig', ['nom' => $nom]
    //     );
    // }

    /**
     * @Route("/profile_age/{age}", name="age")
     */
    // public function profile_age($age)
    // {
    //     return $this -> render(
    //         'default/index.html.twig', ['age' => $age]
    //     );
    // }

    /**
     * @Route("/numero/{numero?2}/seance/{seance?l}", name="numero", requirements={"numero"="\d+"})
     */
    public function cinema($numero, $seance)
    {
        $film = 'Le roi Lion';

        return $this -> render(
            'default/index.html.twig', ['numero' => $numero, 'seance' => $seance, 'film' => $film]
        );
    }
}