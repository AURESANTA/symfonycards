<?php

namespace App\Controller;

use App\Entity\Card;
use App\Entity\Deckcard;
use App\Form\CardType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CardController extends AbstractController
{

    /**
     * @Route("/listcard", name="list_card")
     */
    public function listCards(EntityManagerInterface $em)
    {
        $cards = $em->getRepository('App:Card')->findAll();
        return $this->render('layout/index.html.twig', [
            'cards' => $cards,
            'title' => 'Liste des cartes'
        ]);
    }

    /**
     * @Route("/addcard", name="add_card")
     */
    public function addCard(Request $request, EntityManagerInterface $em)
    {
        $card = new Card();
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid())
        {

            $image = $form->get('image')->getData();

            $imageName = 'card-'.uniqid().'.'.$image->guessExtension();
            $image->move(
                $this->getParameter('cards_folder'),
                $imageName
            );
            $card->setImage($imageName);

            $card->setCreator($this->getUser());
            $em->persist($card);
            $em->flush();
            $this->addFlash('success', 'Carte ajoutée');

        }

        return $this->render('layout/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Cartes',
            'label' => 'Ajouter une carte'
        ]);
    }

    /**
     * @Route("/editcard/{cardID}", name="edit_card")
     * @ParamConverter("card", options={"id"="cardID"})
     */

    public function editCard(Card $card, Request $request, EntityManagerInterface $em)
    {

        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        $imgName = $card->getImage();

        if ($form->isSubmitted() && $form->isValid())
        {

            if ($form->get('image')->getData() !== null) {

                $image = $form->get('image')->getData();
                $imageName = 'card-'.uniqid().'.'.$image->guessExtension();
                $image->move(
                    $this->getParameter('cards_folder'),
                    $imageName);
                $card->setImage($imageName);
            }
            else
                {
                    if (!empty($imgName) || $imgName !== null)
                    {
                        $card->setImage($imgName);
                    }
                    else {
                        $card->setImage("");
                    }
            }
            $em->persist($card);
            $em->flush();

            $this->addFlash('success', 'Carte modifiée !');
        }
        return $this->render('layout/editform.html.twig', [
            'form' => $form->createView(),
            'card' => $card,
            'title' => 'Cartes',
            'label' => 'Modifier une carte'
        ]);
    }

    /**
     * @Route("/deletecard/{cardID}", name="delete_card")
     * @ParamConverter("card", options={"id"="cardID"})
     */

    public function deleteCard(Card $card, EntityManagerInterface $em)
    {

        $deckcard = new Deckcard();
        $card->removeDeckcard($deckcard);
        $em->remove($card);
        $em->flush();

        $this->addFlash('success', 'Carte supprimée !');

        return $this->redirectToRoute('list_card');
    }
}
