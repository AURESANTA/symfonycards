<?php

namespace App\Controller;

use App\Entity\Deckcard;
use App\Entity\Card;
use App\Entity\Deck;
use App\Repository\DeckcardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

class DeckcardController extends AbstractController
{
    /**
     * @Route("/deckcard", name="deckcard")
     */
    public function index()
    {
        return $this->render('deckcard/index.html.twig', [
            'controller_name' => 'DeckcardController',
        ]);
    }

    /**
 * @Route("/adddeckcard/{card}/{deck}", name="add_deckcard")
 */
    public function addDeckcard(Card $card, Deck $deck, EntityManagerInterface $em)
    {

        $deckcard = new Deckcard();

        $deckcard->setCard($card);
        $deckcard->setDeck($deck);

        $em->persist($deckcard);
        $em->flush();

        return $this->render('layout/form.html.twig', [
            'title' => 'test',
            'label' => 'test'
        ]);
    }

    /**
     * @Route("/deletedeckcard/{idCardDeck}", name="delete_deckcard")
     */
    public function deleteDeckcard(int $idCardDeck, DeckcardRepository $deckcardRepository, EntityManagerInterface $em)
    {
        $cardDeck = $em->getRepository('App:DeckCard')->findOneBy(['id'=>$idCardDeck]);

        if ($cardDeck) {
            $em->remove($cardDeck);
            $em->flush();
        }
        return $this->redirectToRoute('edit_deck');
    }
}

