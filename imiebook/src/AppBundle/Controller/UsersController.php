<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations

use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\Users;
use AppBundle\Model\SearchModel;
use AppBundle\Validator\UsersValidator;
use AppBundle\Validator\SearchValidator;
use AppBundle\Service\UsersService;

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
            $user->setExperiences(new ArrayCollection());
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
        $user->setExperiences(new ArrayCollection());

        return $user;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/resetpassword/{email}")
     */
     public function getResetPasswordRequestAction(Request $request, \Swift_Mailer $mailer)
     {
         $email = $request->get('email');
         $userManager = $this->get('fos_user.user_manager');
         $user = $userManager->findUserByEmail($email);
         if (null === $user) {
             throw $this->createNotFoundException();
         }

         $usersService = $this->get('users_service');
         // reset password with randum string and notify by mail this user
         $usersService->resetPasswordUser($user);

         return new JsonResponse(['message' => 'Password is reset.'], Response::HTTP_OK);
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

        return new JsonResponse(['message' => 'Success of delete request'], Response::HTTP_OK);
    }

    /**
     * @Rest\View()
     * @Rest\Post("/users/search")
     */
    public function searchUserAction(Request $request)
    {
        $search = new SearchModel();
        $form = $this->createForm(SearchValidator::class, $search);

        $form->submit($request->request->all()); // Validation des données

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $users = $em->getRepository('AppBundle:Users')
                ->search($search, $this->container->get('fos_elastica.finder.app.user'));

            $tabUsers = [];
            foreach($users as $user) {
                $tabUsers[] = [
                    'id' => $user->getId(),
                    'surname' => $user->getSurname(),
                    'lastname' => $user->getLastname(),
                    'email' => $user->getEmail()
                ];
            }

            return $tabUsers;
        }

        return new JsonResponse(['message' => 'No data'], Response::HTTP_NO_CONTENT);
    }

}
