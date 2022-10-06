<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoriaController extends AbstractController
{
    /**
     * @Route ("/categoria", name="create_categoria")
     */
    public function createCategoriaAction(Request $request, EntityManagerInterface $em){
        // 1. Cogemos la información a guardar que nos vinee en la petición (request)
        $nombreCategoria= $request->get('categoria');

        // 2. Creamos un nuevo objeto JsonResponse que va a ser la respuesta que enviaremos de vuelta
        $response = new JsonResponse();

        // 3.Tengo que comprobar que la cagegoría no venga a null o no venga.
        if (!$nombreCategoria){ # Solo pasa si es null o no tiene valor asignado, o si es entero es igual a 0, o es false
            // Nos han enviado mal los datos en la petición (request)
            $response->setData([
                'success' => false,
                'data' => null,
                'error' => 'Categoría controller cannot be null or empty'
            ]);
                return $response;
        }
        // 4. Me ha llegado bien el request, tengo que crear un objeto y setear o modificar sus atributos
        $categoria = new Categoria();
        $categoria->setCategoria($nombreCategoria);

        // 5. Una vez creado el objeto, ya podemos guardarlo en la base de datos con EntityManagerInterface
        $em->persist($categoria); # Doctrine -> Prepara la query para guardar el objeto en base de datos.
        $em->flush(); # Doctrine -> Ejecuta las querys que tenga pendientes

        // 6. Siempre devolver una respuesta (response)
        $response->setData([
           'success' => true,
           'data' => [
                'id' => $categoria->getId(),
               'categoria' => $categoria->getCategoria(),
           ]
        ]);
        return $response;
    }


    /**
     * @Route ("/categoria/list", name="categoria_list")
     */

    public function getAllCategorias(CategoriaRepository $categoriaRepository){
        // 1. Llamar al método del repository
        $categorias = $categoriaRepository->findAll();
        // 2. Comprobar que hay algo
       # if(!categorias){
       #    // Enviar respuesta de error como hemos hecho más arriba (response)
       # }
        // Pero ese array de categoría hay que enviarlo en formato Json,
        // Symfony no sabe pasar de array de objetos a Json,
        // Hay que coger cada objeto del array y pasarlo a Json por separado
        $catergoriasAsArray= [];
        foreach ($categorias as $cat){
            $categoriasAsArray[] = [
                'id' => $cat->getId(),
                'categoria' => $cat->getCategoria(),
            ];
        }

        $response = new JsonResponse();
        $response->setData([
           'success' => true,
           'data' => $categoriasAsArray,
        ]);
        return $response->setStatusCode(404);
    }
}