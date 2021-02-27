<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Repository\ClientRepository;
use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class BuyController extends AbstractController
{
    /**
     * @Route("/buy/is_client", name="buy_is_client")
     */
    public function is_client(Request $request, ClientRepository $clients): Response
    {
        $data = $request->request;
        if(!empty($data)) {
            if($data->get('is_client') == "false") {
                return $this->redirectToRoute('client_new');
            } elseif($data->get('is_client') == "true") {
                return $this->redirectToRoute('client_sign_in');
            }
        }
        return $this->render('buy/is_client.html.twig');
    }

    /**
     * @Route("/buy/{id}", name="buy")
     */
    public function index(Client $client, EntityManagerInterface $em, Request $request, SessionInterface $session, ProductRepository $productRepository)
    {
        if($request->request->get('numero')) {
           $panier = $session->get('panier');
           $commande = new Commande;
           $commande->setClient($client)
                    ->setCreatedAt(new \DateTime());
           foreach($panier as $id => $value) {
               $ligne = new LigneCommande;
               $ligne->setProduct($productRepository->find($id))
                     ->setQuantity($value);
               unset($panier[$id]);
               $commande->addLigneCommande($ligne);
               $em->persist($ligne);
           }
           $em->persist($commande);
           $em->flush();
           $session->set('panier', $panier);
           return $this->redirectToRoute('cart');
        }
        return $this->render('buy/index.html.twig', compact('client'));
    }

}
