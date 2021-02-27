<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="client")
     */
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
    /**
     * @Route("/client/new", name="client_new")
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $client->setPassword(md5($client->getPassword()));
            $em->persist($client);
            $em->flush();
            return $this->redirectToRoute('buy', ['id' => $client->getId()]);
        }
        return $this->render('client/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/client/sign_in", name="client_sign_in")
     */
    public function sign_in(Request $request, ClientRepository $clients): Response
    {
        $data = $request->request;
        if(!empty($data)) {
            $email = $data->get('email', '');
            $password = md5($data->get('password', ''));
            $client = $clients->findBy(['email' => $email]);
            if($client) {
                if($client[0]->getPassword() === $password) {
                    return $this->redirectToRoute('buy', ['id' => $client[0]->getId()]);
                }
            }
        }
        return $this->render('client/sign_in.html.twig');
    }


}
