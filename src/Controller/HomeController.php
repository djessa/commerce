<?php

namespace App\Controller;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(ProductRepository $productRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $products = $paginator->paginate(
            $productRepository->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1),
            12
        );
        return $this->render('home/index.html.twig', compact('products'));
    }
}
