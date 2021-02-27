<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
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
    public function index(Client $client, EntityManagerInterface $em, Request $request, SessionInterface $session)
    {
        if($request->request->get('numero')) {
           $panier = $session->get('panier');
           foreach($panier as $key => $value) {
               unset($panier[$key]);
           }
           $session->set('panier', $panier);
           return $this->redirectToRoute('cart');
        }
        return $this->render('buy/index.html.twig', compact('client'));
    }

}
