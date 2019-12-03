<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use http\Symfony\Component\HttpFoundation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ClientsController extends AbstractController
{
    /**
     * @Route("/home/index", name="index_clients")
     */
    public function index()
    {
        $em=$this->getDoctrine()->getManager();
        $repository=$em->getRepository(Client::class);

        $clients=$repository->findAll();


        return $this->render('home/index.html.twig', [
            "clients"=>$clients,
        ]);
    }

    /**
     * @Route("/clients/ajouter", name="ajouter_clients")
     */
    public function ajouter(\Symfony\Component\HttpFoundation\Request $request)
    {

        $client=new Client();


        //création du formulaire
        $formulaire=$this->createForm(ClientType::class, $client);

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid())
        {
            //récupérer l'entity manager (sorte de connexion à la BDD)
            $em=$this->getDoctrine()->getManager();

            //je dis au manager que je veux ajouter la catégorie dans la BDD
            $em->persist($client);

            $em->flush();

            return $this->redirectToRoute("home");
        }

        return $this->render('clients/formulaire.html.twig', [
            "formulaire"=>$formulaire->createView(),
        ]);
    }
    /**
 * @Route("/clients/modifier/{id}", name="modifier_clients")
 */
    public function modifier(int $id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Client::class);
        $client = $repository->find($id);

        //création du formulaire
        $formulaire = $this->createForm(ClientType::class, $client);

            $formulaire->handleRequest($request);

            if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            //récupérer l'entity manager (sorte de connexion à la BDD)
            $em = $this->getDoctrine()->getManager();

            //je dis au manager que je veux ajouter la catégorie dans la BDD
            $em->persist($client);

            $em->flush();

            return $this->redirectToRoute("home");
        }

        return $this->render('clients/modifier.html.twig', [
            "formulaire" => $formulaire->createView(),
            "h1" => "Modification de la société <i>" . $client->GetSociete() . "</i>",
        ]);
    }

    /**
     * @Route("/clients/supprimer/{id}", name="supprimer_clients")
     */
    public function supprimer(Client $client, int $id)
    {

            if (!$client) {
                throw $this->createNotFoundException('No client found');
            }
            $em = $this->getDoctrine()->getManager();

            $em->remove($client);
            $em->flush();
        return $this->redirectToRoute("home");
    }

}
