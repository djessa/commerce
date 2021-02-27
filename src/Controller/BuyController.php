<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BuyController extends AbstractController
{
    /**
     * @Route("/buy/is_client", name="buy_is_client")
     */
    public function is_client(): Response
    {
        return $this->render('buy/is_client.html.twig');
    }

    /**
     * @Route("/buy", name="buy")
     */
    public function index(): Response
    {
        $form = $this->createFormBuilder();
        return $this->render('buy/index.html');
    }
}
