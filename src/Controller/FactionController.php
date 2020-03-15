<?php

namespace App\Controller;

use App\Entity\Faction;
use App\Form\FactionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class FactionController extends AbstractController
{
    /**
     * @Route("/faction", name="faction")
     */
    public function index()
    {
        return $this->render('faction/index.html.twig', [
            'controller_name' => 'FactionController',
        ]);
    }

    /**
     * @Route("/listfaction", name="list_faction")
     */
    public function listFaction(EntityManagerInterface $em)
    {
        $factions = $em->getRepository('App:Faction')->findAll();
        return $this->render('layout/index.html.twig', [
            'factions' => $factions,
            'title' => 'Liste des factions'
        ]);
    }

    /**
     * @Route("/addfaction", name="add_faction")
     */
    public function addFaction(Request $request, EntityManagerInterface $em)
    {
        $faction = new Faction();
        $form = $this->createForm(FactionType::class, $faction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $em->persist($faction);
            $em->flush();
            $this->addFlash('success', 'Faction ajoutée');

        }

        return $this->render('layout/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Factions',
            'label' => 'Ajouter une faction'
        ]);
    }
}
