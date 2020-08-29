<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/utilisateur", name="utilisateur", methods={"GET"})
     */
    public function index(UtilisateurRepository $utilisateurRepository): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurRepository->findAll(),
            'ressource' => 'utilisateurs',
        ]);
    }

    /**
     * @Route("/utilisateur/{id}", name="utilisateur_show", methods={"GET"})
     */
    public function show(Utilisateur $utilisateur): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        if($this->getUser()->getId()!==$utilisateur->getId()) {
            return $this->redirectToRoute('home');
        }
        
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    /**
     * @Route("utilisateur/{id}/edit", name="utilisateur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Utilisateur $utilisateur, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        if($this->getUser()->getId()!==$utilisateur->getId()) {
            return $this->redirectToRoute('home');
        }
        
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get('password')->getData();
            $newPassword = $form->get('newPassword')->getData();
            $confPassword = $form->get('confPassword')->getData();
            
            //L'ancien mot de passe a été fourni
            if($oldPassword!='') {                
                //L'ancien mot de passe correspond
                if($passwordEncoder->isPasswordValid($utilisateur, $oldPassword)) {
                    if(!empty($newPassword)) {
                        //Le nouveau mot de passe est confirmé
                        if($newPassword==$confPassword) {
                            //Crypter le nouveau mot de passe
                            $utilisateur->setPassword(
                                $passwordEncoder->encodePassword(
                                    $utilisateur,
                                    $form->get('newPassword')->getData()
                                )
                            );

                            //Sauvegarde des infos (mot de passe compris)
                            $manager = $this->getDoctrine()->getManager();
                            $manager->persist($utilisateur);
                            $manager->flush();

                            return $this->redirectToRoute('utilisateur_show', [
                                'id' => $utilisateur->getId(),
                            ]);
                        } else {
                            $form->addError(new FormError('Les deux mots de passe ne correspondent pas!'));
                        }
                    } else {
                        $form->addError(new FormError('Le mot de passe ne peut être vide!'));
                    }
                } else {
                    $form->addError(new FormError('Le mot de passe fourni n\'est pas valide!'));
                }
            } else {
                //Sauvegarde des autres infos (sauf mot de passe)
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($utilisateur);
                $manager->flush();

                return $this->redirectToRoute('utilisateur_show', [
                    'id' => $utilisateur->getId(),
                ]);
            }
        }

        return $this->render('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/utilisateur/{id}", name="utilisateur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Utilisateur $utilisateur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($utilisateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
