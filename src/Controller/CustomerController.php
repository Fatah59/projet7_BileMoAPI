<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    public function __construct(EntityManagerInterface $entityManager, CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->entityManager = $entityManager;
    }

    /**
 * @Route("/customer", methods={"GET"}, name="customer_list")
 */
    public function list()
    {
        $customers =$this->customerRepository->findAll();

        return $this->json($customers, 200, [], [
            'groups' => ['list']
        ]);
    }

    /**
     * @Route("/customer/{id}", methods={"GET"}, name="customer_show")
     *
     */
    public function show(Customer $customer)
    {
        return $this->json($customer, 200, [], [
            'groups' => ['detail']
        ]);
    }

    /**
     * @Route("/customer", methods={"POST"}, name="customer_create")
     *
     */
    public function create(Request $request)
    {
        $customer = new Customer();
        $customerType = $this->createForm(CustomerType::class, $customer);

        $requestData = json_decode($request->getContent(), true);

        if ($requestData === null){
            return $this->json(['message' => 'invalid json'], 400);
        }

        $customerType->submit($requestData);

        if (!($customerType->isSubmitted() && $customerType->isValid())){
            return $this->json(['message' => 'Bad Request'], 400);
        }

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return $this->json($customer, 201, [], [
            'groups' => ['detail']
        ]);
    }

    /**
     * @Route("/customer/{id}", methods={"DELETE"}, name="customer_delete")
     *
     */
    public function delete(Customer $customer)
    {
        $this->entityManager->remove($customer);
        $this->entityManager->flush();

        return $this->json([]);
    }
}
