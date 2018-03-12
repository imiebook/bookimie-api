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
    public function getExperienceAction(Request $request){

        $experience = $this->getDoctrine()
            ->getRepository(Experiences::class)
            ->find($request->get('id'));
        if (empty($experience)){
            return new JsonResponse(['message' => 'Experience not found'], Response::HTTP_NOT_FOUND);
        }
        return $experience;
    }

    /**
     * @Rest\View()
     * @Rest\Post("/experiences")
     */
    public function postExperiencesAction(Request $request){

        $user = $this->get('security.token_storage')
            ->getToken()
            ->getUser();

        $experiences = new Experiences();
        $form = $this->createForm(ExperiencesValidator::class, $experiences);

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

    /**
     * @Rest\View()
     * @Rest\Put("/experiences/{id}")
     */
    public function putExperiencesAction(Request $request){

        $user = $this->get('security.token_storage')
            ->getToken()
            ->getUser();

        // find experiences in list experiences of user
        $experiences = null;
        for ($i = 0; $i < sizeof($user->getExperiences()); $i++) {
            if ($user->getExperiences()[$i]->getId() == $request->get('id')) {
                $experiences = $user->getExperiences()[$i];
            }
        }
        // no experiences return 404
        if ($experiences == null) {
            return new JsonResponse(['message' => 'Experience not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(ExperiencesValidator::class, $experiences);
        // Validate data
        // Keep last data if no new data is present in request
        $form->submit($request->request->all(), false);

        if ($form->isValid()){
            $em = $this->get('doctrine.orm.entity_manager');
            $em->merge($experiences);
            $em->flush();
            return $experiences;
        }
        // if error return explication
        return $form;
    }

    /**
     * @Rest\View()
     * @Rest\Delete("/experiences/{id}")
     */
    public function deleteExperiencesAction(Request $request){

        $user = $this->get('security.token_storage')
            ->getToken()
            ->getUser();

        // find experiences in list experiences of user
        $experiences = null;
        for ($i = 0; $i < sizeof($user->getExperiences()); $i++) {
            if ($user->getExperiences()[$i]->getId() == $request->get('id')) {
                $experiences = $user->getExperiences()[$i];
            }
        }
        // no experiences return 404
        if ($experiences == null) {
            return new JsonResponse(['message' => 'Experience not found'], Response::HTTP_NOT_FOUND);
        }
        // remove experience in liste of user experiences
        $user->removeExperiences($experiences);
        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($user);
        $em->flush();

        return new JsonResponse(['message' => 'Success of delete request'], Response::HTTP_OK);
    }


}
