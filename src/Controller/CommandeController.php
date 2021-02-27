<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use App\Repository\LigneCommandeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    /**
     * @Route("/admin/commande", name="commande")
     */
    public function index(CommandeRepository $commande, Request $request, PaginatorInterface $paginator): Response
    {
        $commandes = $paginator->paginate(
            $commande->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1),
            8
        );
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }
}
