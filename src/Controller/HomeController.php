<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class HomeController extends AbstractController
{

    /**
     * Action that shows the homepage
     * @Route("/", name="home", methods={"GET"})
     * @return Response
     */
    public function index()
    {        
        return $this->render('home/index.html.twig');
    }

    /**
     * Action that shows the homepage
     * @Route("/store", name="store", methods={"GET"})
     * @return Response
     */
    public function store()
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('home/store.html.twig', [
            'products' => $products
        ]);
    }
}
