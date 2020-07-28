<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login_check", name="api_login")
     * @return JsonResponse
     */
    public function api_login(): JsonResponse
    {
        $partner = $this->getUser();

        return new JsonResponse([
            'username' => $partner->getUsername(),
            'roles' => $partner->getRoles(),
        ]);
    }
}
