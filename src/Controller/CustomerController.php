<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Exception\BadFormException;
use App\Exception\BadJsonException;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        EntityManagerInterface $entityManager,
        CustomerRepository $customerRepository,
        SerializerInterface $serializer
    ) {
        $this->customerRepository = $customerRepository;
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    /**
     * List of customers
     * @Route("/customer",
     *     name="customer_list",
     *     methods={"GET"})
     * @SWG\Parameter(
     *     name="page",
     *     description="The list of customers",
     *     in="query",
     *     type="integer"
     *  )
     * @SWG\Response(
     *     response=200,
     *     description="OK",
     *     @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type=Customer::class, groups = {"list"}))
     *     )
     * )
     * @SWG\Tag(name="Customer")
     *
     */
    public function list(SerializerInterface $serializer)
    {
        $customers =$this->customerRepository->findBy(['partner' => $this->getUser()]);

        $json = $serializer->serialize($customers, 'json', SerializationContext::create()->setGroups(array('list')));

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * Get details about a specific customer
     * @Route("/customer/show/{id}",
     *     name="customer_show",
     *     methods={"GET"})
     * @SWG\Parameter(
     *     name="id",
     *     description="Id of the customer",
     *     in="path",
     *     required=true,
     *     type="integer"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="OK",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Customer::class, groups = {"detail"}))
     *     )
     * )
     * @SWG\Tag(name="Customer")
     *
     */
    public function show(SerializerInterface $serializer, Customer $customer)
    {
        $json = $serializer->serialize($customer, 'json', SerializationContext::create()->setGroups(array('detail')));

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * Customer creation
     * @Route("/customer/create",
     *     name="customer_create",
     *     methods={"POST"})
     * @SWG\Parameter(
     *     name="Customer",
     *     description="Fields to provide to create a customer",
     *     in="body",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(
     *         type="object",
     *         title="Customer field",
     *         @SWG\Property(property="firstname", type="string"),
     *         @SWG\Property(property="lastname", type="string"),
     *         @SWG\Property(property="email", type="string")
     *     )
     * )
     * @SWG\Response(
     *     response="201",
     *     description="CREATED",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Customer::class, groups = {"detail"}))
     *     )
     * )
     * @SWG\Tag(name="Customer")
     * @throws BadJsonException
     * @throws BadFormException
     */
    public function create(Request $request, SerializerInterface $serializer)
    {
        $customer = new Customer();
        $customerType = $this->createForm(CustomerType::class, $customer);

        // Json verification
        $requestData = json_decode($request->getContent(), true);
        if ($requestData === null){
            throw new BadJsonException();
        }

        // Form verification
        $customerType->submit($requestData);
        if (!($customerType->isSubmitted() && $customerType->isValid())){
            throw new BadFormException($customerType);
        }

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        $group = SerializationContext::create()->setGroups(['detail']);

        $data = $serializer->serialize($customer, 'json', $group);

        return new JsonResponse($data, 201, [], true);
    }

    /**
     * Customer deletion
     * @Route("/customer/delete/{id}",
     *     name="customer_delete",
     *     methods={"DELETE"})
     * @SWG\Parameter(
     *     name="id",
     *     description="Id of the customer to delete",
     *     in="path",
     *     required=true,
     *     type="integer"
     * )
     * @SWG\Response(
     *     response="200",
     *     description=""
     * )
     * @SWG\Tag(name="Customer")
     */
    public function delete(Customer $customer, SerializerInterface $serializer)
    {
        $this->entityManager->remove($customer);
        $this->entityManager->flush();

        $data = $serializer->serialize([], 'json');

        return new JsonResponse($data, 204, [], true);
    }
}
