<?php

namespace App\Controller\Api;

use App\Entity\Direccion;
use App\Form\DireccionType;
use App\Repository\ClienteRepository;
use App\Repository\DireccionRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route(path="/direccion")
 */

class DireccionController extends AbstractFOSRestController
{
    private $direccionRepo;

    public function __construct(DireccionRepository $direccionRepository){
        $this->direccionRepo = $direccionRepository;
    }

    /**
     * @Rest\Post (path="/")
     * @Rest\View (serializerGroups={"post_dir"}, serializerEnableMaxDepthChecks=true)
     */

    public function createDireccion(Request $request){
        $direccion = new Direccion();
        $form = $this->createForm(DireccionType::class, $direccion);
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()){
            return new JsonResponse('Bad data', 400);
        }
        $this->direccionRepo->add($direccion,true);
        return $direccion;
    }

    // Creamos un Endpoint que devuelva todas las direcciones en base al id de un cliente
    /**
     * @Rest\Get (path="/{id}")
     * @Rest\View (serializerGroups={"get_dir_cliente"}, serializerEnableMaxDepthChecks=true)
     */
    public function getDireccionesByCliente(Request $request, ClienteRepository $clienteRepository){
        $idCliente = $request->get('id');
        // 1. Traerme el cliente de base de datos
        $cliente = $clienteRepository->find($idCliente);
        // 2. Una vez tengo el cliente, compruebo si existe, y si no devuelvo error
        if (!$cliente){
            return new JsonResponse('Client is not found', Response::HTTP_NOT_FOUND);
        }
        // 3. Si existe, busco en la tabla direccion por el campo cliente
        $direcciones = $this->direccionRepo->findBy(['cliente' => $cliente]);
        return $direcciones;
    }

//    // Get direccion
//
//    /**
//     * @Rest\Get (path="/{id}")
//     * @Rest\View (serializerGroups={"get_dir"}, serializerEnableMaxDepthChecks=true)
//     */
//    public function getDireccion(Request $request){
//        $idDireccion = $request->get('id');
//        $address = $this->direccionRepo->find($idDireccion);
//        if (!$address){
//            return new JsonResponse('Address cannot be find', Response::HTTP_BAD_REQUEST);
//        }
//        return $address;
//    }

    // Update direccion

    /**
     * @Rest\Patch (path="/{id}")
     * @Rest\View (serializerGroups={"up_dir"}, serializerEnableMaxDepthChecks=true)
     */
    public function updateDireccion(Request $request){
        $idDireccion = $request->get('id');
        $direccion = $this->direccionRepo->find($idDireccion);
        if (!$direccion){
            return new JsonResponse('Address cannot be found or exists');
        }
        $form = $this->createForm(DireccionType::class, $direccion, ['method'=>$request->getMethod()]);
        $form->handleRequest($request);
        if (!$form->isValid() || !$form->isSubmitted()){
            return new JsonResponse('Not exists', 404);
        }
        $this->direccionRepo->add($direccion, true);
        return $direccion;
    }

    // Delete direccion

    /**
     * @Rest\Delete (path="/{id}")
     */
    public function deleteDireccion(Request $request){
        $idDireccion = $request->get('id');
        $direccion = $this->direccionRepo->find($idDireccion);
        if (!$direccion){
            return new JsonResponse('Address for delete not be found', 400);
        }
        $this->direccionRepo->remove($direccion, true);
        return new JsonResponse('Address has been removed', 200);
    }



}