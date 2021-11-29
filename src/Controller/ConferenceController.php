<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConferenceController extends AbstractController
{
    /**
     * @Route("/hello/{name}", name="conference")
     */
    public function index( string $name ): Response
    {

        // $greet = '';

        // Obtener parametros GET mediante la url
        // La ruta debe definirse como y a la funcion se le debe pasar $request como parametro.
        /**
        * @Route("/conference", name="conference")
        */
        // if($name = $request->query->get('hello')) {
        //     $greet = sprintf('<h1>hello %s!</h1>', htmlspecialchars($name));
        // }

        // Obtener parametros como parte de la ruta
        // La ruta debe definirse como y en la funcion se recibe name como parametro.
        // /**
        // * @Route("/hello/{name}", name="conference")
        // */
        // if($name){
        //     $greet = sprintf('<h1>hello %s!</h1>', htmlspecialchars($name));
        // }

        // return new Response($greet);

        return $this->render('conference/index.html.twig', [
            'name' => $name,
        ]);

    }
}
