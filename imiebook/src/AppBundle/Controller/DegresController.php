<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations

use AppBundle\Entity\Degres;
use AppBundle\Validator\DegresValidator;

class DegresController extends Controller
{

    /**
     * @Rest\View()
     * @Rest\Get("/users/{id}/degres")
     */
    public function getDegresAction(Request $request)
    {
        $user = $this->getDoctrine()
            ->getRepository(Users::class)
            ->find($request->get('id'));

        if (empty($user)) {
            return new JsonResponse(['message' => 'Not found user'], Response::HTTP_NOT_FOUND);
        }

        return $user->getDegres();
    }

}
