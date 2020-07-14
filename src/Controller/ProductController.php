<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ProductController extends AbstractController
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/product", methods={"GET"}, name="product_list", )
     * @IsGranted("ROLE_USER")
     *
     */
    public function list()
    {
        $products = $this->productRepository->findAll();

        return $this->json($products, 200, [], [
            'groups' => ['list']
        ]);

    }

    /**
     * @Route("/product/{id}", methods={"GET"}, name="product_show")
     * @IsGranted("ROLE_USER")
     *
     */
    public function show(Product $product)
    {
        return $this->json($product, 200, [], [
            'groups' => ['detail']
        ]);
    }
}
