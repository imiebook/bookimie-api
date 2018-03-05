<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations

use AppBundle\Entity\Degres;
use AppBundle\Entity\Users;
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
            return new JsonResponse(['message' => 'Degres not found'], Response::HTTP_NOT_FOUND);
        }

        return $user->getDegres();
    }

    /**
     * @Rest\View()
     * @Rest\Get("/degres/{id}")
     */
    public function getDegreAction(Request $request){

        $degre = $this->getDoctrine()
            ->getRepository(Degres::class)
            ->find($request->get('id'));   
        if (empty($degre)){
            return new JsonResponse(['message' => 'Degre not found'], Response::HTTP_NOT_FOUND);
        }
        return $degre;
    }

    /**
     * @Rest\View()
     * @Rest\Post("/degres")
     */
    public function postDegreAction(Request $request){

        $user = $this->get('security.token_storage')
            ->getToken()
            ->getUser();

        $degre = new Degres;
        $degre->setUser($user);
        $form = $this->createForm(DegresValidator::class, $degre);

        $form->submit($request->request->all()); // Validation des données

        if ($form->isValid()){
           
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($degre);
            $em->flush();
            return $degre;
        }
        // if error return explication
        return $form;
    }


}
