<?php

namespace App\Controller;

use App\Entity\Client;
use phpDocumentor\Reflection\DocBlock\ExampleFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use App\Form\ClientType;
use http\Symfony\Component\HttpFoundation;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
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
}
