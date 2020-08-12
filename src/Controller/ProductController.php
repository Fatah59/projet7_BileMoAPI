<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class ProductController extends AbstractController
{
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(ProductRepository $productRepository, SerializerInterface $serializer)
    {
        $this->productRepository = $productRepository;
        $this->serializer = $serializer;
    }

    /**
     * Get product list
     * @Route("/product", methods={"GET"}, name="product_list")
     * @IsGranted("ROLE_USER")
     * @SWG\Parameter(
     *     name="page",
     *     description="The product list",
     *     in="query",
     *     type="integer"
     * )
     * @SWG\Response(
     *     response="200",
     *     description="OK",
     *     @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type=Product::class, groups = {"list"}))
     *      )
     * )
     * @SWG\Tag(name="Product")
     *
     */
    public function list(SerializerInterface $serializer)
    {
        $products = $this->productRepository->findAll();

        $json = $serializer->serialize($products, 'json', SerializationContext::create()->setGroups(array('list')));

        return new JsonResponse($json, 200, [], true);

    }

    /**
     * Get details about a specific product
     * @Route("/product/{id}", methods={"GET"}, name="product_show")
     * @IsGranted("ROLE_USER")
     * @SWG\Parameter(
     *     name="id",
     *     description="Id of the product to get",
     *     in="path",
     *     required=true,
     *     type="integer"
     * )
     * @SWG\Response(
     *     response="200",
     *     description="OK",
     *     @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type=Product::class, groups = {"detail"}))
     *      )
     * )
     * @SWG\Tag(name="Product")
     *
     */
    public function show(SerializerInterface $serializer, Product $product)
    {
        $json = $serializer->serialize($product, 'json', SerializationContext::create()->setGroups(array('detail')));

        return new JsonResponse($json, 200, [], true);
    }
}
