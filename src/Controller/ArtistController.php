<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Artist;

class ArtistController extends AbstractController
{
    /**
     * @Route("/artist", name="artist")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Artist::class);
        $artists = $repository->findAll();


        return $this->render('artist/index.html.twig', [
            'artists' => $artists,
            'ressource' => 'artistes',
        ]);
    }
    /**
     * @Route("/artist/{id}", name="artist_show")
     */
    public function show($id)
    {
        $repository = $this->getDoctrine()->getRepository(Artist::class);
        $artist = $repository->find($id);


        return $this->render('artist/show.html.twig', [
            'artist' => $artist,
        ]);
    }
}
