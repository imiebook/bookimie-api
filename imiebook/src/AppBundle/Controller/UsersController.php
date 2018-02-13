<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations

use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\Users;
use AppBundle\Validator\UsersValidator;

class UsersController extends Controller
{

    /**
     * @Rest\View()
     * @Rest\Get("/users")
     */
    public function getUsersAction(Request $request)
    {
        $users = $this->getDoctrine()
            ->getRepository(Users::class)
            ->findAll();
        $tabUsers = [];

        foreach($users as $key => $user) {
            // hide children relation
            $user->setDegres(new ArrayCollection());
            $tabUsers[] = $user;
        }

        return $users;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/users/{id}")
     */
    public function getUserAction(Request $request)
    {
        $user = $this->getDoctrine()
            ->getRepository(Users::class)
            ->find($request->get('id'));

        if (empty($user)) {
            return new JsonResponse(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
        }

        // hide children relation
        $user->setDegres(new ArrayCollection());
        
        return $user;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/users")
     */
    public function postUserAction(Request $request)
    {
        $user = new Users();
        $form = $this->createForm(UsersValidator::class, $user);

        $form->submit($request->request->all()); // Validation des données

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($user);
            $em->flush();
            return $user;
        }
        // if error return explication
        return $form;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/users/{id}")
     */
    public function removeUserAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('AppBundle:Users')
            ->find($request->get('id'));

        if (empty($user)) {
            return new JsonResponse(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($user);
        $em->flush();
    }

}
