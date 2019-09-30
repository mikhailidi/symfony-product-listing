<?php

namespace App\Application\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @package App\Application\Controller\Web
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/product/list", methods={"GET"}, name="product.index")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->render('product/index.html.twig');
    }
}
