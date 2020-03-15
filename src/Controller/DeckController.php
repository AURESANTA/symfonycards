<?php

namespace App\Controller;

use App\Entity\Deck;
use App\Form\DeckType;
use App\Repository\CardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;

class DeckController extends AbstractController
{

    /**
     * @Route("/listdeck", name="list_deck")
     */
    public function listDecks(EntityManagerInterface $em)
    {
        $id_user = $this->getUser();
        $decks = $em->getRepository('App:Deck')->findBy(array('creator'=>$id_user));
        return $this->render('layout/index.html.twig', [
            'decks' => $decks,
            'title' => 'Decks '
        ]);
    }

    /**
     * @Route("showdeck/{deckID}", name="show_deck")
     * @ParamConverter("deck", options={"id"="deckID"})
     * @param Deck $deck
     */
    public function showDeck(Deck $deck)
    {
        $cardsInDeck = $deck->getDeckcards();

        return $this->render('layout/informations.html.twig', [
            'cardsInDeck' => $cardsInDeck,
            'deck' => $deck,
    ]);
    }

    /**
     * @Route("/adddeck", name="add_deck")
     */
    public function addDeck(EntityManagerInterface $em, Request $request)
    {
        $deck = new Deck();
        $form = $this->createForm(DeckType::class, $deck);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid())
        {

            $deck->setCreator($this->getUser());

            $em->persist($deck);
            $em->flush();
            $this->addFlash('success', 'Deck ajouté');

        }

        return $this->render('layout/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Deck',
            'label' => 'Ajouter un deck'
        ]);

    }

    /**
     * @Route("editdeck/{id}", name="edit_deck")
     */
    public function edit(Request $request, Deck $deck,CardRepository $CardRepository, EntityManagerInterface $em)
    {

        $form = $this->createForm(DeckType::class, $deck);
        $form->handleRequest($request);

        $deckName = $deck->getDeckname();

        $cardsListStorage = $CardRepository->findAll();
        $cardsInDeck = $deck->getDeckcards();

        //màj du nom
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('show_deck',['id'=>$deck->getId()]);
        }

        return $this->render('layout/edit.html.twig', [
            'title' => "Edition du deck - $deckName",
            'cardsInDeck' => $cardsInDeck,
            'cardsListStorage' => $cardsListStorage,
            'deck' => $deck,
            'form' => $form->createView()
        ]);
    }
}



