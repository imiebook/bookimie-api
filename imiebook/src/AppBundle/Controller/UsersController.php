<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Users;

class UsersController extends Controller
{

    public function getUsersAction(Request $request)
    {
        $user = new Users("Erwan", "Guillet");

        return new JsonResponse($user->toArray());
    }

}
