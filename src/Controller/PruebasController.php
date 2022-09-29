<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PruebasController extends AbstractController
{

    private $logger;

    public function __construct(LoggerInterface $logger){
        $this->logger = $logger;

    }
    // Tenemos que definir como és el endpoint para poder hacer la petición desde el cliente
    // ENDPOINT
    /**
     * @Route ("/get/usuarios", name="get_users")
     */

    public function getAllUser(Request $request){
       //Llamará a base de datos y se traerá toda la lista de users
        //Devolver una respuesta en formato JSON
        //Request - Petición
        //Response - Hay que devolver una respuesta
         $response = new Response(); // Esto lleva código de estado.
         $response->setContent('<div>Hola Mundo</div>');
        // Capturamos los datos que vienen en el Request
        $id = $request->get('id');
        $this->logger->alert('Mensaje Logger');
        // Query sql para traer el user con id = $id
        $response = new JsonResponse();
        $response->setData([
           'succes' => true,
           'data' =>
               [
               'id' => $id, // Parse int es intval();
               'nombre' => 'Pepe',
               'email' => 'pepe@email.com'
              ],

        ]);
        return $response;
    }
}