<?php

namespace App\Controller;

use App\Entity\Faction;
use App\Entity\Passive;
use App\Form\PassiveType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class PassiveController extends AbstractController
{

    /**
     * @Route("/listpassive", name="list_passive")
     */
    public function listPassive(EntityManagerInterface $em)
    {
        $passives = $em->getRepository('App:Passive')->findAll();
        return $this->render('layout/index.html.twig', [
            'passives' => $passives,
            'title' => 'Liste des passifs'
        ]);
    }

    /**
     * @Route("/addpassive", name="add_passive")
     */
    public function addPassive(Request $request, EntityManagerInterface $em)
    {
        $passive = new Passive();
        $form = $this->createForm(PassiveType::class, $passive);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $em->persist($passive);
            $em->flush();
            $this->addFlash('success', 'Passif ajouté');

        }

        return $this->render('layout/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Passifs',
            'label' => 'Ajouter un passif'
        ]);
    }
}
