<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations

use AppBundle\Entity\Experiences;
use AppBundle\Entity\Users;
use AppBundle\Validator\ExperiencesValidator;

class ExperiencesController extends Controller
{

    /**
     * @Rest\View()
     * @Rest\Get("/users/{id}/experiences")
     */
    public function getExperiencesAction(Request $request)
    {
        $user = $this->getDoctrine()
            ->getRepository(Users::class)
            ->find($request->get('id'));

        if (empty($user)) {
            return new JsonResponse(['message' => 'Experiences not found'], Response::HTTP_NOT_FOUND);
        }

        return $user->getExperiences();
    }

    /**
     * @Rest\View()
     * @Rest\Get("/experiences/{id}")
     */
    public function getDegreAction(Request $request){

        $experience = $this->getDoctrine()
            ->getRepository(Experiences::class)
            ->find($request->get('id'));
        if (empty($experience)){
            return new JsonResponse(['message' => 'Experience not found'], Response::HTTP_NOT_FOUND);
        }
        return $degre;
    }

    /**
     * @Rest\View()
     * @Rest\Post("/experiences")
     */
    public function postDegreAction(Request $request){

        $user = $this->get('security.token_storage')
            ->getToken()
            ->getUser();

        $experiences = new Experiences();
        $form = $this->createForm(ExpereincesValidator::class, $experiences);

        $form->submit($request->request->all()); // Validation des données

        if ($form->isValid()){
            $user->addExperiences($experiences);
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($user);
            $em->flush();
            return $experiences;
        }
        // if error return explication
        return $form;
    }


}
