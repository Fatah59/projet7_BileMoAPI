<?php

namespace App\Controller;

use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * Generates a JWT token
     * @Route("/login_check",
     *     name="api_login",
     *     methods={"POST"})
     * @SWG\Parameter(
     *     name="Login",
     *     description="Fields to provide to sign in and get a token",
     *     in="body",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(
     *     type="object",
     *     title="Login field",
     *     @SWG\Property(property="username", type="string"),
     *     @SWG\Property(property="password", type="string")
     * )
     * )
     * @SWG\Response(
     *     response=200,
     *     description="OK",
     *     )
     * @SWG\Tag(name="Authentification")
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
