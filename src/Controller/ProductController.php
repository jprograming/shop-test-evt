<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    /**
     * Action that shows the product detail
     * @param int $id
     * @Route("/product/{id}", name="show_product")
     * @return Response
     */
    public function showProduct(int $id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('El producto no existe!');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}
