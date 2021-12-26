<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Conference;
use App\Form\CommentFormType;
use App\Repository\CommentRepository;
use App\Repository\ConferenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ConferenceController extends AbstractController
{

    // PASO 14
    // Para hacer persistentes los datos de los formulario hace falta el administrador de entidades.
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // SECCION 
    // PASO 10

    /**
     * @Route("/", name="homepage")
     */
    public function index(ConferenceRepository $conferenceRepository, SessionInterface $session): Response
    {
        /*El parametro conferenceRepository es el repositorio de conferencias creado junto con
        las entidades. Funciona como un servicio que provee funcionalidades para acceer a la BD.        
        */

        // SECCION
        // PASO 11 SESIONES
        // $session->set('prueba','hello-world');
        // dump($session->get('prueba'));

        $conferences = $conferenceRepository->findAll();
        return $this->render('conference/index.html.twig', [ 'conferences' => $conferences ]);

    }

    /**
     * ANTES ("/conference/{id}", name="conference")
     * PASO 13
     * @Route("/conference/{slug}", name="conference")
     * 
    */
    public function show(Request $request ,CommentRepository $commentRepository, Conference $conference, string $photoDir)
    {

        // SECCION
        // PASO 14

        $comment = new Comment(); //Creamos la entidad que contendra los datos
        $form = $this->createForm(CommentFormType::class, $comment); //Creamos el formulario y le pasamos la entidad en la cual seran cargados los datos del formulario.

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()){
            
            $comment->setConference($conference);

            if($photo = $form['photo']->getData()){
                $filename = bin2hex(random_bytes(6).".".$photo->guessExtension());

                try{
                    $photo->move($photoDir, $filename);

                }catch(FileException $e){
                    // Unable to load the photo
                }
                $comment->setPhotoFilename($filename);
            }

            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            // Una ves que se enviaron los datos y son procesados se redirecciona a la misma pagina donde se visualizan los comentarios, esto evita que al usuario recargar la pagina se reenvien los mosmos datos.
            return $this->redirectToRoute('conference', ['slug'=> $conference->getSlug()] );

        }


        // Paginacion
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository->getCommentPaginator($conference, $offset);

        /* Symfony infiere que al ser una ruta que depende de un id le podemos pasar un parametro tipo entidad
        y este buscara en la tabla la fila con ese id y lo representara mediante el parametro $conference        
        */
        // Para acceder a los comentarios hay 2 vias.
            // $comments = $conference->getComments(); Y
        $comments = $commentRepository->findBy(
            ['conference' => $conference], // Parametros por donde filtrar.
            ['createdAt' => 'DESC'] // Parametro por los que ordenar.
        );

        return $this->render('conference/show.html.twig', 
            [
                'conference' => $conference,
                'comments' => $paginator,
                'previus' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
                'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
                'comment_form' => $form->createView(), //PASO 14
            ]
        );

    }



    // SECCION
    // PASO 6(Referencia)
    // /**
    //  * @Route("/hello/{name}", name="conference")
    //  */
    // public function index( string $name ): Response
    // {

    //     // $greet = '';

    //     // Obtener parametros GET mediante la url
    //     // La ruta debe definirse como y a la funcion se le debe pasar $request como parametro.
    //     /**
    //     * @Route("/conference", name="conference")
    //     */
    //     // if($name = $request->query->get('hello')) {
    //     //     $greet = sprintf('<h1>hello %s!</h1>', htmlspecialchars($name));
    //     // }

    //     // Obtener parametros como parte de la ruta
    //     // La ruta debe definirse como y en la funcion se recibe name como parametro.
    //     // /**
    //     // * @Route("/hello/{name}", name="conference")
    //     // */
    //     // if($name){
    //     //     $greet = sprintf('<h1>hello %s!</h1>', htmlspecialchars($name));
    //     // }

    //     // return new Response($greet);

    //     return $this->render('conference/index.html.twig', [
    //         'name' => $name,
    //     ]);

    // }
}
