<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Agent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AgentType;

class AgentController extends AbstractController
{
    /**
     * @Route("/agent", name="agent")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Agent::class);
        $agents = $repository->findAll();

        return $this->render('agent/index.html.twig', [
            'agents' => $agents,
            'ressource' => 'agents',
        ]);
    }
    /**
     * @Route("/agent/new", name="agent_create")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $agent = new Agent();

        $form = $this->createForm(AgentType::class, $agent);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($agent);

            $manager->flush();

            return $this->redirectToRoute('agent_show', ['id'=>$agent->getId()]);
        }

        return $this->render('agent/create.html.twig', [
            'agent' => $agent,
            'formAgent'=> $form->createView(),
        ]);
    }
    /**
     * @Route("/agent/{id}", name="agent_show")
     */
    public function show($id)
    {
        $repository = $this->getDoctrine()->getRepository(Agent::class);
        $agent = $repository->find($id);

        return $this->render('agent/show.html.twig', [
            'agent' => $agent,
        ]);
    }
}
