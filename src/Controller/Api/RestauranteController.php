<?php

namespace App\Controller\Api;

use App\Entity\Restaurante;
use App\Form\RestauranteType;
use App\Repository\RestauranteRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/restaurante")
 */
class RestauranteController extends AbstractFOSRestController
{
       private $restRepo;

       public function __construct(RestauranteRepository $repository){
           $this->restRepo = $repository;
       }

       // 1. Devolver restaurante por id
       // Sirve para mostrar la página del restaurante con toda su información.
        /**
         * @Rest\Get (path="/{id}")
         * @Rest\View (serializerGroups={"get_restaurante"}, serializerEnableMaxDepthChecks=true)
         */
        public function getRestaurante(Request $request){
            $idRestaurante = $request->get('id');
            $restaurante = $this->restRepo->find($idRestaurante);
            if (!$restaurante){
                return new JsonResponse('Restaurant not exists', Response::HTTP_NOT_FOUND);
            }
            return $restaurante;
        }

        // 2. Devolver listado de restaurantes, según día, hora y municipio
        // Primero seleccionamos la dirección a la que se le va a enviar la comida
        // Luego seleccionamos día y hora para el reparto
        // Por último mostraremos los restaurantes que cumplan esas condiciones
    /**
     * @Rest\Post (path="/filtered")
     * @Rest\View (serializerGroups={"rest_filtered"}, serializerEnableMaxDepthChecks=true)
     */
    public function getRestaurantesBy(Request $request){
        $dia = $request->get('dia');
        $hora = $request->get('hora');
        $idMunicipio = $request->get('municipio');
        // Comprobar que esos datos son correctos si no devuelve bad request
        if (!$dia || !$hora || !$idMunicipio){
            return new JsonResponse('Bad Request', Response::HTTP_BAD_REQUEST);
        }
        $restaurantes = $this->restRepo->findByDayTimeMunicipio($dia, $hora, $idMunicipio);
        return $restaurantes;
    }

    // Created restaurante
    /**
     * @Rest\Post (path="/")
     * @Rest\View (serializerGroups={"new_restaurante"}, serializerEnableMaxDepthChecks=true)
     */
    public function newRestaurante(Request $request){
        $restaurante = new Restaurante();
        $form = $this->createForm(RestauranteType::class, $restaurante);
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()){
            return new JsonResponse('Bad request', Response::HTTP_BAD_REQUEST);
        }
        $this->restRepo->add($restaurante, true);
        return $restaurante;

    }

}