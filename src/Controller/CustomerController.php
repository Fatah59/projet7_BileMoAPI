<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
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
}
