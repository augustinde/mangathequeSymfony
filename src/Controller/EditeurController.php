<?php

namespace App\Controller;

use App\Entity\Editeur;
use App\Form\EditeurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditeurController extends AbstractController
{
    /**
     * @Route("/editeur", name="editeur")
     */
    public function index(): Response
    {
        return $this->render('editeur/index.html.twig', [
            'controller_name' => 'EditeurController',
        ]);
    }

    /**
     * @Route("addediteur", name="create_editeur")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function formCreateEditeur(Request $request, EntityManagerInterface $em) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $editeur=new Editeur();
        $form=$this->createForm(EditeurType::class,$editeur);

        $form->handleRequest($request);
        $resultat='Complétez le formulaire pour insérer un éditeur';

        if($form->isSubmitted()&&$form->isValid()){
            dump($editeur);
            $em->persist($editeur);
            $em->flush();
            $resultat='Editeur inséré avec l\'id'.$editeur->getId();
        }
        return $this->render('editeur/addediteur.html.twig',['resultat'=>$resultat,'form'=>$form->createView()
        ]);

    }

}
