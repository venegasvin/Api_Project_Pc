<?php

namespace App\Controller\Api;

use App\Entity\Cliente;
use App\Form\ClienteType;
use App\Repository\ClienteRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Establecemos la ruta padre

/**
 * @Rest\Route("/cliente")
 */
class ClienteController extends AbstractFOSRestController
{
        private $repo;

        public function __construct(ClienteRepository $repo){
            $this->repo = $repo;

        }

        // Crear cliente
    /**
     * @Rest\Post (path="/")
     * @Rest\View (serializerGroups={"post_cliente"},serializerEnableMaxDepthChecks=true)
     */
    public function createCliente(Request $request){
        $cliente = new Cliente();
        $form = $this->createForm(ClienteType::class, $cliente);
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()){
            //return new JsonResponse('Bad data', 400); 2 formas de devolver
            return $form;
        }
        // Guardamos en bd
        $this->repo->add($cliente, true);
        return $cliente;
    }

    // Get one Cliente

    // Traer una categoría
    /**
     * @Rest\Get (path="/{id}")
     * @Rest\View (serializerGroups={"get_cliente"}, serializerEnableMaxDepthChecks= true)
     */
    public function getCliente(Request $request){
        $idCliente = $request->get('id');
        $cliente = $this->repo->find($idCliente);
        if (!$cliente){
            return new JsonResponse('Cliente not found', Response::HTTP_NOT_FOUND);
        }
        return $cliente;
    }

    /**
     * @Rest\Patch (path="/{id}")
     * @Rest\View (serializerGroups={"up_cliente"}, serializerEnableMaxDepthChecks=true)
     */
    public function updateCliente(Request $request){
        $idCliente = $request->get('id');
        $cliente = $this->repo->find($idCliente);
        if (!$cliente){
            return new JsonResponse('Client not found', Response::HTTP_NOT_FOUND);
        }
        $form = $this->createForm(ClienteType::class, $cliente, ['method' => $request->getMethod()]);
        $form->handleRequest($request);
        if (!$form->isValid() || !$form->isSubmitted()){
            return new JsonResponse('Bad data', 400);
        }
        $this->repo->add($cliente, true);
        return $cliente;
    }

    // Delete (No interesa que le pases al cliente una opción para poder borrar clientes por él mismo)

//    /**
//     * @Rest\Delete (path="/{id}")
//     */
//    public function deleteCliente(Request $request){
//        $idCliente = $request->get('id');
//        $cliente = $this->repo->find($idCliente);
//        if (!$cliente){
//            return new JsonResponse('Client for delete not be found', 400);
//        }
//        $this->repo->remove($cliente, true);
//        return new JsonResponse('Client has been removed', 200);
//    }

}