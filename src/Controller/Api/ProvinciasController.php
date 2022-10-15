<?php

namespace App\Controller\Api;

use App\Repository\MunicipiosRepository;
use App\Repository\ProvinciasRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route(path="/provincias")
 */

class ProvinciasController extends AbstractFOSRestController
{

    private $provinciaRepo;
    private $municipioRepo;

    public function __construct(ProvinciasRepository $proviRepo, MunicipiosRepository $muniRepo)
    {
        $this->provinciaRepo = $proviRepo;
        $this->municipioRepo = $muniRepo;
    }

    // Devolver todas las provincias (id y nombre)(serializer)

    /**
     * @Rest\Get (path="/")
     * @Rest\View (serializerGroups={"get_provincias"}, serializerEnableMaxDepthChecks=true)
     */

    public function getAllProvincias(Request $request){
        return $this->provinciaRepo->findAll();
    }

    // 2. Devolver los municipios de una provincia (id y nombre)(serializer)

    /**
     * @Rest\Get (path="/{id}")
     * @Rest\View (serializerGroups={"get_municipios"}, serializerEnableMaxDepthChecks=true)
     */

    public function getMunicipiosByProvincia(Request $request){
        $municipio =  $request->get('id');
        return $this->municipioRepo->findBy(['idProvincia'=> $municipio]);
    }

}