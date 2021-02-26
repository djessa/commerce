<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(ProductRepository $productRepository, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);

        $panierWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $productRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;

        foreach ($panierWithData as $couple) {
            $total += $couple['product']->getPrice() * $couple['quantity'];
        }

        return $this->render('cart/index.html.twig', [
            "items" => $panierWithData,
            "total" => $total
        ]);
    }
    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add($id, SessionInterface $sessionInterface)
    {
        $panier = $sessionInterface->get('panier', []);
        if(empty($panier[$id])) {
            $panier[$id] = 0;
        }
        $panier[$id]++;
        $sessionInterface->set('panier', $panier);
        return $this->redirectToRoute('app_home');
    }
    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function remove($id, SessionInterface $sessionInterface)
    {
        $panier = $sessionInterface->get('panier', []);
        unset($panier[$id]);
        $sessionInterface->set('panier', $panier);
        return $this->redirectToRoute('cart');
    }
}
