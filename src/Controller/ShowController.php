<?php

namespace App\Controller;

use App\Entity\Show;
use App\Form\ShowType;
use App\Entity\Category;
use Cocur\Slugify\Slugify;
use App\Repository\ShowRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Reservation;
use App\Form\ReservationType;


class ShowController extends AbstractController
{
    /**
     * @Route("/show", name="show", methods={"GET"})
     */
    public function index(ShowRepository $showRepository): Response
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Category::class);
        $categories = $repository->findAll();
                
        return $this->render('show/index.html.twig', [
            'shows' => $showRepository->findAll(),
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/show/cat/{category}", name="show_index_cat", methods={"GET"})
     */
    public function indexCategory(Request $request, ShowRepository $showRepository): Response
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Category::class);
        $category = $repository->findByName($request->get('category'));
        $categories = $repository->findAll();

        return $this->render('show/index.html.twig', [
            'shows' => $showRepository->findBy([
                'category'=>$category,
            ]),
            'categories' => $categories,
        ]);
    }
    
    /**
     * @Route("/show/new", name="show_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NULL, 'Accès interdit');
        
        $show = new Show();
        $form = $this->createForm(ShowType::class, $show);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slugify = new Slugify();
            $show->setSlug($slugify->slugify($show->getTitle()));
            
            //Affecter la catégorie 'inconnue' à un nouveau spectacle sans catégorie
            if(is_null($show->getCategory())) {
                $repository = $this->getDoctrine()->getManager()->getRepository(Category::class);
                $unknownCat = $repository->findOneByName('inconnue');
                
                $show->setCategory($unknownCat);
            }
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($show);
            $entityManager->flush();

            return $this->redirectToRoute('show');
        }

        return $this->render('show/new.html.twig', [
            'show' => $show,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}/flip_bookable", name="show_flip_bookable", methods={"GET", "POST"})
     */
    public function flipBookable(Request $request, Show $show): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NULL, 'Accès interdit');
        
        $show->setBookable(!$show->getBookable());        
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($show);
        $entityManager->flush();
        
        $response = new Response();
        $response->setContent(json_encode([
            'data' => true,
        ]));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }

        /**
     * @Route("/show/{id}", name="show_show")
     */
    public function show($id, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Show::class);
        $show = $repository->find($id);

        $collaborateurs = [];
        
        foreach($show->getArtistTypes() as $at) {
            $collaborateurs[$at->getType()->getType()][] = $at->getArtist();
        }
        
        //Gestion de la réservation d'une représentation
        $reservation = new Reservation();
        
        $form = $this->createForm(ReservationType::class,$reservation);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
           //Associer l'utilisateur en cours à la réservation
           $reservation->setUtilisateur($this->getUser());
           
           //Redirection vers Reservation.pay
           //$this->redirectToRoute('reservation_pay',['reservation'=>$reservation]);
           return $this->render('reservation/pay.html.twig', [
            'reservation' => $reservation,
        ]);
        }
        
        return $this->render('show/show.html.twig', [
            'show' => $show,
            'collaborateurs' => $collaborateurs,
            'formReservation' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}/edit", name="show_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Show $show): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NULL, 'Accès interdit');
        
        $form = $this->createForm(ShowType::class, $show);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('show', [
                'id' => $show->getId(),
            ]);
        }

        return $this->render('show/edit.html.twig', [
            'show' => $show,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="show_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Show $show): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NULL, 'Accès interdit');
        
        if ($this->isCsrfTokenValid('delete'.$show->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($show);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }
}
