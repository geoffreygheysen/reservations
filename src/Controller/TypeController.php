<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Type;

class TypeController extends AbstractController
{
    /**
     * @Route("/type", name="type")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Type::class);
        $types = $repository->findAll();

        return $this->render('type/index.html.twig', [
            'types' => $types,
            'ressource' => 'types',
        ]);
    }
    /**
     * @Route("/type/{id}", name="type_show")
     */
    public function show($id)
    {
        $repository = $this->getDoctrine()->getRepository(Type::class);
        $type = $repository->find($id);

        return $this->render('type/show.html.twig', [
            'type' => $type,
            
        ]);
    }
}
